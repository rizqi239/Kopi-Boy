<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pembayaran - Kedai Pinky Smart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900 antialiased" 
      x-data="{ 
        selectedMethod: '{{ strtolower($payment->method) }}',
        akun: {
            'qris': { nama: 'Kedai Pinky Smart', nomor: 'Scan QR di bawah' },
            'ewallet': { nama: 'Rizqi Ramadhan', nomor: 'DANA: 0812XXXXXX' },
            'transfer': { nama: 'Rizqi Ramadhan', nomor: 'BSI: 7123XXXXXX' },
            'cash': { nama: '-', nomor: 'Bayar di Kasir' }
        }
      }">

    <main class="max-w-3xl mx-auto py-12 px-6">
        
        <!-- HEADER -->
        <header class="mb-10">
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('payments.index') }}" class="group flex items-center gap-3 text-slate-400 hover:text-red-600 transition-all duration-300">
                    <div class="w-10 h-10 bg-white rounded-2xl flex items-center justify-center border border-slate-100 shadow-sm group-hover:border-red-100 group-hover:bg-red-50 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em]">Daftar Pembayaran</span>
                </a>
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Admin Panel • Polbis</p>
            </div>

            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900">Edit Transaksi<span class="text-red-600">.</span></h1>
        </header>

        <!-- FORM CARD -->
        <div class="bg-white rounded-[3rem] border border-slate-100 p-8 md:p-10 shadow-xl shadow-slate-200/50 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-600 to-red-400"></div>

            <form action="{{ route('payments.update', $payment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Kolom Kiri: Input Data -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Jumlah Pembayaran</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-6 flex items-center font-black text-red-600">Rp</span>
                                <input type="number" name="amount" required 
                                    class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-[1.5rem] focus:border-red-500 focus:bg-white outline-none transition-all font-black text-xl text-slate-800 shadow-sm" 
                                    value="{{ old('amount', $payment->amount) }}" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Metode Bayar</label>
                            <div class="relative">
                                <select name="method" x-model="selectedMethod" 
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-[1.5rem] focus:border-red-500 focus:bg-white outline-none transition-all font-bold text-slate-700 appearance-none shadow-sm cursor-pointer">
                                    <option value="cash">💵 Cash / Tunai</option>
                                    <option value="qris">📱 QRIS</option>
                                    <option value="ewallet">💳 E-Wallet (DANA)</option>
                                    <option value="transfer">🏦 Bank Transfer</option>
                                </select>
                                <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Status</label>
                            <select name="status" class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-[1.5rem] focus:border-red-500 focus:bg-white outline-none transition-all font-bold text-slate-700 appearance-none shadow-sm cursor-pointer">
                                <option value="completed" {{ $payment->status == 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                                <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Visual QR & Rekening (Hanya tampil jika bukan Cash) -->
                    <div class="bg-slate-50 rounded-[2.5rem] p-6 border border-slate-100 flex flex-col items-center justify-center text-center"
                         x-show="selectedMethod !== 'cash'" x-transition>
                        
                        <div x-show="selectedMethod === 'qris'" class="mb-4">
                            <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-200 inline-block">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=KEDAI-PINKY-SMART" alt="QRIS" class="w-32 h-32 rounded-lg">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <p class="text-[9px] font-black text-red-600 uppercase tracking-widest" x-text="selectedMethod"></p>
                            <p class="text-md font-black text-slate-800" x-text="akun[selectedMethod]?.nomor"></p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase" x-text="'a/n ' + akun[selectedMethod]?.nama"></p>
                        </div>
                    </div>

                    <!-- Placeholder Jika Cash -->
                    <div class="bg-slate-50 rounded-[2.5rem] border border-dashed border-slate-200 flex items-center justify-center p-6"
                         x-show="selectedMethod === 'cash'" x-transition>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pembayaran Tunai</p>
                    </div>
                </div>

                <!-- Catatan -->
                <div class="mb-10">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 px-1">Catatan</label>
                    <textarea name="notes" class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-50 rounded-[1.5rem] focus:border-red-500 focus:bg-white outline-none transition-all font-medium text-slate-700 shadow-sm" rows="2">{{ old('notes', $payment->notes) }}</textarea>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="flex-1 px-8 py-5 bg-slate-900 text-white rounded-[1.5rem] font-black uppercase tracking-widest text-xs shadow-xl hover:bg-red-600 transition-all active:scale-[0.98]">
                        Update Data
                    </button>
                    <a href="{{ route('payments.index') }}" class="px-8 py-5 bg-slate-100 text-slate-400 rounded-[1.5rem] font-black uppercase tracking-widest text-xs hover:bg-slate-200 text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>

</body>
</html>