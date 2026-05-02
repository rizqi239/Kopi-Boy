<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan - Kedai Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#fcfcfd] text-slate-900 antialiased">
    <main class="max-w-7xl mx-auto py-10 px-6">
        <div class="p-6">
            <h1 class="text-2xl font-extrabold text-slate-900 mb-6">Edit Pesanan - {{ $order->invoice }}</h1>

            <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm max-w-xl">
                <form action="{{ route('orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-600 mb-2">Metode Pembayaran</label>
                        <input type="text" name="payment_method" value="{{ old('payment_method', $order->payment_method) }}" class="w-full px-4 py-3 rounded-2xl border border-slate-200" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-600 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-3 rounded-2xl border border-slate-200">
                            @php $s = old('status', $order->status); @endphp
                            <option value="pending" {{ $s === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $s === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="completed" {{ $s === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $s === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <button class="px-6 py-3 bg-emerald-500 text-white rounded-2xl font-black">Simpan</button>
                        <a href="{{ route('orders.index') }}" class="px-6 py-3 bg-slate-100 text-slate-700 rounded-2xl font-black">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="max-w-7xl mx-auto py-10 px-6 border-t border-slate-900">
        <div class="flex justify-between items-center text-slate-400"><p class="text-xs font-bold uppercase tracking-widest">&copy; Kedai Smart Pinky</p></div>
    </footer>

    @stack('scripts')
</body>
</html>
