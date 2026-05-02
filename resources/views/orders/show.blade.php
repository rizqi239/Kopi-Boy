<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Kedai Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#fcfcfd] text-slate-900 antialiased">
    <main class="max-w-7xl mx-auto py-10 px-6">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900">Detail Pesanan</h1>
                    <div class="text-sm text-slate-500">{{ $order->invoice }}</div>
                </div>
                <div class="flex items-center gap-3">
                    <form action="{{ route('payments.store') }}" method="POST" onsubmit="return confirm('Simpan pembayaran untuk pesanan ini?');">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="hidden" name="amount" value="{{ $order->total }}">
                        <input type="hidden" name="method" value="{{ $order->payment_method ?? 'Cash' }}">
                        <button type="submit" class="px-4 py-2 bg-amber-100 text-slate-800 rounded-2xl font-bold">Konfirmasi</button>
                    </form>
                    <a href="{{ route('orders.edit', $order) }}" class="px-4 py-2 bg-slate-100 rounded-2xl font-bold">Edit</a>
                    <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 rounded-2xl font-bold">Hapus</button>
                    </form>
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
                                <div class="font-black text-pink-600">Rp{{ number_format($it->subtotal,0,',','.') }}</div>
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
                        <div class="flex justify-between items-center"><span class="text-sm text-slate-500">Total</span><div class="font-black text-pink-600">Rp{{ number_format($order->total,0,',','.') }}</div></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="max-w-7xl mx-auto py-10 px-6 border-t border-slate-100">
        <div class="flex justify-between items-center text-slate-400"><p class="text-xs font-bold uppercase tracking-widest">&copy; 2026 Kedai Pinky Smart</p></div>
    </footer>

    @stack('scripts')
</body>
</html>
