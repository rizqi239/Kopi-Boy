<?php

namespace App\Http\Controllers;

use App\Exports\FinancePaymentsXlsx;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected function authorizeAdmin(): void
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk mengelola pembayaran.');
        }
    }

    protected function authorizeCustomerPaymentAccess(?Payment $payment = null): void
    {
        $user = auth()->user();

        if ($user?->role === 'admin') {
            return;
        }

        if (!$user) {
            abort(403, 'Anda harus login untuk melihat pembayaran.');
        }

        if ($payment && $payment->order && $payment->order->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk melihat pembayaran ini.');
        }
    }

    public function index(Request $request)
    {
        $query = Payment::with(['order.user', 'order.items'])->latest();
        if (auth()->user()?->role !== 'admin') {
            $query->whereHas('order', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        $search = '';
        $category = 'all';
        $product = 'all';

        // Hanya role admin yang dapat menggunakan fitur filter transaksi
        if (auth()->user()?->role === 'admin') {
            $search = trim((string) $request->get('search', ''));
            $category = trim((string) $request->get('category', 'all'));
            $product = trim((string) $request->get('product', 'all'));

            // Filter pencarian invoice, pelanggan, atau nama produk
            if ($search !== '') {
                $searchLower = strtolower($search);
                $query->where(function ($q) use ($searchLower) {
                    $q->whereHas('order', function ($oq) use ($searchLower) {
                        $oq->whereRaw("LOWER(invoice) LIKE ?", ["%{$searchLower}%"])
                           ->orWhereHas('user', function ($uq) use ($searchLower) {
                               $uq->whereRaw("LOWER(name) LIKE ?", ["%{$searchLower}%"]);
                           })
                           ->orWhereHas('items', function ($iq) use ($searchLower) {
                               $iq->whereRaw("LOWER(name) LIKE ?", ["%{$searchLower}%"]);
                           });
                    });
                });
            }

            // Filter produk tertentu (misal: americano, v60, espresso, macha latte, croissant, dll)
            if ($product !== '' && strtolower($product) !== 'all') {
                $prodLower = strtolower($product);
                $query->whereHas('order.items', function ($iq) use ($prodLower) {
                    if ($prodLower === 'macha' || $prodLower === 'matcha' || $prodLower === 'macha latte' || $prodLower === 'matcha latte') {
                        $iq->where(function ($sub) {
                            $sub->whereRaw("LOWER(name) LIKE '%macha%'")
                                ->orWhereRaw("LOWER(name) LIKE '%matcha%'");
                        });
                    } elseif ($prodLower === 'v60' || $prodLower === 'v-60') {
                        $iq->where(function ($sub) {
                            $sub->whereRaw("LOWER(name) LIKE '%v60%'")
                                ->orWhereRaw("LOWER(name) LIKE '%v-60%'");
                        });
                    } elseif ($prodLower === 'pastry') {
                        $iq->where(function ($sub) {
                            $sub->whereRaw("LOWER(name) LIKE '%pastry%'")
                                ->orWhereRaw("LOWER(name) LIKE '%croissant%'")
                                ->orWhereRaw("LOWER(name) LIKE '%croffle%'")
                                ->orWhereRaw("LOWER(name) LIKE '%roti%'")
                                ->orWhereRaw("LOWER(name) LIKE '%cake%'")
                                ->orWhereRaw("LOWER(name) LIKE '%toast%'")
                                ->orWhereRaw("LOWER(name) LIKE '%brownies%'")
                                ->orWhereRaw("LOWER(name) LIKE '%cookie%'")
                                ->orWhereRaw("LOWER(name) LIKE '%donut%'")
                                ->orWhereRaw("LOWER(name) LIKE '%waffle%'")
                                ->orWhereRaw("LOWER(name) LIKE '%snack%'");
                        });
                    } else {
                        $iq->whereRaw("LOWER(name) LIKE ?", ["%{$prodLower}%"]);
                    }
                });
            }

            // Filter kategori (kopi, non-kopi, pastry)
            if ($category !== '' && strtolower($category) !== 'all') {
                $catLower = strtolower($category);
                if ($catLower === 'kopi') {
                    $query->whereHas('order.items', function ($iq) {
                        $iq->where(function ($sub) {
                            $sub->whereRaw("LOWER(name) LIKE '%kopi%'")
                                ->orWhereRaw("LOWER(name) LIKE '%coffee%'")
                                ->orWhereRaw("LOWER(name) LIKE '%espresso%'")
                                ->orWhereRaw("LOWER(name) LIKE '%americano%'")
                                ->orWhereRaw("LOWER(name) LIKE '%v60%'")
                                ->orWhereRaw("LOWER(name) LIKE '%latte%'")
                                ->orWhereRaw("LOWER(name) LIKE '%cappuccino%'");
                        })->whereRaw("LOWER(name) NOT LIKE '%macha%'")
                          ->whereRaw("LOWER(name) NOT LIKE '%matcha%'")
                          ->whereRaw("LOWER(name) NOT LIKE '%taro%'")
                          ->whereRaw("LOWER(name) NOT LIKE '%red velvet%'")
                          ->whereRaw("LOWER(name) NOT LIKE '%chocolate%'")
                          ->whereRaw("LOWER(name) NOT LIKE '%cokelat%'");
                    });
                } elseif ($catLower === 'non-kopi' || $catLower === 'non kopi') {
                    $query->whereHas('order.items', function ($iq) {
                        $iq->where(function ($sub) {
                            $sub->whereRaw("LOWER(name) LIKE '%macha%'")
                                ->orWhereRaw("LOWER(name) LIKE '%matcha%'")
                                ->orWhereRaw("LOWER(name) LIKE '%taro%'")
                                ->orWhereRaw("LOWER(name) LIKE '%red velvet%'")
                                ->orWhereRaw("LOWER(name) LIKE '%chocolate%'")
                                ->orWhereRaw("LOWER(name) LIKE '%cokelat%'")
                                ->orWhereRaw("LOWER(name) LIKE '%tea%'")
                                ->orWhereRaw("LOWER(name) LIKE '%teh%'")
                                ->orWhereRaw("LOWER(name) LIKE '%non-kopi%'")
                                ->orWhereRaw("LOWER(name) LIKE '%non kopi%'");
                        });
                    });
                } elseif ($catLower === 'pastry') {
                    $query->whereHas('order.items', function ($iq) {
                        $iq->where(function ($sub) {
                            $sub->whereRaw("LOWER(name) LIKE '%pastry%'")
                                ->orWhereRaw("LOWER(name) LIKE '%croissant%'")
                                ->orWhereRaw("LOWER(name) LIKE '%croffle%'")
                                ->orWhereRaw("LOWER(name) LIKE '%roti%'")
                                ->orWhereRaw("LOWER(name) LIKE '%cake%'")
                                ->orWhereRaw("LOWER(name) LIKE '%toast%'")
                                ->orWhereRaw("LOWER(name) LIKE '%brownies%'")
                                ->orWhereRaw("LOWER(name) LIKE '%cookie%'")
                                ->orWhereRaw("LOWER(name) LIKE '%donut%'")
                                ->orWhereRaw("LOWER(name) LIKE '%waffle%'")
                                ->orWhereRaw("LOWER(name) LIKE '%snack%'");
                        });
                    });
                }
            }
        }

        $payments = $query->paginate(12)->withQueryString();

        // Ambil daftar menu untuk opsi filter dropdown & pastry apa saja yang ada
        $availableMenus = collect();
        $pastryMenus = collect();
        try {
            $availableMenus = Menu::select('id', 'name', 'category')->orderBy('name')->get();
            $pastryWords = ['croissant', 'croffle', 'pastry', 'roti', 'cake', 'toast', 'kentang', 'donut', 'brownies', 'cookie', 'cookies', 'pie', 'waffle', 'danish', 'muffin'];
            $pastryMenus = $availableMenus->filter(function ($m) use ($pastryWords) {
                $cat = strtolower((string) ($m->category ?? ''));
                $name = strtolower((string) ($m->name ?? ''));
                if (str_contains($cat, 'pastry') || str_contains($cat, 'snack') || str_contains($cat, 'makanan') || str_contains($cat, 'bakery') || str_contains($cat, 'roti')) {
                    return true;
                }
                foreach ($pastryWords as $pw) {
                    if (str_contains($name, $pw)) {
                        return true;
                    }
                }
                return false;
            });
        } catch (\Throwable $e) {
            // fallback gracefully
        }

        return view('payments.index', compact('payments', 'availableMenus', 'pastryMenus', 'search', 'category', 'product'));
    }

    public function finance()
    {
        $this->authorizeAdmin();

        $completedPayments = Payment::query()
            ->whereNotNull('order_id')
            ->where('status', 'completed');

        $financeSummary = [
            'revenue' => (clone $completedPayments)->sum('amount'),
            'transactions' => (clone $completedPayments)->count(),
            'expenses' => Expense::sum('amount'),
            'expenseCount' => Expense::count(),
        ];
        $financeSummary['balance'] = $financeSummary['revenue'] - $financeSummary['expenses'];

        $payments = $completedPayments
            ->with(['order.user', 'order.items'])
            ->latest('paid_at')
            ->paginate(15, ['*'], 'payments_page');
        $expenses = Expense::with('user')
            ->latest('expense_date')
            ->latest('id')
            ->paginate(15, ['*'], 'expenses_page');

        return view('management.finance', compact('financeSummary', 'payments', 'expenses'));
    }

    public function exportFinance(FinancePaymentsXlsx $exporter)
    {
        $this->authorizeAdmin();

        $payments = Payment::query()
            ->whereNotNull('order_id')
            ->where('status', 'completed')
            ->with(['order.user', 'order.items'])
            ->latest('paid_at')
            ->get();

        $rows = [[
            'Invoice',
            'Pelanggan',
            'Produk',
            'Waktu Dibayar',
            'Metode',
            'Pemasukan (Rp)',
        ]];

        foreach ($payments as $payment) {
            $rows[] = [
                $payment->order->invoice,
                $payment->order->user?->name ?? 'Pelanggan dihapus',
                $payment->order->items
                    ->map(fn ($item) => $item->name . ' x ' . $item->quantity)
                    ->implode(', ') ?: '—',
                \Illuminate\Support\Carbon::parse($payment->paid_at ?? $payment->created_at)
                    ->format('Y-m-d H:i:s'),
                $payment->method ?? '—',
                (float) $payment->amount,
            ];
        }

        $path = $exporter->export($rows);

        return response()
            ->download($path, 'riwayat-pemasukan-' . now()->format('Y-m-d') . '.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
            ->deleteFileAfterSend(true);
    }

    public function create(Request $request)
    {
        $order = null;
        if ($request->has('order_id')) {
            $order = Order::find($request->get('order_id'));
            if (auth()->user()?->role !== 'admin' && $order && $order->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk pembayaran ini.');
            }
        }
        $menus = Menu::orderBy('created_at', 'desc')->get();
        return view('payments.create', compact('order', 'menus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        if (auth()->user()?->role !== 'admin' && !empty($data['order_id'])) {
            $order = Order::find($data['order_id']);
            if (!$order || $order->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk membayar pesanan ini.');
            }
        }

        $payment = Payment::create([
            'order_id' => $data['order_id'] ?? null,
            'amount' => $data['amount'],
            'method' => $data['method'],
            'status' => 'completed',
            'paid_at' => now(),
            'notes' => $data['notes'] ?? null,
        ]);

        if ($payment->order) {
            $order = $payment->order;
            if ($payment->amount >= $order->total) {
                $order->status = 'paid';
                $order->save();
            }
        }

        return redirect()->route('payments.show', $payment)->with('success','Pembayaran berhasil disimpan.');
    }

    public function show(Payment $payment)
    {
        $this->authorizeCustomerPaymentAccess($payment);

        $payment->load('order.items');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $this->authorizeAdmin();

        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $payment->order_id = $data['order_id'] ?? null;
        $payment->amount = $data['amount'];
        $payment->method = $data['method'];
        $payment->status = $data['status'];
        $payment->notes = $data['notes'] ?? null;

        if ($data['status'] === 'completed' && !$payment->paid_at) {
            $payment->paid_at = now();
        }
        if ($data['status'] !== 'completed') {
            $payment->paid_at = null;
        }

        $payment->save();

        // Sync order status if linked
        if ($payment->order) {
            $order = $payment->order;
            if ($payment->status === 'completed' && $payment->amount >= $order->total) {
                $order->status = 'paid';
            } else {
                $order->status = 'pending';
            }
            $order->save();
        }

        return redirect()->route('payments.show', $payment)->with('success','Pembayaran diperbarui.');
    }

    public function destroy(Payment $payment)
    {
        $this->authorizeAdmin();

        $payment->delete();
        return redirect()->route('payments.index')->with('success','Pembayaran dihapus.');
    }
}
