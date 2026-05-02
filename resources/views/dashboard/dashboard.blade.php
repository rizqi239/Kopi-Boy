<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kedai Smart Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .nav-glass {
            background: rgb(255, 255, 255);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(244, 114, 182, 0.1);
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #f87171; }
    </style>
</head>
<body class="bg-[#353535] text-slate-900 antialiased">

    <div class="min-h-screen bg-red-700 p-4">
        <!-- Header Area -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-6 bg-white p-4 rounded-2xl shadow-sm border border-slate-100 gap-4">
            <div class="flex items-center gap-4">
                <div class="bg-red-700 p-2 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8h2.5V2c-2.76 0-5 2.24-5 4z"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-red-700 uppercase tracking-widest">Kedai Smart Pinky</h1>
                    <p class="text-xs font-bold text-red-700 uppercase tracking-widest">Kedai Pinky — Point of Sale</p>
                </div>
            </div>
            
            <!-- Bisnis Process Flow (Updated) -->
            <div class="hidden lg:flex items-center gap-2 bg-slate-100 p-2 rounded-xl border border-slate-200">
                <a href="{{ route('orders.create') }}" class="px-3 py-1 bg-red-700 text-white text-[10px] font-black rounded-lg uppercase hover:bg-red-800 transition">Pemesanan</a>
                <a href="{{ route('menus.index') }}" class="ml-2 px-3 py-1 bg-red-700 text-white rounded-lg text-xs font-black hover:bg-red-800 transition shadow-sm">Menu</a>
                
                <span class="text-slate-400 font-bold mx-1">→</span>
                
                <!-- Button Konfirmasi Baru -->
                <a href="{{ route('orders.index') }}" class="px-3 py-1 bg-red-700 text-white border border-pink-200 hover:bg-red-800 text-[10px] font-black rounded-lg uppercase transition shadow-sm">
                    Order
                </a>
                
                <span class="text-slate-400 font-bold mx-1">→</span>
                
                <a href="{{ route('payments.index') }}" class="px-3 py-1 bg-red-700 text-white text-[10px] font-black rounded-lg uppercase border border-pink-200 hover:bg-red-800 transition">Pembayaran</a>
            </div>

            <div class="flex items-center gap-3">
                <div id="current-datetime" class="text-sm font-mono font-bold text-slate-600 bg-slate-100 px-4 py-2 rounded-lg"></div>
                <a href="{{ route('dashboard.koneksi') }}" class="px-3 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-black hover:bg-red-50 hover:text-red-600 transition">Test Koneksi</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-3 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-black hover:bg-red-50 hover:text-red-600 transition">Logout</button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Products Section -->
            <div class="lg:col-span-8">
                <div class="mb-6">
                    <div class="flex items-center justify-between gap-4 mb-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('dashboard') }}" class="px-3 py-1 rounded-full text-sm font-black hover:bg-red-800 hover:text-white transition {{ empty($category) ? 'bg-red-700 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">Semua</a>
                            <a href="{{ route('dashboard', ['category' => 'Makanan']) }}" class="px-3 py-1 rounded-full text-sm font-black hover:bg-red-800 hover:text-white transition {{ (isset($category) && $category === 'Makanan') ? 'bg-red-700 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">Makanan</a>
                            <a href="{{ route('dashboard', ['category' => 'Minuman']) }}" class="px-3 py-1 rounded-full text-sm font-black hover:bg-red-800 hover:text-white transition {{ (isset($category) && $category === 'Minuman') ? 'bg-red-700 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">Minuman</a>
                        </div>
                        <div class="text-sm text-white font-medium">Menampilkan: <span class="font-black text-white">{{ $category ?? 'Semua' }}</span></div>
                    </div>

                    <input id="search" type="text" placeholder="Cari menu favorit pelanggan..." class="w-full px-6 py-4 rounded-2xl border-2 border-slate-200 focus:border-red-700 focus:ring-0 outline-none shadow-sm transition-all font-bold text-slate-700" />
                </div>

                <div id="products" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @forelse($latestMenus ?? [] as $menu)
                        <div class="bg-white rounded-2xl border-2 border-slate-100 p-4 shadow-sm flex flex-col hover:border-red-200 transition-all">
                            <div class="flex gap-4 mb-4">
                                <div class="w-32 h-32 shrink-0 overflow-hidden rounded-xl bg-slate-100 border border-slate-100">
                                    @if($menu->image)
                                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="h-full w-full object-cover" />
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-slate-300 text-[10px] font-black uppercase">No Pic</div>
                                    @endif
                                </div>
                                <div class="flex flex-col justify-between py-1">
                                    <div>
                                        <h3 class="font-black text-xl text-slate-900 leading-tight uppercase">{{ $menu->name }}</h3>
                                        <span class="text-[10px] font-black text-red-600 bg-red-50 px-2 py-0.5 rounded uppercase">{{ $menu->category }}</span>
                                    </div>
                                    <div class="text-2xl font-black text-slate-800 tracking-tighter">
                                        Rp{{ number_format($menu->price,0,',','.') }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="flex items-center bg-slate-100 rounded-xl p-1 border-2 border-slate-200">
                                    <button type="button" data-action="dec" data-id="{{ $menu->id }}" class="w-10 h-10 flex items-center justify-center text-xl font-black text-slate-600 hover:text-red-700">-</button>
                                    <input data-qty-input="{{ $menu->id }}" value="1" min="1" readonly class="w-10 text-center bg-transparent font-black text-lg focus:outline-none text-slate-800" />
                                    <button type="button" data-action="inc" data-id="{{ $menu->id }}" class="w-10 h-10 flex items-center justify-center text-xl font-black text-slate-600 hover:text-red-700">+</button>
                                </div>
                                <button type="button" data-add data-id="{{ $menu->id }}" data-name="{{ $menu->name }}" data-price="{{ $menu->price }}" class="flex-1 py-4 bg-red-800 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-900 shadow-md active:scale-95 transition-all">
                                    Tambahkan Ke Order
                                </button>
                                <form action="{{ route('orders.quick_store') }}" method="POST" class="ml-2">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit" class="px-3 py-2 bg-emerald-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-emerald-700">Pesan Sekarang</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20 bg-white rounded-3xl border-4 border-dashed border-slate-100 text-slate-300 font-black uppercase tracking-widest text-xl">Menu Tidak Ditemukan</div>
                    @endforelse
                </div>
            </div>

            <!-- Cart Sidebar -->
            <div class="lg:col-span-4">
                <div class="sticky top-6 flex flex-col gap-4">
                    <div class="bg-white rounded-3xl border-2 border-slate-100 p-6 shadow-xl">
                        <div class="flex items-center justify-between mb-6 border-b pb-4">
                            <h3 class="font-black uppercase tracking-tight text-lg text-slate-800">Ringkasan Order</h3>
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-[10px] font-black uppercase">Meja: Take Away</span>
                        </div>

                        <div id="cart-list" class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar min-h-[100px]">
                            <div class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] text-center py-10">Belum Ada Pesanan</div>
                        </div>

                        <form id="cart-form" action="{{ route('orders.store') }}" method="POST" class="mt-6 pt-6 border-t-2 border-dashed border-slate-100">
                            @csrf
                            <div id="hidden-inputs"></div>
                            <input type="hidden" name="payment_method" value="Cash">

                            <div class="grid grid-cols-2 gap-3">
                                <button type="submit" class="w-full py-4 col-span-1 bg-emerald-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all active:scale-95">
                                    <span>Proses Ke Dapur</span>
                                </button>

                                <button type="submit" name="redirect" value="dashboard" class="w-full py-4 col-span-1 bg-slate-800 text-white rounded-2xl font-black uppercase tracking-[0.2em] shadow-sm hover:bg-slate-900 transition-all active:scale-95">
                                    <span>Selesai & Dashboard</span>
                                </button>
                            </div>
                        </form>
                        
                        <button id="clear-cart" class="mt-4 w-full text-[10px] font-black text-slate-950 uppercase tracking-widest hover:text-red-600 transition-colors">Reset Pesanan</button>
                    </div>

                </div>
            </div>
        </div>

    <script>
        (function(){
            const cart = {};

            function renderCart(){
                const list = document.getElementById('cart-list');
                const hidden = document.getElementById('hidden-inputs');
                list.innerHTML = '';
                hidden.innerHTML = '';

                const keys = Object.keys(cart);
                if(!keys.length){
                    list.innerHTML = '<div class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] text-center py-10">Belum Ada Pesanan</div>';
                    return;
                }

                let total = 0;
                keys.forEach(id => {
                    const it = cart[id];
                    total += it.price * it.qty;

                    const row = document.createElement('div');
                    row.className = 'flex items-center justify-between bg-slate-50 p-4 rounded-2xl border border-slate-100 transition-all';
                    row.innerHTML = `
                        <div class="flex-1">
                            <div class="text-xs font-black text-slate-800 uppercase leading-tight">${it.name}</div>
                            <div class="text-[10px] text-red-600 font-black">Rp${Number(it.price).toLocaleString('id-ID')}</div>
                        </div>
                        <div class="flex items-center gap-3 bg-white px-3 py-1 rounded-full shadow-sm border border-slate-100">
                            <button data-dec data-id="${id}" class="font-black text-slate-400 hover:text-red-700">-</button>
                            <div class="font-black text-xs text-slate-900 w-4 text-center">${it.qty}x</div>
                            <button data-inc data-id="${id}" class="font-black text-slate-400 hover:text-red-700">+</button>
                        </div>
                        <div class="ml-4 text-right">
                            <div class="text-xs font-black text-slate-800">Rp${(it.price * it.qty).toLocaleString('id-ID')}</div>
                        </div>
                    `;
                    list.appendChild(row);

                    const inMenu = document.createElement('input');
                    inMenu.type = 'hidden'; inMenu.name = 'menu_id[]'; inMenu.value = id;
                    hidden.appendChild(inMenu);
                    const inQty = document.createElement('input');
                    inQty.type = 'hidden'; inQty.name = 'qty[]'; inQty.value = it.qty;
                    hidden.appendChild(inQty);
                });

                const totalDiv = document.createElement('div');
                totalDiv.className = 'mt-4 pt-4 border-t-4 border-double border-slate-100 space-y-1';
                totalDiv.innerHTML = `
                    <div class="flex justify-between items-center text-slate-400">
                        <span class="text-[10px] font-black uppercase">Subtotal</span>
                        <span class="text-xs font-black text-slate-600">Rp${total.toLocaleString('id-ID')}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-black text-slate-800 uppercase tracking-tighter">Total Akhir</span>
                        <span class="text-2xl font-black text-red-700 tracking-tighter">Rp${total.toLocaleString('id-ID')}</span>
                    </div>
                `;
                list.appendChild(totalDiv);
            }

            document.addEventListener('click', function(e){
                const addBtn = e.target.closest('[data-add]');
                if(addBtn){
                    const id = addBtn.getAttribute('data-id');
                    const name = addBtn.getAttribute('data-name');
                    const price = Number(addBtn.getAttribute('data-price'));
                    const qtyInput = document.querySelector('[data-qty-input="' + id + '"]');
                    const qty = Number(qtyInput.value) || 1;

                    if(!cart[id]) cart[id] = { id, name, price, qty };
                    else cart[id].qty += qty;
                    renderCart(); return;
                }

                const inc = e.target.closest('[data-action="inc"]');
                const dec = e.target.closest('[data-action="dec"]');
                if(inc){
                    const el = document.querySelector('[data-qty-input="' + inc.getAttribute('data-id') + '"]');
                    el.value = Number(el.value) + 1;
                }
                if(dec){
                    const el = document.querySelector('[data-qty-input="' + dec.getAttribute('data-id') + '"]');
                    el.value = Math.max(1, Number(el.value) - 1);
                }

                const cartInc = e.target.closest('[data-inc]');
                const cartDec = e.target.closest('[data-dec]');
                if(cartInc){
                    cart[cartInc.getAttribute('data-id')].qty += 1; renderCart();
                }
                if(cartDec){
                    const id = cartDec.getAttribute('data-id');
                    cart[id].qty = Math.max(1, cart[id].qty - 1);
                    if(cart[id].qty === 0) delete cart[id];
                    renderCart();
                }
            });

            const clearBtn = document.getElementById('clear-cart');
            if(clearBtn) clearBtn.addEventListener('click', () => { Object.keys(cart).forEach(k => delete cart[k]); renderCart(); });

            const search = document.getElementById('search');
            if(search) search.addEventListener('input', (e) => {
                const q = e.target.value.toLowerCase();
                document.querySelectorAll('#products > div').forEach(card => {
                    const name = (card.querySelector('h3')?.innerText || '').toLowerCase();
                    card.style.display = name.includes(q) ? 'flex' : 'none';
                });
            });

            function updateClock(){
                const el = document.getElementById('current-datetime');
                if(el) el.textContent = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            }
            setInterval(updateClock, 1000); updateClock();
            renderCart();
        })();
    </script>

    <footer class="max-w-7xl mx-auto py-4 px-6 border-t-2 border-red-800 mt-4">
        <div class="flex justify-between items-center text-white">
            <p class="text-xs font-bold uppercase tracking-widest">&copy; Kedai Smart Pinky</p>
        </div>
    </footer>
    </div>
</body>
</html>