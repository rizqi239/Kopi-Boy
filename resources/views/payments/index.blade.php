<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#321b10">
    <title>Pembayaran - Kedai Smart Pinky</title>
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
        @media (max-width: 620px) {
            .pos-shell { padding: 10px; }
            .pos-header { padding: 13px; grid-template-columns: minmax(0, 1fr) auto; gap: 12px; }
            .brand { gap: 10px; }
            .brand-mark { width: 42px; height: 42px; }
            .brand-mark svg { width: 24px; height: 24px; }
            .brand-title { font-size: 15px; letter-spacing: 0.6px; }
            .brand-caption { font-size: 8px; letter-spacing: 0.6px; }
            .header-tools { gap: 6px; }
            .clock { display: none; }
            .header-action { min-height: 38px; padding: 0 11px; font-size: 11px; }
            .workflow { width: 100%; justify-content: flex-start; overflow-x: auto; }
            .workflow a { padding: 8px 10px; font-size: 9px; }
            .workflow-arrow { font-size: 13px; }
            .payments-main { margin-top: 25px; }
            .payments-heading { align-items: flex-start; flex-direction: column; gap: 14px; }
            .payments-title { font-size: 24px; }
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
                                    <tr>
                                        <td class="payment-id">#{{ $p->id }}</td>
                                        <td class="payment-invoice">{{ $p->order->invoice ?? '—' }}</td>
                                        <td class="payment-customer">{{ $p->order->user->name ?? 'Transaksi manual' }}</td>
                                        <td class="payment-products">
                                            @if($p->order && $p->order->items->isNotEmpty())
                                                {{ $p->order->items->map(fn ($item) => $item->name . ' × ' . $item->quantity)->implode(', ') }}
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
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($payments, 'hasPages') && $payments->hasPages())
                        <div class="pagination-wrap">{{ $payments->links() }}</div>
                    @endif
                </section>
            @else
                <section class="payments-panel empty-payments" aria-label="Riwayat pembayaran kosong">Belum ada pembayaran</section>
            @endif
        </main>

        <footer class="pos-footer">&copy; 2026 Kedai Smart Pinky</footer>
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
