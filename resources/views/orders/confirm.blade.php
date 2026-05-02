<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - Kedai Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#423F1F] text-slate-900 antialiased">
    <div class="min-h-screen bg-red-700 p-4">
    <main class="max-w-7xl mx-auto py-4">
        <div class="flex flex-col md:flex-row items-center justify-between mb-6 bg-white p-4 rounded-2xl shadow-sm border border-slate-100 gap-4">
            <div>
                <h1 class="text-2xl font-black text-red-700 uppercase tracking-tighter">Konfirmasi <span class="text-red-900">Pesanan</span></h1>
                <p class="text-xs font-bold text-red-700 uppercase tracking-widest mt-1">{{ $order->invoice }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('orders.show', $order) }}" class="px-4 py-2 bg-slate-100 text-slate-800 rounded-2xl font-black text-sm hover:bg-slate-200 transition">Kembali</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <h3 class="font-black text-sm text-slate-600 uppercase tracking-widest mb-3">Items</h3>
                    <div class="space-y-3">
                        @foreach($order->items as $it)
                            <div class="flex justify-between items-center border-t pt-3">
                                <div>
                                    <div class="font-bold text-slate-800">{{ $it->name }}</div>
                                    <div class="text-[12px] text-slate-500">{{ $it->quantity }} × Rp{{ number_format($it->price,0,',','.') }}</div>
                                </div>
                                <div class="font-black text-red-700">Rp{{ number_format($it->subtotal,0,',','.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <h3 class="font-black text-sm text-slate-600 uppercase tracking-widest mb-3">Ringkasan</h3>
                    <div class="mb-2"><span class="text-sm text-slate-500">User</span><div class="font-bold">{{ $order->user->name ?? '—' }}</div></div>
                    <div class="mb-2"><span class="text-sm text-slate-500">Metode</span><div class="font-bold">{{ $order->payment_method }}</div></div>
                    <div class="mb-2"><span class="text-sm text-slate-500">Status</span><div class="font-bold">{{ ucfirst($order->status) }}</div></div>
                    <div class="mt-4 pt-4 border-t">
                        <div class="flex justify-between items-center mb-3"><span class="text-sm text-slate-500">Total</span><div class="font-black text-red-700">Rp{{ number_format($order->total,0,',','.') }}</div></div>

                        <div class="space-y-2">
                            <a href="{{ route('payments.create', ['order_id' => $order->id]) }}" class="block text-center px-4 py-3 bg-red-700 hover:bg-red-800 text-white font-bold rounded-lg transition">Bayar Sekarang</a>

                            <form action="{{ route('orders.update', $order) }}" method="POST" onsubmit="return confirm('Tandai pesanan ini sebagai LUNAS?');">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="paid" />
                                <input type="hidden" name="payment_method" value="{{ $order->payment_method }}" />
                                <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg">Tandai Lunas</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="max-w-7xl mx-auto py-4 px-6 border-t-2 border-red-800 mt-4">
        <div class="flex justify-between items-center text-white"><p class="text-xs font-bold uppercase tracking-widest">&copy; Kedai Smart Pinky</p></div>
    </footer>
    </div>

    @stack('scripts')
</body>
</html>
