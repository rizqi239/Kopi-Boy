<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Dashboard - Kedai Smart Brew</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --coffee: #4b2b19; --coffee-deep: #321b10; --cream: #f5edda; --cream-light: #fffaf0; --ink: #241a14; --muted: #85776c; --green: #14885e; }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--ink); background: #321b10; font-family: 'DM Sans', sans-serif; }
        .pos-shell { min-height: 100vh; padding: 16px; background: linear-gradient(110deg, rgb(36 20 12 / 88%), rgb(47 26 16 / 72%)), url('{{ asset('image/coffee-login.jpg') }}') center / cover fixed; }
        .pos-header { max-width: 1720px; min-height: 126px; margin: 0 auto; padding: 18px 20px; display: grid; grid-template-columns: 330px minmax(0, 1fr) 250px; align-items: center; gap: 24px; background: var(--cream); border: 1px solid rgb(255 255 255 / 68%); border-radius: 14px; box-shadow: 0 8px 25px rgb(0 0 0 / 12%); }
        .brand { min-width: 0; display: flex; align-items: center; gap: 18px; color: var(--coffee); }
        .brand-mark { width: 52px; height: 52px; flex: 0 0 auto; display: grid; place-items: center; color: var(--cream); background: var(--coffee); border-radius: 10px; }
        .brand-mark svg { width: 30px; height: 30px; }
        .brand-title { margin: 0; color: var(--coffee); font-size: 22px; font-weight: 800; letter-spacing: 1.4px; line-height: 1.2; text-transform: uppercase; }
        .brand-caption { margin: 4px 0 0; color: #735c49; font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; }
        .workflow { min-width: 0; display: flex; align-items: center; justify-content: flex-start; gap: 8px; padding: 8px 10px; overflow-x: auto; overflow-y: hidden; background: rgba(248, 245, 237, 0.9); border: 1px solid #e4dac8; border-radius: 14px; scrollbar-width: thin; scrollbar-color: #b77d50 transparent; }
        .workflow::-webkit-scrollbar { height: 6px; }
        .workflow::-webkit-scrollbar-thumb { background: #b77d50; border-radius: 999px; }
        .workflow a { min-height: 34px; padding: 0 16px; display: inline-flex; align-items: center; justify-content: center; flex: 0 0 auto; color: #fffaf2; background: linear-gradient(180deg, #8a1d1d 0%, #731a1a 100%); border-radius: 10px; font-size: 9px; letter-spacing: 0.06em; font-weight: 800; text-decoration: none; text-transform: uppercase; white-space: nowrap; box-shadow: 0 5px 12px rgb(88 18 18 / 18%); transition: transform 150ms ease, box-shadow 150ms ease, background 150ms ease; }
        .workflow a:hover { background: linear-gradient(180deg, #a02525 0%, #771b1b 100%); transform: translateY(-1px); box-shadow: 0 7px 14px rgb(88 18 18 / 20%); }
        .workflow-arrow { flex: 0 0 auto; display: inline-flex; align-items: center; justify-content: center; color: #6d5647; font-size: 14px; font-weight: 900; line-height: 1; }
        .header-tools { min-width: 0; display: flex; align-items: center; justify-content: flex-end; gap: 12px; }
        .clock { min-width: 112px; padding: 13px 12px; color: #38291f; background: #f8f5ed; border: 1px solid #e8dfd0; border-radius: 12px; font-size: 12px; font-variant-numeric: tabular-nums; text-align: center; }
        .header-action { min-height: 48px; padding: 0 18px; display: inline-flex; align-items: center; justify-content: center; color: #fff8ed; background: #482817; border: 0; border-radius: 12px; font: inherit; font-size: 12px; font-weight: 800; text-decoration: none; white-space: nowrap; cursor: pointer; transition: background 150ms ease; }
        .header-action:hover { background: #684329; }
        .header-tools form { margin: 0; }
        .pos-layout { max-width: 1720px; margin: 24px auto 0; display: grid; grid-template-columns: minmax(0, 2.05fr) minmax(350px, 0.95fr); align-items: start; gap: 24px; }
        .catalog { min-width: 0; }
        .catalog-toolbar { margin-bottom: 18px; }
        .category-row { min-height: 44px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap; }
        .category-tabs { min-width: 0; display: flex; align-items: center; gap: 10px; overflow-x: auto; scrollbar-width: none; padding: 4px 2px; }
        .category-tabs::-webkit-scrollbar { display: none; }
        .category-tab { min-height: 42px; padding: 0 20px; display: inline-flex; align-items: center; justify-content: center; flex: 0 0 auto; color: #3a2518; background: #f5edda; border: 1px solid rgba(255, 255, 255, 0.65); border-radius: 999px; font: inherit; font-size: 14px; font-weight: 700; text-decoration: none; white-space: nowrap; box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12); transition: all 180ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; }
        .category-tab:hover { color: #23140c; background: #fff5e3; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0, 0, 0, 0.18); }
        .category-tab.active { color: #ffffff; background: linear-gradient(135deg, #7c4827 0%, #522d17 100%); border-color: rgba(255, 225, 190, 0.4); box-shadow: 0 4px 14px rgba(70, 36, 17, 0.45); transform: none; }
        .result-count { flex: 0 0 auto; display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; color: #f2e3d3; background: rgba(35, 19, 11, 0.6); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 999px; font-size: 12px; font-weight: 600; backdrop-filter: blur(6px); }
        .result-count strong { color: #ffdcab; font-weight: 800; }
        .menu-search { width: 100%; min-height: 66px; padding: 0 24px; color: var(--ink); background: #fff; border: 2px solid #ded3c8; border-radius: 18px; outline: none; box-shadow: 0 5px 16px rgb(0 0 0 / 10%); font: inherit; font-size: 16px; font-weight: 600; }
        .menu-search::placeholder { color: #a19a96; }
        .menu-search:focus { border-color: #b5855c; }
        .product-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); align-items: stretch; gap: 14px; }
        .menu-card { min-width: 0; padding: 10px; display: flex; flex-direction: column; background: var(--cream-light); border: 1px solid rgb(255 255 255 / 70%); border-radius: 13px; box-shadow: 0 8px 22px rgb(0 0 0 / 16%); transition: transform 150ms ease, box-shadow 150ms ease; }
        .menu-card:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgb(0 0 0 / 22%); }
        .product-image { width: 100%; aspect-ratio: 1.2; overflow: hidden; background: #e8ddca; border-radius: 9px; }
        .product-image img { width: 100%; height: 100%; display: block; object-fit: cover; }
        .product-placeholder { width: 100%; height: 100%; display: grid; place-items: center; color: #9a8978; font-size: 10px; font-weight: 800; text-transform: uppercase; }
        .product-info { min-height: 75px; padding: 10px 2px 8px; display: flex; flex-direction: column; justify-content: space-between; gap: 7px; }
        .product-title { margin: 0; overflow: hidden; color: #211812; font-size: 14px; font-weight: 800; line-height: 1.25; text-overflow: ellipsis; text-transform: capitalize; }
        .product-category { color: #80644d; font-size: 10px; font-weight: 700; }
        .product-price { color: #3b281b; font-size: 14px; font-weight: 800; }
        .product-controls { margin-top: auto; display: grid; grid-template-columns: auto 1fr; align-items: center; gap: 8px; }
        .quantity-control { min-height: 37px; display: flex; align-items: center; justify-content: center; gap: 7px; background: #eee5d7; border: 1px solid #e0d2c1; border-radius: 8px; }
        .quantity-control button { width: 25px; height: 32px; color: #5b402c; background: transparent; border: 0; cursor: pointer; font-size: 17px; font-weight: 800; }
        .quantity-control input { width: 22px; padding: 0; color: #2c2119; background: transparent; border: 0; text-align: center; font: inherit; font-size: 12px; font-weight: 800; }
        .add-button { min-height: 37px; padding: 0 10px; color: #fffaf1; background: #59341e; border: 0; border-radius: 8px; cursor: pointer; font: inherit; font-size: 11px; font-weight: 800; transition: background 150ms ease; }
        .add-button:hover { background: #7b4b2c; }
        .quick-order { margin-top: 7px; }
        .quick-order button { width: 100%; padding: 5px; color: #6a4c34; background: transparent; border: 0; cursor: pointer; font: inherit; font-size: 10px; font-weight: 700; }
        .quick-order button:hover { color: #291a10; }
        .empty-products { grid-column: 1 / -1; padding: 44px 18px; color: #efe2d1; background: rgb(52 29 17 / 75%); border: 1px dashed rgb(255 244 231 / 35%); border-radius: 14px; font-size: 14px; font-weight: 700; text-align: center; }
        .cart-panel { position: sticky; top: 16px; min-width: 0; padding: 26px; color: #211811; background: var(--cream); border: 1px solid rgb(255 255 255 / 75%); border-radius: 22px; box-shadow: 0 12px 36px rgb(0 0 0 / 18%); }
        .cart-heading { margin-bottom: 17px; padding-bottom: 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; border-bottom: 1px solid #dfd3c2; }
        .cart-heading h2 { margin: 0; font-size: 18px; font-weight: 800; }
        .table-badge { padding: 7px 12px; color: #5b4532; background: #e6d8c4; border-radius: 999px; font-size: 9px; font-weight: 800; text-transform: uppercase; white-space: nowrap; }
        #cart-list { max-height: 400px; min-height: 170px; overflow-y: auto; padding-right: 5px; }
        #cart-list > .text-center { color: #978878; }
        #cart-list .bg-slate-50 { background: #fffaf0; }
        #cart-list .border-slate-100 { border-color: #e5dac9; }
        #cart-list .text-red-600, #cart-list .text-red-700 { color: #75472d; }
        #cart-list .text-2xl { font-size: 21px; }
        #cart-list .border-double { border-color: #d8c8b5; }
        .cart-actions { margin-top: 18px; padding-top: 18px; border-top: 1px dashed #d8c8b5; }
        .cart-action-grid { display: grid; grid-template-columns: 1fr; gap: 10px; }
        .cart-submit { min-height: 80px; padding: 12px; color: #effcf6; background: var(--green); border: 0; border-radius: 14px; cursor: pointer; font: inherit; font-size: 14px; font-weight: 800; letter-spacing: 1.5px; line-height: 1.4; text-transform: uppercase; transition: filter 150ms ease; }
        .cart-submit:hover { filter: brightness(0.92); }
        .cart-submit.secondary { color: #fff; background: #202b3e; }
        .whatsapp-button { min-height: 58px; padding: 12px; color: #fff; background: #25d366; border: 0; border-radius: 14px; cursor: pointer; font: inherit; font-size: 13px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; transition: filter 150ms ease; }
        .whatsapp-button:hover { filter: brightness(0.95); }
        .clear-cart { width: 100%; margin-top: 15px; padding: 9px; color: #33261d; background: transparent; border: 0; cursor: pointer; font: inherit; font-size: 10px; font-weight: 800; letter-spacing: 1.3px; text-transform: uppercase; }
        .clear-cart:hover { color: #8b312a; }
        .mobile-cart-dock { display: none; }
        .pos-footer { max-width: 1720px; margin: 18px auto 0; padding: 12px 4px 4px; color: #e8d9c8; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1c1ac; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #a98b6c; }
        @media (max-width: 1250px) {
            .pos-header { grid-template-columns: 1fr auto; }
            .workflow { grid-column: 1 / -1; grid-row: 2; justify-self: center; }
            .header-tools { grid-column: 2; grid-row: 1; }
            .product-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }
        @media (max-width: 900px) {
            .pos-layout { grid-template-columns: minmax(0, 1fr); }
            .cart-panel { position: static; }
        }
        @media (max-width: 620px) {
            .pos-shell { padding: 8px 8px calc(84px + env(safe-area-inset-bottom)); background-attachment: scroll; }
            .pos-header { position: relative; padding: 11px; grid-template-columns: minmax(0, 1fr); gap: 9px; }
            .brand { gap: 10px; padding-right: 92px; }
            .brand-mark { width: 42px; height: 42px; }
            .brand-mark svg { width: 24px; height: 24px; }
            .brand-title { font-size: 15px; letter-spacing: 0.6px; }
            .brand-caption { font-size: 8px; letter-spacing: 0.6px; }
            .header-tools { position: absolute; top: 11px; right: 11px; width: auto; gap: 6px; }
            .clock { display: none; }
            .header-action { min-height: 34px; padding: 0 10px; font-size: 11px; }
            .workflow { width: 100%; grid-column: 1; grid-row: 2; justify-content: flex-start; gap: 5px; padding: 6px; overflow-x: auto; }
            .workflow a { min-height: 30px; padding: 0 8px; border-radius: 7px; font-size: 8px; }
            .workflow-arrow { font-size: 12px; }
            .pos-layout { margin-top: 12px; gap: 14px; }
            .catalog-toolbar { margin-bottom: 12px; }
            .category-row { align-items: flex-start; flex-direction: column; gap: 8px; }
            .category-tabs { width: 100%; flex-wrap: nowrap; gap: 8px; padding-bottom: 4px; }
            .category-tab { min-height: 36px; padding: 0 14px; font-size: 12.5px; }
            .result-count { font-size: 11px; padding: 4px 10px; }
            .menu-search { min-height: 48px; padding: 0 14px; font-size: 14px; }
            .product-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
            .menu-card { padding: 7px; }
            .product-image { aspect-ratio: 1.05; }
            .product-title { font-size: 12px; }
            .product-info { min-height: 64px; padding: 8px 2px 6px; }
            .product-controls { grid-template-columns: 1fr; gap: 6px; }
            .cart-panel { padding: 16px; border-radius: 16px; }
            .cart-panel { scroll-margin-top: 12px; }
            .cart-heading h2 { font-size: 15px; }
            .cart-action-grid { gap: 8px; }
            .cart-submit { min-height: 52px; padding: 8px 6px; font-size: 11px; letter-spacing: 1px; }
            .mobile-cart-dock { position: fixed; z-index: 50; inset: auto 0 0; min-height: 68px; padding: 9px 12px calc(9px + env(safe-area-inset-bottom)); display: flex; align-items: center; justify-content: space-between; gap: 10px; color: var(--ink); background: var(--cream-light); border-top: 1px solid #d9c9b3; box-shadow: 0 -8px 24px rgb(36 20 12 / 16%); }
            .mobile-cart-summary { min-width: 0; display: grid; gap: 3px; }
            .mobile-cart-count { color: var(--muted); font-size: 10px; font-weight: 700; }
            .mobile-cart-total { max-width: 40vw; overflow: hidden; color: var(--ink); font-size: 16px; font-weight: 800; text-overflow: ellipsis; white-space: nowrap; }
            .mobile-cart-dock button { min-height: 42px; padding: 0 12px; flex: 0 0 auto; color: #fffaf1; background: var(--green); border: 0; border-radius: 9px; cursor: pointer; font: inherit; font-size: 12px; font-weight: 800; }
            .mobile-cart-dock button:disabled { opacity: 0.55; cursor: not-allowed; }
        }
        @media (max-width: 380px) {
            .brand-caption { display: none; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body class="antialiased">
    <div class="pos-shell">
        <header class="pos-header">
            <div class="brand">
                <div class="brand-mark" aria-hidden="true">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h2v7H3zm4 0h2v7H7zm4 0h2v7h-2zm3 0h2v7h-2zm3 0h2v7h-2zm-5 9h6v2a5 5 0 0 1-4 4.9V21h-2v-2.1A5 5 0 0 1 8 14v-2h4zM6 5h1v7a6 6 0 0 0 2 4.5V21H7v-3.5A8 8 0 0 1 5 12V5h1zm12 0h1v7a8 8 0 0 1-2 5.5V21h-2v-4.5a6 6 0 0 0 2-4.5V5h1z"/></svg>
                </div>
                <div>
                    <h1 class="brand-title">Kedai Smart Pinky</h1>
                    <p class="brand-caption">Kedai Smart Pinky — Point of Sale</p>
                </div>
            </div>

            <nav class="workflow" aria-label="Alur operasional">
                <a href="{{ route('orders.create') }}">Pemesanan</a>
                <span class="workflow-arrow" aria-hidden="true">→</span>
                <a href="{{ route('menus.index') }}">Menu</a>
                <span class="workflow-arrow" aria-hidden="true">→</span>
                @if (auth()->user()?->role !== 'pelanggan')
                    <a href="{{ route('management.index') }}">Manajemen</a>
                    <span class="workflow-arrow" aria-hidden="true">→</span>
                @endif
                <a href="{{ route('payments.index') }}">Pembayaran</a>
                <span class="workflow-arrow" aria-hidden="true">→</span>
                <a href="{{ route('orders.history') }}">Riwayat Pesanan</a>
                <span class="workflow-arrow" aria-hidden="true">→</span>
                <a href="{{ route('dashboard.koneksi') }}">Lokasi Maps</a>
            </nav>

            <div class="header-tools">
                <div id="current-datetime" class="clock" aria-label="Waktu sekarang"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="header-action">Logout</button>
                </form>
            </div>
        </header>

        <main class="pos-layout">
            <section class="catalog" aria-label="Daftar menu">
                <div class="catalog-toolbar">
                    <div class="category-row">
                        <nav class="category-tabs" aria-label="Kategori menu">
                            <button type="button" data-filter="all" class="category-tab active">Semua</button>
                            <button type="button" data-filter="kopi" class="category-tab">Kopi</button>
                            <button type="button" data-filter="non-kopi" class="category-tab">Non Kopi</button>
                            <button type="button" data-filter="pastry" class="category-tab">Pastry</button>
                        </nav>
                        <div class="result-count">Menampilkan: <strong id="filter-display-label">Semua</strong></div>
                    </div>

                    <input id="search" type="search" placeholder="Cari menu favorit pelanggan..." class="menu-search" aria-label="Cari menu">
                </div>

                <div id="products" class="product-grid">
                    @forelse($latestMenus ?? [] as $menu)
                        <article class="menu-card" data-category="{{ $menu->category_group }}" data-name="{{ strtolower($menu->name) }}" data-cat-name="{{ strtolower($menu->category ?? '') }}">
                            <div class="product-image">
                                @if($menu->image)
                                    <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" onerror="this.onerror=null; this.src='{{ asset('image/coffee-login.jpg') }}';">
                                @else
                                    <div class="product-placeholder">No photo</div>
                                @endif
                            </div>
                            <div class="product-info">
                                <div>
                                    <h2 class="product-title">{{ $menu->name }}</h2>
                                    <span class="product-category">{{ $menu->category }}</span>
                                </div>
                                <div class="product-price">Rp{{ number_format($menu->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="product-controls">
                                <div class="quantity-control" aria-label="Jumlah {{ $menu->name }}">
                                    <button type="button" data-action="dec" data-id="{{ $menu->id }}" aria-label="Kurangi jumlah">−</button>
                                    <input data-qty-input="{{ $menu->id }}" value="1" min="1" readonly aria-label="Jumlah item">
                                    <button type="button" data-action="inc" data-id="{{ $menu->id }}" aria-label="Tambah jumlah">+</button>
                                </div>
                                <button type="button" data-add data-id="{{ $menu->id }}" data-name="{{ $menu->name }}" data-price="{{ $menu->price }}" class="add-button">Tambahkan</button>
                            </div>
                            <form action="{{ route('orders.quick_store') }}" method="POST" class="quick-order">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                <input type="hidden" name="qty" value="1">
                                <button type="submit">Pesan langsung</button>
                            </form>
                        </article>
                    @empty
                        <div class="empty-products">Menu belum tersedia. Tambahkan menu untuk mulai membuat pesanan.</div>
                    @endforelse

                    <div id="empty-filter-msg" class="empty-products" style="display: none; grid-column: 1 / -1;">Tidak ada menu yang sesuai dengan kategori ini.</div>
                </div>
            </section>

            <aside class="cart-panel" aria-labelledby="cart-title">
                <div class="cart-heading">
                    <h2 id="cart-title">Ringkasan Order</h2>
                    <span class="table-badge">Meja: Take Away</span>
                </div>

                <div id="cart-list" class="space-y-3 max-h-100 overflow-y-auto pr-2 custom-scrollbar min-h-25">
                    <div class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] text-center py-10">Belum Ada Pesanan</div>
                </div>

                <form id="cart-form" action="{{ route('orders.store') }}" method="POST" class="cart-actions">
                    @csrf
                    <div id="hidden-inputs"></div>
                    <input type="hidden" name="payment_method" value="Cash">

                    <div class="cart-action-grid">
                        <button type="submit" class="cart-submit">Proses ke<br>barista</button>
                        <button type="button" id="whatsapp-order" class="whatsapp-button">WhatsApp</button>
                    </div>
                </form>

                <button id="clear-cart" class="clear-cart" type="button">Reset Pesanan</button>
            </aside>
        </main>

        <div class="mobile-cart-dock" aria-live="polite">
            <div class="mobile-cart-summary">
                <span id="mobile-cart-count" class="mobile-cart-count">0 barang</span>
                <strong id="mobile-cart-total" class="mobile-cart-total">Rp0</strong>
            </div>
            <button id="mobile-cart-view" type="button" disabled>Lihat pesanan</button>
        </div>

    <script>
        (function(){
            const whatsappNumber = '+6285888475437';
            const cart = {};

            function renderCart(){
                const list = document.getElementById('cart-list');
                const hidden = document.getElementById('hidden-inputs');
                list.innerHTML = '';
                hidden.innerHTML = '';

                const keys = Object.keys(cart);
                const itemCount = keys.reduce((count, id) => count + cart[id].qty, 0);
                const total = keys.reduce((amount, id) => amount + cart[id].price * cart[id].qty, 0);
                const mobileCount = document.getElementById('mobile-cart-count');
                const mobileTotal = document.getElementById('mobile-cart-total');
                const mobileView = document.getElementById('mobile-cart-view');

                if (mobileCount) mobileCount.textContent = `${itemCount} barang`;
                if (mobileTotal) mobileTotal.textContent = `Rp${total.toLocaleString('id-ID')}`;
                if (mobileView) mobileView.disabled = keys.length === 0;

                if(!keys.length){
                    list.innerHTML = '<div class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] text-center py-10">Belum Ada Pesanan</div>';
                    return;
                }

                keys.forEach(id => {
                    const it = cart[id];

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

            const whatsappBtn = document.getElementById('whatsapp-order');
            if(whatsappBtn){
                whatsappBtn.addEventListener('click', () => {
                    const keys = Object.keys(cart);
                    if (!keys.length) {
                        alert('Belum ada pesanan untuk dikirim ke WhatsApp.');
                        return;
                    }

                    const total = keys.reduce((amount, id) => amount + cart[id].price * cart[id].qty, 0);
                    const items = keys.map(id => `${cart[id].name} (${cart[id].qty}x) = Rp${(cart[id].price * cart[id].qty).toLocaleString('id-ID')}`);
                    const message = [
                        'Halo, saya ingin pesan:',
                        ...items,
                        '',
                        `Total: Rp${total.toLocaleString('id-ID')}`,
                        '',
                        'Mohon dikonfirmasi detailnya.'
                    ].join('\n');

                    const url = 'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent(message);
                    window.open(url, '_blank');
                });
            }

            const mobileCartView = document.getElementById('mobile-cart-view');
            if(mobileCartView) mobileCartView.addEventListener('click', () => {
                document.querySelector('.cart-panel').scrollIntoView({ behavior: 'smooth', block: 'start' });
            });

            // Filter Kategori & Search Produk
            const categoryTabs = document.querySelectorAll('.category-tab[data-filter]');
            const filterLabel = document.getElementById('filter-display-label');
            const searchInput = document.getElementById('search');
            const productCards = document.querySelectorAll('#products .menu-card');
            const emptyFilterMsg = document.getElementById('empty-filter-msg');
            let activeFilter = 'all';

            function applyProductFilter() {
                const query = (searchInput?.value || '').toLowerCase().trim();
                let visibleCount = 0;

                productCards.forEach(card => {
                    const cardCatGroup = (card.getAttribute('data-category') || '').toLowerCase();
                    const cardCatName = (card.getAttribute('data-cat-name') || '').toLowerCase();
                    const cardName = (card.getAttribute('data-name') || '').toLowerCase();

                    // Cek eksplisit minuman non-kopi (Matcha Latte, Macha Latte, Taro, Red Velvet, Cokelat, dll)
                    const hasCoffeeKeyword = cardName.includes('kopi') || cardName.includes('coffee') || cardName.includes('espresso');
                    const isExplicitNonKopi = (
                        cardCatGroup === 'non-kopi' ||
                        cardName.includes('matcha') ||
                        cardName.includes('macha') ||
                        cardName.includes('taro') ||
                        cardName.includes('red velvet') ||
                        cardName.includes('chocolate') ||
                        cardName.includes('cokelat') ||
                        cardName.includes('choco') ||
                        cardName.includes('green tea') ||
                        cardName.includes('greentea') ||
                        cardName.includes('thai tea') ||
                        cardName.includes('thaitea') ||
                        cardName.includes('lemonade') ||
                        cardName.includes('squash') ||
                        cardName.includes('yakult') ||
                        cardName.includes('mojito') ||
                        cardName.includes('tea') ||
                        cardName.includes('teh') ||
                        cardCatName.includes('non')
                    ) && !hasCoffeeKeyword;

                    let matchesCategory = false;
                    if (activeFilter === 'all') {
                        matchesCategory = true;
                    } else if (activeFilter === 'kopi') {
                        // Macha / Matcha Latte dan varian non-kopi TIDAK boleh muncul di filter kopi
                        if (!isExplicitNonKopi) {
                            matchesCategory = (cardCatGroup === 'kopi' || cardCatName.includes('kopi') || cardCatName.includes('coffee'));
                        }
                    } else if (activeFilter === 'non-kopi') {
                        // Macha / Matcha Latte dan varian non-kopi WAJIB muncul di filter non-kopi
                        matchesCategory = isExplicitNonKopi || (cardCatGroup === 'non-kopi' || cardCatName.includes('non'));
                    } else if (activeFilter === 'pastry') {
                        matchesCategory = (cardCatGroup === 'pastry' || cardCatName.includes('pastry') || cardCatName.includes('snack') || cardCatName.includes('makanan') || cardCatName.includes('roti') || cardCatName.includes('cake') || cardCatName.includes('croissant') || cardCatName.includes('croffle'));
                    }

                    const matchesSearch = !query || cardName.includes(query) || cardCatName.includes(query);

                    if (matchesCategory && matchesSearch) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (emptyFilterMsg) {
                    emptyFilterMsg.style.display = (visibleCount === 0 && productCards.length > 0) ? 'block' : 'none';
                }
            }

            categoryTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    categoryTabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    activeFilter = tab.getAttribute('data-filter') || 'all';

                    if (filterLabel) {
                        filterLabel.textContent = tab.textContent.trim();
                    }

                    applyProductFilter();
                });
            });

            if (searchInput) {
                searchInput.addEventListener('input', applyProductFilter);
            }

            function updateClock(){
                const el = document.getElementById('current-datetime');
                if(el) el.textContent = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            }
            setInterval(updateClock, 1000); updateClock();
            renderCart();
        })();
    </script>

    <footer class="pos-footer">&copy; Kedai Smart Pinky</footer>
    </div>
</body>
</html>