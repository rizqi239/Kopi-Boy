<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Kedai Smart Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#423F1F] text-slate-900 antialiased">
    <div class="min-h-screen bg-red-700 p-4">
    <main class="max-w-5xl mx-auto py-4">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row items-center justify-between mb-6 bg-white p-4 rounded-2xl shadow-sm border border-slate-100 gap-4">
            <div>
                <h1 class="text-2xl font-black text-red-700 uppercase tracking-tighter">Riwayat <span class="text-red-900">Pembayaran</span></h1>
                <p class="text-xs font-bold text-red-700 uppercase tracking-widest mt-1">Kelola dan pantau semua transaksi masuk.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-100 text-slate-800 rounded-2xl font-black text-sm hover:bg-slate-200 transition">Dashboard</a>
                <a href="{{ route('payments.create') }}" class="px-6 py-3 bg-red-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-800 transition-all shadow-lg shadow-red-100 active:scale-95">
                    Buat Pembayaran
                </a>
            </div>
        </div>

        {{-- Main Card --}}
        @include('payments._list', ['payments' => $payments])
    </main>

    <footer class="max-w-7xl mx-auto py-4 px-6 border-t-2 border-red-800 mt-4">
        <div class="flex justify-between items-center text-white">
            <p class="text-xs font-bold uppercase tracking-widest">&copy; 2026 Kedai Pinky Smart</p>
        </div>
    </footer>
    </div>

    @stack('scripts')
</body>
</html>
