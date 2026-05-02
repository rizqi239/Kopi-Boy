<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan - Kedai Smart Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#423F1F] text-slate-900 antialiased">
    <div class="min-h-screen bg-red-700 p-4">
    <main class="max-w-7xl mx-auto py-4">
        <div class="p-6">
            <div class="flex flex-col md:flex-row items-center justify-between mb-6 bg-white p-4 rounded-2xl shadow-sm border border-slate-100 gap-4">
                <div>
                    <h1 class="text-2xl font-black text-red-700 uppercase tracking-tighter">Daftar <span class="text-red-900">Pesanan</span></h1>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-100 text-slate-800 rounded-2xl font-bold hover:bg-slate-200 transition text-sm">Dashboard</a>
                    <a href="{{ route('orders.create') }}" class="px-4 py-2 bg-red-700 text-white rounded-2xl font-bold hover:bg-red-800 transition">Buat Pesanan</a>
                </div>
            </div>

            @if($orders->count())
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-[12px] text-slate-500 uppercase tracking-widest">
                                <tr>
                                    <th class="text-left px-3 py-2">Invoice</th>
                                    <th class="text-left px-3 py-2">User</th>
                                    <th class="text-right px-3 py-2">Total</th>
                                    <th class="text-left px-3 py-2">Metode</th>
                                    <th class="text-left px-3 py-2">Status</th>
                                    <th class="text-right px-3 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr class="border-t">
                                        <td class="px-3 py-3 font-bold text-slate-800">{{ $order->invoice }}</td>
                                        <td class="px-3 py-3">{{ $order->user->name ?? '—' }}</td>
                                        <td class="px-3 py-3 text-right font-black text-red-700">Rp{{ number_format($order->total,0,',','.') }}</td>
                                        <td class="px-3 py-3">{{ $order->payment_method }}</td>
                                        <td class="px-3 py-3">{{ ucfirst($order->status) }}</td>
                                        <td class="px-3 py-3 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <a href="{{ route('orders.show', $order) }}" class="text-sm font-bold text-red-700 hover:text-red-800">Lihat</a>
                                                <form action="{{ route('payments.store') }}" method="POST" class="m-0">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <input type="hidden" name="amount" value="{{ $order->total }}">
                                                    <input type="hidden" name="method" value="{{ $order->payment_method ?? 'Cash' }}">
                                                    <button type="submit" class="text-sm font-bold text-amber-600 hover:text-amber-800 bg-transparent border-0 p-0">Konfirmasi</button>
                                                </form>
                                                <form action="{{ route('orders.destroy', $order) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm font-bold text-slate-400 hover:text-red-600">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $orders->links() }}</div>
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-slate-200 text-slate-400 font-bold uppercase tracking-widest">Belum ada pesanan</div>
            @endif
        </div>
    </main>

    <footer class="max-w-7xl mx-auto py-4 px-6 border-t-2 border-red-800 mt-4">
        <div class="flex justify-between items-center text-white">
            <p class="text-xs font-bold uppercase tracking-widest">&copy; 2026 Kedai Smart Pinky</p>
        </div>
    </footer>
    </div>

    @stack('scripts')
</body>
</html>
