<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order')->latest()->paginate(12);
        return view('payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $order = null;
        if ($request->has('order_id')) {
            $order = Order::find($request->get('order_id'));
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
        $payment->load('order');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
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
        $payment->delete();
        return redirect()->route('payments.index')->with('success','Pembayaran dihapus.');
    }
}
