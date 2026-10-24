<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#321b10">
    <title>Pembayaran - KOPI-BOY</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --coffee: #4b2b19; --cream: #f5edda; --ink: #241a14; }
        * { box-sizing: border-box; }
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
        .payments-main { max-width: 1500px; margin: 36px auto 0; }
        .payments-heading { margin: 0 0 18px; display: flex; align-items: end; justify-content: space-between; gap: 20px; }
        .payments-kicker { margin: 0 0 7px; color: #dbb78f; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
        .payments-title { margin: 0; color: #fff7ed; font-size: 29px; font-weight: 800; }
        .create-payment { min-height: 44px; padding: 0 18px; display: inline-flex; align-items: center; justify-content: center; color: #fff8ed; background: #59341e; border-radius: 9px; font-size: 12px; font-weight: 800; text-decoration: none; white-space: nowrap; }
        .create-payment:hover { background: #7b4b2c; }
        .flash-message { margin-bottom: 16px; padding: 13px 16px; color: #20563c; background: #e8f1e6; border: 1px solid #cbdcc6; border-radius: 9px; font-size: 12px; font-weight: 700; }
        .payments-panel { padding: 18px; background: var(--cream); border: 1px solid rgb(255 255 255 / 75%); border-radius: 15px; box-shadow: 0 12px 36px rgb(0 0 0 / 18%); }
        .table-scroll { overflow-x: auto; }
        .payments-table { width: 100%; min-width: 900px; border-collapse: collapse; font-size: 13px; }
        .payments-table th { padding: 14px 13px; color: #806b57; border-bottom: 1px solid #ded2c0; font-size: 10px; font-weight: 800; letter-spacing: 1px; text-align: left; text-transform: uppercase; }
        .payments-table td { padding: 16px 13px; color: #4c3b2c; border-bottom: 1px solid #e6dccd; vertical-align: middle; }
        .payments-table tbody tr:last-child td { border-bottom: 0; }
        .payments-table tbody tr:hover { background: rgb(255 250 240 / 72%); }
        .payment-id { color: #2b1d13 !important; font-weight: 800; }
        .payment-total { color: #6d4529 !important; font-weight: 800; text-align: right; white-space: nowrap; }
        .payment-invoice { color: #70472d; font-weight: 700; }
        .payment-time { color: #806f60 !important; white-space: nowrap; }
        .payment-customer { color: #2b1d13 !important; font-weight: 700; }
        .payment-products { max-width: 240px; color: #806f60 !important; font-size: 11px; line-height: 1.5; }
        .payment-status { display: inline-flex; padding: 5px 8px; color: #806f60; background: #eee5d7; border-radius: 999px; font-size: 9px; font-weight: 800; text-transform: uppercase; white-space: nowrap; }
        .payment-status.completed { color: #20563c; background: #e1efe0; }
        .payment-status.failed { color: #8b312a; background: #f5e1dc; }
        .payment-actions { display: flex; align-items: center; justify-content: flex-end; gap: 14px; white-space: nowrap; }
        .payment-actions a, .payment-actions button { padding: 0; color: #70472d; background: transparent; border: 0; cursor: pointer; font: inherit; font-size: 12px; font-weight: 800; text-decoration: none; }
        .payment-actions a:hover, .payment-actions button:hover { color: #29180e; text-decoration: underline; text-underline-offset: 3px; }
        .payment-actions .delete-action { color: #987e69; }
        .empty-payments { padding: 54px 20px; color: #887966; font-size: 13px; font-weight: 700; text-align: center; }
        .pagination-wrap { margin-top: 14px; padding-top: 14px; border-top: 1px solid #e5dac9; }
        .pagination-wrap nav { display: flex; justify-content: center; }
        .pos-footer { max-width: 1500px; margin: 20px auto 0; padding: 13px 4px; color: #e8d9c8; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        @media (max-width: 1250px) {
            .pos-header { grid-template-columns: 1fr auto; }
            .workflow { grid-column: 1 / -1; grid-row: 2; justify-self: center; }
            .header-tools { grid-column: 2; grid-row: 1; }
        }
        /* Clean & Compact Filter Panel */
        .payments-filter-panel {
            margin-bottom: 18px;
            padding: 12px 16px;
            background: var(--cream);
            border: 1px solid rgb(255 255 255 / 85%);
            border-radius: 14px;
            box-shadow: 0 4px 16px rgb(0 0 0 / 7%);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .filter-controls-row {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .search-input-wrap {
            position: relative;
            flex: 1 1 240px;
            min-width: 180px;
        }
        .search-input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            color: #8b7561;
            pointer-events: none;
        }
        .filter-search-input {
            width: 100%;
            min-height: 38px;
            padding: 0 12px 0 34px;
            color: var(--ink);
            background: #fffaf0;
            border: 1px solid #dcd1c2;
            border-radius: 9px;
            font: inherit;
            font-size: 12.5px;
            outline: none;
            transition: all 140ms ease;
        }
        .filter-search-input:focus {
            border-color: #63381e;
            background: #fff;
            box-shadow: 0 0 0 2px rgb(99 56 30 / 12%);
        }
        .filter-select-wrap {
            flex: 0 1 230px;
            min-width: 170px;
        }
        .filter-select {
            width: 100%;
            min-height: 38px;
            padding: 0 10px;
            color: #3b281b;
            background: #fffaf0;
            border: 1px solid #dcd1c2;
            border-radius: 9px;
            font: inherit;
            font-size: 12px;
            font-weight: 600;
            outline: none;
            cursor: pointer;
            transition: all 140ms ease;
        }
        .filter-select:focus {
            border-color: #63381e;
            background: #fff;
        }
        .btn-reset-filter {
            min-height: 38px;
            padding: 0 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            color: #63432b;
            background: #ede0cb;
            border: 1px solid #ded0ba;
            border-radius: 9px;
            font: inherit;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 140ms ease;
            white-space: nowrap;
        }
        .btn-reset-filter:hover {
            background: #dfd0bb;
            color: #311c0f;
        }
        .count-badge-wrap {
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            padding: 5px 11px;
            background: #e2f0de;
            color: #215933;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }
        .quick-pills-row {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        .quick-pill {
            padding: 5px 12px;
            background: #fffaf2;
            color: #553e2b;
            border: 1px solid #dcd1c2;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all 140ms ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .quick-pill:hover {
            background: #f4e8d4;
            border-color: #bfa588;
        }
        .quick-pill.active {
            background: #4b2b19;
            color: #fffaf0;
            border-color: #4b2b19;
            box-shadow: 0 2px 6px rgb(75 43 25 / 20%);
        }
        @media (max-width: 620px) {
            .pos-shell { padding: 10px; }
            .pos-header { padding: 13px; grid-template-columns: minmax(0, 1fr) auto; gap: 12px; }
            .brand { gap: 10px; }
            .brand-mark { width: 42px; height: 42px; }
            .brand-mark svg { width: 24px; height: 24px; }
            .brand-title { font-size: 15px; letter-spacing: 0.6px; }
            .brand-caption { display: none; }
            .header-tools { gap: 6px; }
            .clock { display: none; }
            .header-action { min-height: 38px; padding: 0 11px; font-size: 11px; }
            .workflow { width: 100%; justify-content: flex-start; overflow-x: auto; }
            .workflow a { padding: 8px 10px; font-size: 9px; }
            .workflow-arrow { font-size: 13px; }
            .payments-main { margin-top: 25px; }
            .payments-heading { align-items: flex-start; flex-direction: column; gap: 14px; }
            .payments-title { font-size: 24px; }
            .payments-filter-panel { padding: 12px; gap: 8px; border-radius: 12px; }
            .filter-controls-row { flex-direction: column; align-items: stretch; gap: 8px; }
            .search-input-wrap, .filter-select-wrap { width: 100%; flex: 1 1 100%; }
            .btn-reset-filter { width: 100%; }
            .count-badge-wrap { margin-left: 0; justify-content: center; }
            .quick-pills-row { gap: 5px; }
            .quick-pill { font-size: 11px; padding: 4px 10px; }
            .payments-panel { padding: 10px; border-radius: 12px; }
            .payments-table { min-width: 600px; }
            .payments-table th, .payments-table td { padding: 13px 10px; }
        }
        @media (max-width: 380px) { .brand-caption { display: none; } }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { scroll-behavior: auto !important; transition-duration: 0.01ms !important; } }
    </style>
</head>
<body>
    <div class="pos-shell">
        <header class="pos-header">
            <a class="brand" href="{{ route('dashboard') }}" aria-label="KOPI-BOY dashboard">
                <span class="brand-mark" aria-hidden="true">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h2v7H3zm4 0h2v7H7zm4 0h2v7h-2zm3 0h2v7h-2zm3 0h2v7h-2zm-5 9h6v2a5 5 0 0 1-4 4.9V21h-2v-2.1A5 5 0 0 1 8 14v-2h4zM6 5h1v7a6 6 0 0 0 2 4.5V21H7v-3.5A8 8 0 0 1 5 12V5h1zm12 0h1v7a8 8 0 0 1-2 5.5V21h-2v-4.5a6 6 0 0 0 2-4.5V5h1z"/></svg>
                </span>
                <span>
                    <span class="brand-title">KOPI-BOY</span>
                    <span class="brand-caption">KOPI-BOY — Point of Sale</span>
                </span>
            </a>

            <nav class="workflow" aria-label="Alur operasional">
                <a href="{{ route('orders.create') }}">Pemesanan</a>
                <span class="workflow-arrow" aria-hidden="true">→</span>
                <a href="{{ route('menus.index') }}">Menu</a>
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

        <main class="payments-main">
            <div class="payments-heading">
                <div>
                    <p class="payments-kicker">Transaksi Kedai</p>
                    <h1 class="payments-title">Riwayat Pembayaran</h1>
                </div>
                @if(auth()->user()?->role === 'admin')
                    <a href="{{ route('payments.create') }}" class="create-payment">Buat Pembayaran</a>
                @endif
            </div>

            @if(session('success'))
                <div class="flash-message" role="status">{{ session('success') }}</div>
            @endif

            <!-- Clean & Simple Filter Panel (Khusus Role Admin) -->
            @if(auth()->user()?->role === 'admin')
            <section class="payments-filter-panel" aria-label="Filter pembayaran">
                <form id="payment-filter-form" method="GET" action="{{ route('payments.index') }}" onsubmit="return false;">
                    <div class="filter-controls-row">
                        <div class="search-input-wrap">
                            <svg class="search-input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input id="search-input" name="search" type="search" value="{{ $search ?? '' }}"
                                placeholder="Cari invoice, pelanggan, atau nama produk..."
                                class="filter-search-input" aria-label="Cari pembayaran">
                        </div>

                        <div class="filter-select-wrap">
                            <select id="product-select" name="product" class="filter-select" aria-label="Pilih menu atau pastry">
                                <option value="all">🔍 Semua Menu & Pastry</option>
                                <optgroup label="☕ Kopi">
                                    <option value="americano" {{ ($product ?? '') === 'americano' ? 'selected' : '' }}>Americano</option>
                                    <option value="v60" {{ ($product ?? '') === 'v60' ? 'selected' : '' }}>V60 / Manual Brew</option>
                                    <option value="espresso" {{ ($product ?? '') === 'espresso' ? 'selected' : '' }}>Espresso</option>
                                    <option value="latte" {{ ($product ?? '') === 'latte' ? 'selected' : '' }}>Caffè Latte</option>
                                    <option value="cappuccino" {{ ($product ?? '') === 'cappuccino' ? 'selected' : '' }}>Cappuccino</option>
                                </optgroup>
                                <optgroup label="🍵 Non Kopi">
                                    <option value="macha latte" {{ ($product ?? '') === 'macha latte' || ($product ?? '') === 'matcha' ? 'selected' : '' }}>Macha Latte</option>
                                    <option value="taro" {{ ($product ?? '') === 'taro' ? 'selected' : '' }}>Taro Latte</option>
                                    <option value="red velvet" {{ ($product ?? '') === 'red velvet' ? 'selected' : '' }}>Red Velvet</option>
                                    <option value="chocolate" {{ ($product ?? '') === 'chocolate' || ($product ?? '') === 'cokelat' ? 'selected' : '' }}>Cokelat / Chocolate</option>
                                </optgroup>
                                <optgroup label="🥐 Pastry & Snack">
                                    <option value="pastry" {{ ($product ?? '') === 'pastry' ? 'selected' : '' }}>Semua Pastry</option>
                                    <option value="croissant" {{ ($product ?? '') === 'croissant' ? 'selected' : '' }}>Croissant</option>
                                    <option value="croffle" {{ ($product ?? '') === 'croffle' ? 'selected' : '' }}>Croffle</option>
                                    <option value="roti" {{ ($product ?? '') === 'roti' ? 'selected' : '' }}>Roti / Toast</option>
                                    <option value="cake" {{ ($product ?? '') === 'cake' ? 'selected' : '' }}>Cake / Brownies</option>
                                    <option value="donut" {{ ($product ?? '') === 'donut' ? 'selected' : '' }}>Donut / Waffle</option>
                                    @if(isset($pastryMenus) && $pastryMenus->isNotEmpty())
                                        @foreach($pastryMenus as $pm)
                                            @php $pmSlug = strtolower(trim($pm->name)); @endphp
                                            @if(!in_array($pmSlug, ['croissant', 'croffle', 'pastry', 'roti', 'cake']))
                                                <option value="{{ $pmSlug }}" {{ ($product ?? '') === $pmSlug ? 'selected' : '' }}>{{ $pm->name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </optgroup>
                            </select>
                        </div>

                        <button type="button" id="btn-reset" class="btn-reset-filter" title="Reset filter">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset
                        </button>

                        <div class="count-badge-wrap">
                            <span id="filter-count-badge">{{ $payments->count() }} Transaksi</span>
                        </div>
                    </div>
                </form>

                <!-- Quick Filter Pills: Simpel & Rapi, wrap otomatis tanpa scrollbar -->
                <div class="quick-pills-row" aria-label="Filter menu dan pastry">
                    <button type="button" class="quick-pill active" data-filter-product="all">Semua</button>
                    <button type="button" class="quick-pill" data-filter-product="americano">☕ Americano</button>
                    <button type="button" class="quick-pill" data-filter-product="v60">☕ V60</button>
                    <button type="button" class="quick-pill" data-filter-product="espresso">☕ Espresso</button>
                    <button type="button" class="quick-pill" data-filter-product="macha latte">🍵 Macha Latte</button>
                    <button type="button" class="quick-pill" data-filter-product="pastry">🥐 Pastry</button>
                    <button type="button" class="quick-pill" data-filter-product="croissant">🥐 Croissant</button>
                    <button type="button" class="quick-pill" data-filter-product="croffle">🧇 Croffle</button>
                    <button type="button" class="quick-pill" data-filter-product="roti">🍞 Roti / Toast</button>
                    <button type="button" class="quick-pill" data-filter-product="cake">🍰 Cake / Brownies</button>
                    @if(isset($pastryMenus) && $pastryMenus->isNotEmpty())
                        @foreach($pastryMenus as $pm)
                            @php $pmSlug = strtolower(trim($pm->name)); @endphp
                            @if(!in_array($pmSlug, ['croissant', 'croffle', 'pastry', 'roti', 'cake', 'toast', 'brownies']))
                                <button type="button" class="quick-pill" data-filter-product="{{ $pmSlug }}">🥐 {{ $pm->name }}</button>
                            @endif
                        @endforeach
                    @endif
                </div>
            </section>
            @endif

            @if($payments->count())
                <section class="payments-panel" aria-label="Riwayat pembayaran">
                    <div class="table-scroll">
                        <table class="payments-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice</th>
                                    <th>Pelanggan</th>
                                    <th>Produk</th>
                                    <th>Waktu</th>
                                    <th style="text-align: right">Total</th>
                                    <th>Status</th>
                                    <th style="text-align: right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $p)
                                    @php
                                        $orderItems = $p->order && $p->order->items ? $p->order->items : collect();
                                        $itemNames = $orderItems->pluck('name')->implode(' | ');
                                        $itemNamesLower = strtolower($itemNames);
                                        $invoiceLower = strtolower($p->order->invoice ?? '');
                                        $customerLower = strtolower($p->order->user->name ?? '');
                                    @endphp
                                    <tr class="payment-row"
                                        data-id="{{ $p->id }}"
                                        data-invoice="{{ $invoiceLower }}"
                                        data-customer="{{ $customerLower }}"
                                        data-products="{{ $itemNamesLower }}"
                                        data-status="{{ strtolower($p->status) }}">
                                        <td class="payment-id">#{{ $p->id }}</td>
                                        <td class="payment-invoice">{{ $p->order->invoice ?? '—' }}</td>
                                        <td class="payment-customer">{{ $p->order->user->name ?? 'Transaksi manual' }}</td>
                                        <td class="payment-products">
                                            @if($orderItems->isNotEmpty())
                                                {{ $orderItems->map(fn ($item) => $item->name . ' × ' . $item->quantity)->implode(', ') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="payment-time">{{ $p->created_at->format('d M Y • H:i') }}</td>
                                        <td class="payment-total">Rp{{ number_format($p->amount, 0, ',', '.') }}</td>
                                        <td><span class="payment-status {{ strtolower($p->status) }}">{{ ['completed' => 'Selesai', 'pending' => 'Menunggu', 'failed' => 'Gagal'][strtolower($p->status)] ?? ucfirst($p->status) }}</span></td>
                                        <td>
                                            <div class="payment-actions">
                                                <a href="{{ route('payments.show', $p) }}">Lihat</a>
                                                @if(auth()->user()?->role === 'admin')
                                                    <form action="{{ route('payments.destroy', $p) }}" method="POST" class="m-0" onsubmit="return confirm('Hapus pembayaran ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="delete-action">Hapus</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(auth()->user()?->role === 'admin')
                                <tr id="filter-empty-row" style="display: none;">
                                    <td colspan="8" class="empty-payments">
                                        Tidak ada transaksi pembayaran yang memuat menu "<strong id="empty-filter-name" class="text-[#4b2b19]"></strong>".
                                        <div style="margin-top: 10px;">
                                            <button type="button" class="btn-reset-filter" onclick="window.resetPaymentFilter()">Reset Filter</button>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($payments, 'hasPages') && $payments->hasPages())
                        <div class="pagination-wrap">{{ $payments->links() }}</div>
                    @endif
                </section>
            @else
                <section class="payments-panel empty-payments" aria-label="Riwayat pembayaran kosong">
                    @if(auth()->user()?->role === 'admin')
                        Belum ada pembayaran yang sesuai dengan kriteria filter.<br>
                        <a href="{{ route('payments.index') }}" style="color: #4b2b19; font-weight: 800; text-decoration: underline; margin-top: 10px; display: inline-block;">Tampilkan Semua Transaksi</a>
                    @else
                        Belum ada riwayat pembayaran.
                    @endif
                </section>
            @endif
        </main>

        <footer class="pos-footer">&copy; 2026 KOPI-BOY</footer>
    </div>

    <script>
        const clock = document.getElementById('current-datetime');
        const updateClock = () => {
            if (clock) clock.textContent = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        };
        updateClock();
        setInterval(updateClock, 1000);

        @if(auth()->user()?->role === 'admin')
        // Clean & Fast Filter: Americano, V60, Espresso, Macha Latte, Pastry dll (Khusus Admin)
        (function() {
            const searchInput = document.getElementById('search-input');
            const productSelect = document.getElementById('product-select');
            const productPills = document.querySelectorAll('.quick-pill[data-filter-product]');
            const countBadge = document.getElementById('filter-count-badge');
            const resetBtn = document.getElementById('btn-reset');
            const paymentRows = document.querySelectorAll('.payment-row');
            const emptyRow = document.getElementById('filter-empty-row');
            const emptyFilterName = document.getElementById('empty-filter-name');

            let currentProduct = 'all';

            const pastryWords = ['pastry', 'croissant', 'croffle', 'roti', 'cake', 'toast', 'brownies', 'donut', 'cookie', 'cookies', 'pie', 'waffle', 'snack', 'danish', 'muffin'];

            function applyFilters() {
                const query = (searchInput?.value || '').toLowerCase().trim();
                let visibleCount = 0;

                paymentRows.forEach(row => {
                    const products = row.getAttribute('data-products') || '';
                    const invoice = row.getAttribute('data-invoice') || '';
                    const customer = row.getAttribute('data-customer') || '';

                    // 1. Cek Produk Tertentu (Americano, V60, Espresso, Macha Latte, Pastry, Croissant, dll)
                    let matchesProduct = true;
                    if (currentProduct !== 'all') {
                        if (currentProduct === 'macha latte' || currentProduct === 'matcha') {
                            matchesProduct = products.includes('macha') || products.includes('matcha');
                        } else if (currentProduct === 'v60') {
                            matchesProduct = products.includes('v60') || products.includes('v-60');
                        } else if (currentProduct === 'pastry') {
                            matchesProduct = pastryWords.some(w => products.includes(w));
                        } else {
                            matchesProduct = products.includes(currentProduct);
                        }
                    }

                    // 2. Cek Pencarian
                    let matchesSearch = true;
                    if (query) {
                        matchesSearch = products.includes(query) || invoice.includes(query) || customer.includes(query);
                    }

                    if (matchesProduct && matchesSearch) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Update UI count
                if (countBadge) {
                    countBadge.textContent = `${visibleCount} Transaksi`;
                }

                if (emptyRow) {
                    if (visibleCount === 0 && paymentRows.length > 0) {
                        emptyRow.style.display = '';
                        if (emptyFilterName) {
                            emptyFilterName.textContent = currentProduct !== 'all' ? currentProduct.toUpperCase() : (query || 'filter');
                        }
                    } else {
                        emptyRow.style.display = 'none';
                    }
                }
            }

            function setActiveProduct(prod) {
                currentProduct = (prod || 'all').toLowerCase();
                productPills.forEach(p => {
                    p.classList.toggle('active', (p.getAttribute('data-filter-product') || '').toLowerCase() === currentProduct);
                });
                if (productSelect) {
                    productSelect.value = currentProduct;
                }
                applyFilters();
            }

            productPills.forEach(pill => {
                pill.addEventListener('click', () => {
                    const prod = pill.getAttribute('data-filter-product') || 'all';
                    setActiveProduct(prod);
                });
            });

            if (productSelect) {
                productSelect.addEventListener('change', () => {
                    setActiveProduct(productSelect.value);
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', applyFilters);
                searchInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        applyFilters();
                    }
                });
            }

            window.resetPaymentFilter = function() {
                currentProduct = 'all';
                if (searchInput) searchInput.value = '';
                if (productSelect) productSelect.value = 'all';
                productPills.forEach(p => p.classList.toggle('active', p.getAttribute('data-filter-product') === 'all'));
                applyFilters();
            };

            if (resetBtn) {
                resetBtn.addEventListener('click', window.resetPaymentFilter);
            }

            // Initial trigger if query params are present from server
            @if(!empty($product) && $product !== 'all')
                setActiveProduct("{{ $product }}");
            @else
                applyFilters();
            @endif
        })();
        @endif
    </script>
    @stack('scripts')
</body>
</html>
