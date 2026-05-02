<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - Kedai Pinky Smart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#423F1F] text-slate-900 antialiased">
    <div class="min-h-screen bg-red-700 p-4">
    <main class="max-w-4xl mx-auto py-4">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-6 bg-white p-4 rounded-2xl shadow-sm border border-slate-100 gap-4">
            <div>
                <h1 class="text-2xl font-black text-red-700 uppercase tracking-tighter">Detail <span class="text-red-900">Pembayaran</span></h1>
                <p class="text-xs font-bold text-red-700 uppercase tracking-widest mt-1">Data arsip transaksi digital Kedai Pinky.</p>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="window.print()" class="px-4 py-2 bg-red-700 text-white rounded-2xl font-black text-sm hover:bg-red-800 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak
                </button>
                <a href="{{ route('payments.create') }}" class="px-4 py-2 bg-red-700 text-white rounded-2xl font-black text-sm hover:bg-red-800 transition">
                    Buat Baru
                </a>
                <a href="{{ route('payments.index') }}" class="px-4 py-2 bg-slate-100 text-slate-800 rounded-2xl font-black text-sm hover:bg-slate-200 transition">Kembali</a>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
            <!-- Top Status Bar -->
            <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="bg-white p-3 rounded-xl shadow-sm border border-slate-100">
                        <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">ID Pembayaran</div>
                        <div class="font-mono font-bold text-slate-700">#TRX-{{ $payment->id }}</div>
                    </div>
                </div>
                <div>
                    @if($payment->status == 'completed')
                        <span class="px-4 py-2 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full border border-emerald-100 uppercase tracking-widest">Berhasil</span>
                    @else
                        <span class="px-4 py-2 bg-amber-50 text-amber-600 text-[10px] font-black rounded-full border border-amber-100 uppercase tracking-widest">Tertunda</span>
                    @endif
                </div>
            </div>

            <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Info Utama -->
                <div class="md:col-span-2 space-y-8">
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Invoice Order</div>
                            <div class="text-sm font-bold text-slate-700">
                                {{ $payment->order->invoice ?? 'Non-Invoice' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Metode Bayar</div>
                            <div class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                <span class="uppercase">{{ $payment->method }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kasir / Admin</div>
                            <div class="text-sm font-bold text-slate-700 italic">
                                {{ $payment->order->user->name ?? 'System' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Waktu Transaksi</div>
                            <div class="text-sm font-bold text-slate-700">
                                {{ $payment->created_at->format('d M Y • H:i') }}
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-dashed border-slate-200">
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Total Nominal</div>
                        <div class="text-5xl font-black text-slate-800 tracking-tighter">
                            <span class="text-2xl text-red-700 font-bold mr-1">Rp</span>{{ number_format($payment->amount,0,',','.') }}
                        </div>
                    </div>

                    @if($payment->notes)
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Catatan:</div>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $payment->notes }}</p>
                    </div>
                    @endif
                </div>

                <!-- Action Sidebar -->
                <div class="md:col-span-1 flex flex-col gap-3">

                    <a href="{{ route('payments.index') }}" class="w-full py-4 bg-red-700 border border-slate-200 text-white rounded-xl font-black text-[10px] uppercase tracking-widest text-center hover:bg-red-800 transition-all">
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>

        <!-- Security Badge -->
        <div class="mt-8 flex justify-center">
            <div class="flex items-center gap-2 text-slate-300">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 4.925-3.467 9.043-8 10.155-4.533-1.112-8-5.23-8-10.155 0-.681.055-1.35.166-2.001zm8 2a1 1 0 00-1 1v3a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <span class="text-[9px] font-black uppercase tracking-[0.3em]">Encrypted Financial Record</span>
            </div>
        </div>
    </main>

    <footer class="max-w-7xl mx-auto py-4 px-6 border-t-2 border-red-800 mt-4">
        <div class="flex justify-between items-center text-white"><p class="text-xs font-bold uppercase tracking-widest">&copy; Kedai Smart Pinky</p></div>
    </footer>
    </div>
</body>
</html>