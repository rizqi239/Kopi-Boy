<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected function authorizeAdmin(): void
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk mengelola pesanan.');
        }
    }

    protected function authorizeCustomerOrderAccess(?Order $order = null): void
    {
        $user = auth()->user();

        if ($user?->role === 'admin') {
            return;
        }

        if (!$user) {
            abort(403, 'Anda harus login untuk mengakses pesanan.');
        }

        if ($order && $order->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk melihat pesanan ini.');
        }
    }

    /**
     * Display a listing of unpaid orders.
     */
    public function index()
    {
        $query = Order::with(['user', 'payment'])
            ->whereDoesntHave('payment');

        if (auth()->user()?->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $orders = $query->latest()->paginate(12);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display a listing of paid orders (history).
     */
    public function history()
    {
        $query = Order::with(['user', 'payment'])->latest();

        if (auth()->user()?->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $orders = $query->paginate(12);

        return view('orders.history', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        return redirect()->route('dashboard');
    }

    /**
     * Store a newly created order in storage (multiple items).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'menu_id' => 'required|array',
            'menu_id.*' => 'required|exists:menus,id',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'payment_method' => 'required|string',
        ]);

        // keep a local copy of redirect param to decide where to send user after create
        $redirectTo = request()->get('redirect');

        return DB::transaction(function () use ($data, $redirectTo) {
            $items = [];
            $total = 0;

            foreach ($data['menu_id'] as $i => $menuId) {
                $menu = Menu::find($menuId);
                if (!$menu) continue;

                $quantity = (int) $data['qty'][$i];
                $subtotal = $menu->price * $quantity;

                $items[] = [
                    'menu_id' => $menu->id,
                    'name' => $menu->name,
                    'price' => $menu->price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }

            // Build a human-friendly invoice label from ordered item names
            $names = array_map(function($i){ return $i['name']; }, $items);
            $rawLabel = count($names) ? implode(', ', $names) : ('INV-' . date('Ymd') . '-' . Str::upper(Str::random(6)));
            $invoiceLabel = Str::limit($rawLabel, 60);

            // Ensure invoice uniqueness: if collision, append a small numeric suffix
            $finalInvoice = $invoiceLabel;
            $suffix = 1;
            while (Order::where('invoice', $finalInvoice)->exists()) {
                $finalInvoice = Str::limit($invoiceLabel . ' - ' . $suffix, 60);
                $suffix++;
            }

            $order = Order::create([
                'invoice' => $finalInvoice,
                'user_id' => Auth::id(),
                'total' => $total,
                'payment_method' => $data['payment_method'],
                'status' => 'pending',
            ]);

            foreach ($items as $it) {
                $order->items()->create($it);
            }

            if ($redirectTo === 'dashboard') {
                return redirect()->route('dashboard')->with('success', 'Order berhasil dibuat.');
            }

            return redirect()->route('payments.create', ['order_id' => $order->id])
                             ->with('success', 'Order berhasil dibuat. Silahkan bayar.');
        });
    }

    /**
     * Quick store from dashboard (single menu item).
     */
    public function quickStore(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'qty' => 'required|integer|min:1',
        ]);
        $redirectTo = $request->get('redirect');

        return DB::transaction(function () use ($request, $redirectTo) {
            $menu = Menu::findOrFail($request->menu_id);
            $subtotal = $menu->price * $request->qty;

            // Use menu name as invoice for quick single-item orders

            $rawLabel = $menu->name ?? ('INV-' . date('Ymd') . '-' . Str::upper(Str::random(6)));
            $invoiceLabel = Str::limit($rawLabel, 60);

            // Ensure unique invoice for quick orders as well
            $finalInvoice = $invoiceLabel;
            $suffix = 1;
            while (Order::where('invoice', $finalInvoice)->exists()) {
                $finalInvoice = Str::limit($invoiceLabel . ' - ' . $suffix, 60);
                $suffix++;
            }

            $order = Order::create([
                'invoice' => $finalInvoice,
                'user_id' => Auth::id(),
                'total' => $subtotal,
                'payment_method' => 'Cash',
                'status' => 'pending',
            ]);

            $order->items()->create([
                'menu_id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => $request->qty,
                'subtotal' => $subtotal,
            ]);

            if ($redirectTo === 'dashboard') {
                return redirect()->route('dashboard')->with('success', 'Pesanan ' . $menu->name . ' berhasil dibuat.');
            }

            return redirect()->route('payments.create', ['order_id' => $order->id])
                             ->with('success', 'Pesanan ' . $menu->name . ' berhasil dibuat.');
        });
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $this->authorizeCustomerOrderAccess($order);

        $order->load('items');
        return view('orders.show', compact('order'));
    }

    /**
     * Show confirmation view for an order before payment.
     */
    public function confirm(Order $order)
    {
        $this->authorizeCustomerOrderAccess($order);

        $order->load(['items', 'user']);
        return view('orders.confirm', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        $this->authorizeAdmin();

        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'payment_method' => 'required|string',
            'status' => 'required|string|in:pending,paid,completed,cancelled',
        ]);

        $order->update($data);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        $this->authorizeAdmin();

        if ($order->payment) {
            return back()->with('error', 'Tidak dapat menghapus pesanan yang sudah dibayar.');
        }

        if (method_exists($order, 'items')) {
            $order->items()->delete();
        }
        if (method_exists($order, 'payments')) {
            $order->payments()->delete();
        }

        $order->delete();

        return back()->with('success', 'Pesanan berhasil dihapus.');
    }

    // Optional: edit/update methods can be added later if needed
}