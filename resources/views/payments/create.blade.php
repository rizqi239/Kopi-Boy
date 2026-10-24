<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#321b10">
    <title>Pembayaran - Kedai Smart Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --coffee: #4b2b19; --cream: #f5edda; --cream-light: #fffaf0; --ink: #241a14; --green: #14885e; }
        * { box-sizing: border-box; }
        [x-cloak] { display: none !important; }
        body { margin: 0; color: var(--ink); background: #321b10; font-family: 'DM Sans', sans-serif; }
        .pos-shell { min-height: 100vh; padding: 16px; background: linear-gradient(110deg, rgb(36 20 12 / 88%), rgb(47 26 16 / 72%)), url('{{ asset('image/coffee-login.jpg') }}') center / cover fixed; }
        .pos-header { max-width: 1720px; min-height: 92px; margin: 0 auto; padding: 14px 20px; display: grid; grid-template-columns: minmax(250px, 1fr) auto minmax(250px, 1fr); align-items: center; gap: 20px; background: var(--cream); border: 1px solid rgb(255 255 255 / 68%); border-radius: 14px; box-shadow: 0 8px 25px rgb(0 0 0 / 12%); }
        .brand { min-width: 0; display: flex; align-items: center; gap: 15px; color: var(--coffee); text-decoration: none; }
        .brand-mark { width: 52px; height: 52px; flex: 0 0 auto; display: grid; place-items: center; color: var(--cream); background: var(--coffee); border-radius: 10px; }
        .brand-mark svg { width: 30px; height: 30px; }
        .brand-title { margin: 0; display: block; color: var(--coffee); font-size: 22px; font-weight: 800; letter-spacing: 1.4px; line-height: 1.2; text-transform: uppercase; }
        .brand-caption { margin: 4px 0 0; display: block; color: #735c49; font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; }
        .workflow { display: flex; align-items: center; justify-content: center; gap: 7px; padding: 9px; background: #f8f5ed; border: 1px solid #e4dac8; border-radius: 12px; }
        .workflow a { padding: 9px 15px; color: #fffaf2; background: #7c1d1d; border-radius: 9px; font-size: 10px; font-weight: 800; text-decoration: none; text-transform: uppercase; white-space: nowrap; transition: background 150ms ease; }
        .workflow a:hover { background: #541515; }
        .workflow-arrow { color: #988b7e; font-size: 17px; }
        .header-tools { display: flex; align-items: center; justify-content: flex-end; gap: 10px; }
        .clock { min-width: 104px; padding: 11px 12px; color: #38291f; background: #f8f5ed; border: 1px solid #e8dfd0; border-radius: 9px; font-size: 12px; font-variant-numeric: tabular-nums; text-align: center; }
        .header-action { min-height: 42px; padding: 0 14px; display: inline-flex; align-items: center; justify-content: center; color: #fff8ed; background: #482817; border: 0; border-radius: 9px; font: inherit; font-size: 12px; font-weight: 800; text-decoration: none; white-space: nowrap; cursor: pointer; transition: background 150ms ease; }
        .header-action:hover { background: #684329; }
        .header-tools form { margin: 0; }
        .payment-main { max-width: 1500px; margin: 34px auto 0; }
        .payment-heading { margin-bottom: 20px; display: flex; align-items: end; justify-content: space-between; gap: 20px; }
        .payment-kicker { margin: 0 0 7px; color: #dbb78f; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
        .payment-title { margin: 0; color: #fff7ed; font-size: 29px; font-weight: 800; }
        .payment-description { margin: 7px 0 0; color: #e9d8c5; font-size: 13px; }
        .payment-total { min-width: 220px; padding: 13px 17px; color: #38291f; background: var(--cream); border-radius: 10px; }
        .payment-total span { display: block; color: #806b57; font-size: 9px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; }
        .payment-total strong { display: block; margin-top: 4px; color: #4b2d1b; font-size: 20px; font-weight: 800; }
        .payment-columns { display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(320px, 0.85fr); align-items: start; gap: 18px; }
        .payment-card { min-width: 0; padding: 22px; color: var(--ink); background: var(--cream); border: 1px solid rgb(255 255 255 / 72%); border-radius: 14px; box-shadow: 0 10px 28px rgb(0 0 0 / 14%); }
        .card-title { margin: 0 0 16px; color: #49301e; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; }
        .order-lines { display: grid; gap: 13px; }
        .order-line { padding-bottom: 13px; display: flex; align-items: center; justify-content: space-between; gap: 14px; border-bottom: 1px solid #e2d6c6; }
        .order-line:last-child { padding-bottom: 0; border-bottom: 0; }
        .line-name { color: #2f2117; font-size: 13px; font-weight: 800; }
        .line-detail { margin-top: 4px; color: #806f60; font-size: 11px; }
        .line-subtotal { color: #4b2d1b; font-size: 13px; font-weight: 800; white-space: nowrap; }
        .payment-card.dark { color: #fffaf2; background: #34251c; border-color: rgb(255 255 255 / 10%); }
        .payment-card.dark .card-title { color: #dfc9b3; }
        .method-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 9px; }
        .method-option { position: relative; cursor: pointer; }
        .method-option input { position: absolute; width: 1px; height: 1px; opacity: 0; }
        .method-option span { min-height: 42px; padding: 8px; display: flex; align-items: center; justify-content: center; color: #f2e9dd; background: rgb(255 255 255 / 6%); border: 1px solid rgb(255 255 255 / 16%); border-radius: 8px; font-size: 10px; font-weight: 800; text-align: center; text-transform: uppercase; transition: color 150ms ease, background 150ms ease; }
        .method-option input:checked + span { color: #3a281b; background: var(--cream); }
        .method-option input:focus-visible + span { outline: 2px solid #d5a77a; outline-offset: 2px; }
        .amount-label { margin: 18px 0 7px; display: block; color: #e0d4c7; font-size: 11px; font-weight: 700; }
        .amount-input { width: 100%; min-height: 46px; padding: 0 13px; color: #2d2118; background: #fffaf0; border: 1px solid #e4d6c2; border-radius: 7px; font: inherit; font-size: 14px; font-weight: 700; }
        .payment-submit { width: 100%; min-height: 48px; margin-top: 15px; padding: 10px; color: #f4fff9; background: #14885e; border: 0; border-radius: 8px; cursor: pointer; font: inherit; font-size: 12px; font-weight: 800; transition: background 150ms ease; }
        .payment-submit:hover { background: #0e704d; }
        .menu-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }
        .menu-card { min-width: 0; padding: 9px; display: flex; flex-direction: column; background: var(--cream-light); border: 1px solid #e6dac8; border-radius: 10px; }
        .menu-card-image { width: 100%; aspect-ratio: 1.2; overflow: hidden; background: #e8ddca; border-radius: 7px; }
        .menu-card-image img { width: 100%; height: 100%; display: block; object-fit: cover; }
        .menu-card-name { margin: 10px 0 4px; color: #2b1d13; font-size: 12px; font-weight: 800; }
        .menu-card-price { color: #806a55; font-size: 11px; font-weight: 700; }
        .menu-card-controls { margin-top: auto; padding-top: 10px; display: flex; align-items: center; justify-content: space-between; gap: 8px; }
        .menu-checkbox { width: 17px; height: 17px; accent-color: #59341e; }
        .qty-input { width: 54px; min-height: 33px; padding: 0 5px; color: #2d2118; background: #fffdf8; border: 1px solid #d9cbb7; border-radius: 6px; text-align: center; font: inherit; font-size: 12px; font-weight: 700; }
        .empty-menus { grid-column: 1 / -1; padding: 30px 16px; color: #806a55; background: #fffaf0; border: 1px dashed #d8c7b0; border-radius: 9px; font-size: 12px; font-weight: 700; text-align: center; }
        .empty-menus a { margin-left: 5px; color: #70472d; font-weight: 800; text-underline-offset: 3px; }
        .payment-modal-backdrop { position: fixed; z-index: 50; inset: 0; padding: 20px; display: grid; place-items: center; background: rgb(24 17 12 / 72%); backdrop-filter: blur(5px); }
        .payment-modal { width: min(430px, 100%); max-height: calc(100vh - 40px); overflow-y: auto; padding: 25px; color: #2d2118; background: var(--cream); border: 1px solid #fff8e9; border-radius: 14px; box-shadow: 0 20px 70px rgb(0 0 0 / 35%); }
        .modal-title { margin: 0; color: #2f2117; font-size: 21px; font-weight: 800; text-align: center; }
        .modal-description { margin: 6px 0 18px; color: #806f60; font-size: 12px; text-align: center; }
        .modal-payment-info { padding: 18px; background: #fffaf0; border: 1px solid #e6dac8; border-radius: 10px; text-align: center; }
        .account-method { color: #70472d; font-size: 10px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; }
        .account-number { margin: 5px 0 3px; color: #2b1d13; font-size: 20px; font-weight: 800; overflow-wrap: anywhere; }
        .account-name { color: #806f60; font-size: 10px; font-weight: 700; text-transform: uppercase; }
        .modal-total { margin-top: 15px; padding-top: 13px; border-top: 1px solid #e3d7c7; }
        .modal-total span { display: block; color: #806f60; font-size: 9px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; }
        .modal-total strong { display: block; margin-top: 4px; color: #4b2d1b; font-size: 19px; }
        .modal-confirm { width: 100%; min-height: 46px; margin-top: 16px; color: #fffaf2; background: #482817; border: 0; border-radius: 8px; cursor: pointer; font: inherit; font-size: 11px; font-weight: 800; text-transform: uppercase; }
        .modal-cancel { width: 100%; margin-top: 8px; padding: 10px; color: #806f60; background: transparent; border: 0; cursor: pointer; font: inherit; font-size: 10px; font-weight: 800; text-transform: uppercase; }
        .pos-footer { max-width: 1500px; margin: 20px auto 0; padding: 13px 4px; color: #e8d9c8; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        @media (max-width: 1250px) {
            .pos-header { grid-template-columns: 1fr auto; }
            .workflow { grid-column: 1 / -1; grid-row: 2; justify-self: center; }
            .header-tools { grid-column: 2; grid-row: 1; }
            .payment-columns { grid-template-columns: minmax(0, 1fr) minmax(290px, 0.8fr); }
        }
        @media (max-width: 900px) {
            .payment-columns { grid-template-columns: 1fr; }
            .menu-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }
        @media (max-width: 620px) {
            .pos-shell { padding: 10px; }
            .pos-header { padding: 13px; grid-template-columns: minmax(0, 1fr) auto; gap: 12px; }
            .brand { gap: 10px; }
            .brand-mark { width: 42px; height: 42px; }
            .brand-mark svg { width: 24px; height: 24px; }
            .brand-title { font-size: 15px; letter-spacing: 0.6px; }
            .brand-caption { font-size: 8px; letter-spacing: 0.6px; }
            .header-tools { gap: 6px; }
            .clock, .test-connection { display: none; }
            .header-action { min-height: 38px; padding: 0 11px; font-size: 11px; }
            .workflow { width: 100%; justify-content: flex-start; overflow-x: auto; }
            .workflow a { padding: 8px 10px; font-size: 9px; }
            .workflow-arrow { font-size: 13px; }
            .payment-main { margin-top: 25px; }
            .payment-heading { align-items: flex-start; flex-direction: column; gap: 13px; }
            .payment-title { font-size: 24px; }
            .payment-total { width: 100%; }
            .payment-card { padding: 17px; }
            .menu-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 9px; }
            .method-grid { gap: 7px; }
            .payment-modal { padding: 18px; }
        }
        @media (max-width: 380px) { .brand-caption { display: none; } .menu-grid { grid-template-columns: 1fr; } }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { scroll-behavior: auto !important; transition-duration: 0.01ms !important; } }
    </style>
</head>
<body x-data="{
    showModal: false,
    selectedMethod: 'Cash',
    totalHarga: {{ isset($order) && $order ? $order->total : 0 }},
    akun: {
        'DANA': { nama: 'Rizqi Ramadhan', nomor: '085888475437' },
        'Bank BSI': { nama: 'Rizqi Ramadhan', nomor: '7123456789' },
        'Bank Mandiri': { nama: 'Rizqi Ramadhan', nomor: '123000123456' },
        'Bank BCA': { nama: 'Rizqi Ramadhan', nomor: '8901234567' },
        'QRIS': { nama: 'Indio Gigantea Boy', nomor: 'NMID: ID102659829328' }
    },
    updateTotal() {
        let total = 0;
        document.querySelectorAll('.menu-checkbox:checked').forEach((el) => {
            const price = Number(el.dataset.price);
            const qty = Number(el.closest('.menu-card').querySelector('.qty-input').value) || 1;
            total += price * qty;
        });
        this.totalHarga = total;
    }
}">
    <div class="pos-shell">
        <header class="pos-header">
            <a class="brand" href="{{ route('dashboard') }}" aria-label="Kedai Smart Pinky dashboard">
                <span class="brand-mark" aria-hidden="true">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h2v7H3zm4 0h2v7H7zm4 0h2v7h-2zm3 0h2v7h-2zm3 0h2v7h-2zm-5 9h6v2a5 5 0 0 1-4 4.9V21h-2v-2.1A5 5 0 0 1 8 14v-2h4zM6 5h1v7a6 6 0 0 0 2 4.5V21H7v-3.5A8 8 0 0 1 5 12V5h1zm12 0h1v7a8 8 0 0 1-2 5.5V21h-2v-4.5a6 6 0 0 0 2-4.5V5h1z"/></svg>
                </span>
                <span>
                    <span class="brand-title">Kedai Smart Pinky</span>
                    <span class="brand-caption">Kedai Smart Pinky — Point of Sale</span>
                </span>
            </a>

            <nav class="workflow" aria-label="Alur operasional">
                <a href="{{ route('orders.create') }}">Pemesanan</a>
                <span class="workflow-arrow" aria-hidden="true">→</span>
                <a href="{{ route('menus.index') }}">Menu</a>
                <span class="workflow-arrow" aria-hidden="true">→</span>
                <a href="{{ route('orders.index') }}">Order</a>
                <span class="workflow-arrow" aria-hidden="true">→</span>
                <a href="{{ route('payments.index') }}" aria-current="page">Pembayaran</a>
                <span class="workflow-arrow" aria-hidden="true">→</span>
                <a href="{{ route('orders.history') }}">Riwayat Pesanan</a>
            </nav>

            <div class="header-tools">
                <div id="current-datetime" class="clock" aria-label="Waktu sekarang"></div>
                <a href="{{ route('dashboard') }}" class="header-action">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="header-action">Logout</button>
                </form>
            </div>
        </header>

        <main class="payment-main">
            <div class="payment-heading">
                <div>
                    <p class="payment-kicker">Transaksi Kedai</p>
                    <h1 class="payment-title">{{ isset($order) && $order ? 'Selesaikan Pembayaran' : 'Buat Pesanan' }}</h1>
                    <p class="payment-description">Pilih metode pembayaran untuk melanjutkan transaksi.</p>
                </div>
                <div class="payment-total">
                    <span>Total Tagihan</span>
                    <strong x-text="'Rp ' + totalHarga.toLocaleString('id-ID')"></strong>
                </div>
            </div>

            @if($errors->any())
                <div class="payment-card" role="alert" style="margin-bottom: 16px; color: #64271f; background: #f8e3d9;">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($order) && $order)
                <form id="mainForm" action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="payment-columns">
                        <section class="payment-card" aria-labelledby="order-summary-title">
                            <h2 id="order-summary-title" class="card-title">Ringkasan Pesanan</h2>
                            <div class="order-lines">
                                @foreach($order->items as $it)
                                    <div class="order-line">
                                        <div>
                                            <div class="line-name">{{ $it->name }}</div>
                                            <div class="line-detail">{{ $it->quantity }} × Rp{{ number_format($it->price, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="line-subtotal">Rp{{ number_format($it->subtotal, 0, ',', '.') }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        <section class="payment-card dark" aria-labelledby="payment-method-title">
                            <h2 id="payment-method-title" class="card-title">Metode Pembayaran</h2>
                            <div class="method-grid">
                                @foreach(['QRIS', 'DANA', 'Bank BSI', 'Bank Mandiri', 'Bank BCA', 'Cash'] as $method)
                                    <label class="method-option">
                                        <input type="radio" name="method" value="{{ $method }}" x-model="selectedMethod" @change="$nextTick(() => { if (selectedMethod !== 'Cash') showModal = true })">
                                        <span>{{ $method }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <label for="amount" class="amount-label">Jumlah Dibayar</label>
                            <input id="amount" type="number" name="amount" value="{{ $order->total }}" min="0" class="amount-input">

                            <button type="button" @click="if(selectedMethod !== 'Cash') { showModal = true } else { document.getElementById('mainForm').submit() }" class="payment-submit">Simpan Pembayaran</button>
                        </section>
                    </div>
                </form>
            @else
                <form id="mainForm" action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <div class="payment-columns">
                        <section class="payment-card" aria-labelledby="menu-selection-title">
                            <h2 id="menu-selection-title" class="card-title">Pilih Menu</h2>
                            <div class="menu-grid">
                                @forelse($menus as $menu)
                                    <article class="menu-card">
                                        <div class="menu-card-image">
                                            @if($menu->image)
                                                <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" onerror="this.onerror=null; this.src='{{ asset('image/coffee-login.jpg') }}';">
                                            @else
                                                <div class="menu-card-image"></div>
                                            @endif
                                        </div>
                                        <h3 class="menu-card-name">{{ $menu->name }}</h3>
                                        <span class="menu-card-price">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
                                        <div class="menu-card-controls">
                                            <label><input type="checkbox" name="menu_id[]" value="{{ $menu->id }}" data-price="{{ $menu->price }}" @change="updateTotal()" class="menu-checkbox"></label>
                                            <input type="number" name="qty[]" value="1" min="1" @input="updateTotal()" class="qty-input" aria-label="Jumlah {{ $menu->name }}">
                                        </div>
                                    </article>
                                @empty
                                    <div class="empty-menus">Belum ada menu untuk dipesan. <a href="{{ route('menus.create') }}">Tambah menu</a></div>
                                @endforelse
                            </div>
                        </section>

                        <section class="payment-card dark" aria-labelledby="payment-method-title">
                            <h2 id="payment-method-title" class="card-title">Metode Pembayaran</h2>
                            <div class="method-grid">
                                @foreach(['QRIS', 'DANA', 'Bank BSI', 'Bank Mandiri', 'Bank BCA', 'Cash'] as $method)
                                    <label class="method-option">
                                        <input type="radio" name="payment_method" value="{{ $method }}" x-model="selectedMethod" @change="$nextTick(() => { if (selectedMethod !== 'Cash') showModal = true })">
                                        <span>{{ $method }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <button type="button" @click="if(totalHarga == 0) { alert('Pilih menu!'); return; } if(selectedMethod !== 'Cash') { showModal = true } else { document.getElementById('mainForm').submit() }" class="payment-submit">Konfirmasi Pesanan</button>
                        </section>
                    </div>
                </form>
            @endif
        </main>

        <div x-show="showModal" x-cloak x-transition class="payment-modal-backdrop" @click.self="showModal = false">
            <section class="payment-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
                <h2 id="modal-title" class="modal-title">Pembayaran</h2>
                <p class="modal-description" x-text="selectedMethod === 'DANA' ? 'Transfer ke nomor DANA berikut.' : (selectedMethod === 'QRIS' ? 'Detail tujuan pembayaran QRIS.' : 'Transfer ke nomor rekening berikut.')"></p>

                <div class="modal-payment-info">
                    <div class="account-method" x-text="selectedMethod"></div>
                    <div class="account-number" x-text="akun[selectedMethod]?.nomor"></div>
                    <div class="account-name" x-text="'a/n ' + akun[selectedMethod]?.nama"></div>
                    <div class="modal-total">
                        <span>Total Tagihan</span>
                        <strong x-text="'Rp ' + totalHarga.toLocaleString('id-ID')"></strong>
                    </div>
                </div>

                <button type="button" @click="document.getElementById('mainForm').submit()" class="modal-confirm">Konfirmasi Sudah Bayar</button>
                <button type="button" @click="showModal = false" class="modal-cancel">Batal / Ganti Metode</button>
            </section>
        </div>

        <footer class="pos-footer">&copy; 2026 Kedai Pinky Smart</footer>
    </div>

    <script>
        const clock = document.getElementById('current-datetime');
        const updateClock = () => {
            if (clock) clock.textContent = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        };
        updateClock();
        setInterval(updateClock, 1000);
    </script>
    @stack('scripts')
</body>
</html>