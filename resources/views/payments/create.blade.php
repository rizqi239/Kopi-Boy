<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesanan - Kedai Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#423F1F] text-slate-900 antialiased" 
      x-data="{ 
        showModal: false, 
        selectedMethod: 'Cash',
        totalHarga: {{ isset($order) && $order ? $order->total : 0 }},
        // DATA REKENING RIZQI RAMADHAN
        akun: {
            'DANA': { nama: 'Rizqi Ramadhan', nomor: '081234567890' },
            'Bank BSI': { nama: 'Rizqi Ramadhan', nomor: '7123456789' },
            'Bank Mandiri': { nama: 'Rizqi Ramadhan', nomor: '123000123456' },
            'Bank BCA': { nama: 'Rizqi Ramadhan', nomor: '8901234567' },
            'QRIS': { nama: 'Kedai Pinky Smart', nomor: 'Scan QR di bawah' }
        },
        updateTotal() {
            let total = 0;
            document.querySelectorAll('.menu-checkbox:checked').forEach(el => {
                let price = el.dataset.price;
                let qty = el.closest('.menu-card').querySelector('.qty-input').value;
                total += price * qty;
            });
            this.totalHarga = total;
        }
      }">

    <div class="min-h-screen bg-red-700 p-4">
    <main class="max-w-5xl mx-auto py-4">
        
        <!-- HEADER & TOMBOL KEMBALI -->
        <header class="mb-6">
            <div class="flex items-center justify-between mb-4 px-2">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 text-white hover:text-red-200 transition-all duration-300">
                    <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm shadow-sm group-hover:bg-white/30 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em]">Kembali</span>
                </a>
                <p class="text-[10px] font-black text-white/50 uppercase tracking-[0.3em]">Kedai Smart Pinky</p>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-slate-100 gap-4">
                <div class="space-y-1">
                    <h1 class="text-2xl font-black text-red-700 uppercase tracking-tighter">Buat Pesanan<span class="text-red-900">.</span></h1>
                    <p class="text-xs font-bold text-red-700 uppercase tracking-widest mt-1">Pilih menu dan selesaikan pembayaran dengan praktis.</p>
                </div>
                
                <div class="bg-red-50 p-4 rounded-xl shadow-sm border border-red-100 min-w-[200px] flex justify-between items-center">
                    <div>
                        <p class="text-[10px] font-black text-red-500 uppercase tracking-[0.2em]">Total Tagihan</p>
                        <p class="text-xl font-black text-red-700" x-text="'Rp ' + totalHarga.toLocaleString('id-ID')"></p>
                    </div>
                </div>
            </div>
        </header>

        @if(isset($order) && $order)
            <form id="mainForm" action="{{ route('payments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}" />

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    <div class="lg:col-span-8 space-y-6">
                        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                            <h3 class="font-black uppercase text-sm text-slate-600 mb-4">Ringkasan Pesanan</h3>
                            <div class="space-y-3">
                                @foreach($order->items as $it)
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-bold text-slate-800">{{ $it->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $it->quantity }} × Rp{{ number_format($it->price,0,',','.') }}</div>
                                        </div>
                                        <div class="font-black text-pink-600">Rp{{ number_format($it->subtotal,0,',','.') }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-4">
                        <div class="bg-slate-900 rounded-4xl p-6 text-white shadow-xl">
                            <div class="mb-4 text-center">
                                <div class="text-xs font-black text-slate-300 uppercase">Total Tagihan</div>
                                <div class="text-2xl font-black text-emerald-400">Rp{{ number_format($order->total,0,',','.') }}</div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mb-6">
                                @foreach(['QRIS', 'DANA', 'Bank BSI', 'Bank Mandiri', 'Bank BCA', 'Cash'] as $method)
                                <label class="cursor-pointer">
                                    <input type="radio" name="method" value="{{ $method }}" x-model="selectedMethod" class="hidden peer">
                                    <div class="py-2 text-center rounded-xl border border-white/10 bg-white/5 font-bold text-[10px] uppercase peer-checked:bg-white peer-checked:text-slate-900 transition-all">{{ $method }}</div>
                                </label>
                                @endforeach
                            </div>

                            <label class="block text-xs text-slate-300 mb-2">Jumlah Dibayar</label>
                            <input type="number" name="amount" value="{{ $order->total }}" min="0" class="w-full mb-4 p-3 rounded-xl text-slate-900" />

                            <button type="button" @click="if(selectedMethod !== 'Cash') { showModal = true } else { document.getElementById('mainForm').submit() }" class="w-full py-3 bg-emerald-600 rounded-xl font-black hover:bg-emerald-700 transition-all">Simpan Pembayaran</button>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <form id="mainForm" action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    
                    <!-- KOLOM KIRI: MENU -->
                    <div class="lg:col-span-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($menus as $menu)
                            <label class="menu-card flex items-center gap-4 bg-white p-5 rounded-4xl border border-slate-100 cursor-pointer hover:border-red-200 transition-all duration-300 shadow-sm">
                                <input type="checkbox" name="menu_id[]" value="{{ $menu->id }}" 
                                    data-price="{{ $menu->price }}"
                                    @change="updateTotal()"
                                    class="menu-checkbox w-6 h-6 rounded-xl border-slate-200 text-red-600" />
                                
                                <div class="flex-1">
                                    <h3 class="font-bold text-slate-800">{{ $menu->name }}</h3>
                                    <p class="text-xs font-bold text-slate-400">Rp {{ number_format($menu->price,0,',','.') }}</p>
                                </div>

                                <div class="flex items-center bg-slate-50 rounded-2xl p-1" @click.stop>
                                    <input type="number" name="qty[]" value="1" min="1" @input="updateTotal()"
                                        class="qty-input w-12 bg-transparent text-center font-bold text-sm focus:outline-none" />
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- KOLOM KANAN: PAYMENT -->
                    <div class="lg:col-span-4">
                        <div class="bg-slate-900 rounded-[3rem] p-8 text-white shadow-xl shadow-slate-200">
                            <h2 class="font-bold text-xs uppercase tracking-[0.2em] mb-8 text-slate-400 text-center">Metode Pembayaran</h2>
                            <div class="grid grid-cols-2 gap-3 mb-10">
                                @foreach(['QRIS', 'DANA', 'Bank BSI', 'Bank Mandiri', 'Bank BCA', 'Cash'] as $method)
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_method" value="{{ $method }}" x-model="selectedMethod" class="hidden peer">
                                    <div class="py-3 text-center rounded-2xl border border-white/10 bg-white/5 font-bold text-[10px] uppercase peer-checked:bg-white peer-checked:text-slate-900 transition-all">
                                        {{ $method }}
                                    </div>
                                </label>
                                @endforeach
                            </div>

                            <button type="button" 
                                @click="if(totalHarga == 0) { alert('Pilih menu!'); return; } if(selectedMethod !== 'Cash') { showModal = true } else { document.getElementById('mainForm').submit() }"
                                class="w-full py-5 bg-red-600 hover:bg-red-500 text-white rounded-4xl font-black transition-all transform active:scale-95">
                                Konfirmasi Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </main>

    <!-- MODAL PEMBAYARAN: QR + NOMOR REKENING -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-md" x-transition>
        <div class="bg-white rounded-[3.5rem] p-8 max-w-sm w-full shadow-2xl border border-slate-100">
            
            <div class="text-center mb-6">
                <h3 class="text-2xl font-black text-slate-900 mb-1">Pembayaran</h3>
                <p class="text-xs text-slate-400 font-medium">Scan QR atau salin nomor rekening</p>
            </div>

            <div class="bg-[#f8fafc] rounded-[2.5rem] p-6 border border-slate-100 mb-6 text-center">
                <!-- QR Code (Hanya untuk DANA dan QRIS) -->
                <div x-show="['DANA', 'QRIS'].includes(selectedMethod)" class="bg-white p-3 rounded-3xl shadow-sm inline-block border border-slate-50 mb-6">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=KEDAI-PINKY-SMART-PAYMENT" 
                         alt="QR Scan" class="w-40 h-40 mx-auto rounded-lg">
                </div>

                <!-- Info Rekening Berdasarkan Pilihan -->
                <div class="space-y-1">
                    <p class="text-[10px] font-black text-red-600 uppercase tracking-widest" x-text="selectedMethod"></p>
                    <p class="text-lg font-black text-slate-900" x-text="akun[selectedMethod]?.nomor"></p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase" x-text="'a/n ' + akun[selectedMethod]?.nama"></p>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-200/50">
                    <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Total Tagihan</p>
                    <p class="text-xl font-black text-emerald-600" x-text="'Rp ' + totalHarga.toLocaleString('id-ID')"></p>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <button @click="document.getElementById('mainForm').submit()" 
                        class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black hover:bg-slate-800 transition-all uppercase text-xs tracking-widest">
                    Konfirmasi Sudah Bayar
                </button>
                <button @click="showModal = false" class="text-slate-400 font-bold text-[10px] uppercase tracking-widest py-2">
                    Batal / Ganti Metode
                </button>
            </div>
        </div>
    </div>

    <footer class="max-w-7xl mx-auto py-4 px-6 border-t-2 border-red-800 mt-4">
        <div class="flex justify-between items-center text-white">
            <p class="text-xs font-bold uppercase tracking-widest">&copy; 2026 Kedai Pinky Smart</p>
            <p class="text-[8px] font-bold opacity-75">Rizqi Ramadhan - TRPL Polbis</p>
        </div>
    </footer>
    </div>

</body>
</html>