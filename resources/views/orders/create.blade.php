<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesanan - Kedai Smart Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#423F1F] text-slate-900 antialiased">
    <div class="min-h-screen bg-red-700 p-4">
    <main class="max-w-6xl mx-auto py-4">
        <div class="flex flex-col md:flex-row items-center justify-between mb-6 bg-white p-4 rounded-2xl shadow-sm border border-slate-100 gap-4">
            <div>
                <h1 class="text-2xl font-black text-red-700 uppercase tracking-tighter">Buat <span class="text-red-900">Pesanan</span></h1>
                <p class="text-xs font-bold text-red-700 uppercase tracking-widest mt-1">Pilih menu dan jumlahnya lalu kirim ke dapur</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-100 text-slate-800 rounded-2xl font-black text-sm hover:bg-slate-200 transition">Kembali</a>
                <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-red-700 text-white rounded-2xl font-black text-sm hover:bg-red-800 transition">Daftar Pesanan</a>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-500/20 border border-red-500/50 text-red-100 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h2 class="font-black text-sm text-red-700 uppercase tracking-widest mb-4">Pilih Menu</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($menus as $menu)
                        <label class="flex items-center gap-4 bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <input type="checkbox" name="menu_id[]" value="{{ $menu->id }}" class="w-4 h-4" />
                            <div class="flex-1">
                                <div class="font-bold text-slate-800">{{ $menu->name }}</div>
                                <div class="text-[12px] text-slate-500">{{ $menu->category }} • Rp{{ number_format($menu->price,0,',','.') }}</div>
                            </div>
                            <input type="number" name="qty[]" value="1" min="1" class="w-20 px-3 py-2 rounded-xl border border-slate-200 text-center" />
                        </label>
                    @endforeach
                </div>

                <input type="hidden" name="payment_method" value="Cash">

                <div class="flex gap-3 mt-4">
                    <button type="submit" class="px-6 py-3 bg-red-700 hover:bg-red-800 text-white rounded-2xl font-black transition">Buat Pesanan</button>
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl font-black transition">Batal</a>
                </div>
            </div>
        </form>
    </main>

    <footer class="max-w-7xl mx-auto py-4 px-6 border-t-2 border-red-800 mt-4">
        <div class="flex justify-between items-center text-white"><p class="text-xs font-bold uppercase tracking-widest">&copy; Kedai Smart Pinky</p></div>
    </footer>
    </div>

    @stack('scripts')
</body>
</html>
