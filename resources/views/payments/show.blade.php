<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#321b10">
    <title>Detail Pembayaran - Kedai Smart Pinky</title>
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
        .workflow a:hover, .workflow a[aria-current="page"] { background: #541515; }
        .workflow-arrow { color: #988b7e; font-size: 17px; }
        .header-tools { display: flex; align-items: center; justify-content: flex-end; gap: 10px; }
        .clock { min-width: 104px; padding: 11px 12px; color: #38291f; background: #f8f5ed; border: 1px solid #e8dfd0; border-radius: 9px; font-size: 12px; font-variant-numeric: tabular-nums; text-align: center; }
        .header-action { min-height: 42px; padding: 0 14px; display: inline-flex; align-items: center; justify-content: center; color: #fff8ed; background: #482817; border: 0; border-radius: 9px; font: inherit; font-size: 12px; font-weight: 800; text-decoration: none; white-space: nowrap; cursor: pointer; transition: background 150ms ease; }
        .header-action:hover { background: #684329; }
        .header-tools form { margin: 0; }
        .payment-main { max-width: 1120px; margin: 36px auto 0; }
        .payment-heading { margin-bottom: 20px; display: flex; align-items: end; justify-content: space-between; gap: 20px; }
        .payment-kicker { margin: 0 0 7px; color: #dbb78f; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
        .payment-title { margin: 0; color: #fff7ed; font-size: 29px; font-weight: 800; }
        .payment-reference { margin: 7px 0 0; color: #e9d8c5; font-size: 12px; font-weight: 700; }
        .payment-actions { display: flex; flex-wrap: wrap; gap: 9px; }
        .action-link { min-height: 42px; padding: 0 15px; display: inline-flex; align-items: center; justify-content: center; color: #fff8ed; background: #59341e; border: 0; border-radius: 8px; font-family: inherit; font-size: 11px; font-weight: 800; text-decoration: none; white-space: nowrap; cursor: pointer; }
        .action-link.secondary { color: #3f2a1b; background: var(--cream); }
        .action-link:hover { filter: brightness(1.1); }
        .payment-layout { display: grid; grid-template-columns: minmax(0, 1fr); gap: 16px; align-items: start; }
        .payment-panel { min-width: 0; padding: 23px; color: var(--ink); background: var(--cream); border: 1px solid rgb(255 255 255 / 72%); border-radius: 14px; box-shadow: 0 10px 28px rgb(0 0 0 / 14%); }
        .panel-title { margin: 0 0 18px; color: #49301e; font-size: 12px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; }
        .amount-label { display: block; color: #806f60; font-size: 10px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; }
        .amount-value { margin: 7px 0 20px; color: #4b2d1b; font-size: 34px; font-weight: 800; line-height: 1.1; overflow-wrap: anywhere; }
        .detail-row { padding: 13px 0; display: flex; align-items: flex-start; justify-content: space-between; gap: 14px; border-top: 1px solid #e2d6c6; }
        .detail-label { color: #806f60; font-size: 11px; }
        .detail-value { color: #2f2117; font-size: 12px; font-weight: 800; text-align: right; overflow-wrap: anywhere; }
        .status-badge { padding: 6px 10px; display: inline-flex; color: #276044; background: #dcebd9; border-radius: 999px; font-size: 10px; font-weight: 800; text-transform: capitalize; }
        .payment-notes { margin-top: 14px; padding: 14px; color: #685747; background: #fffaf0; border-radius: 8px; font-size: 12px; line-height: 1.6; white-space: pre-wrap; }
        .payment-notes strong { display: block; margin-bottom: 5px; color: #49301e; font-size: 9px; letter-spacing: 1px; text-transform: uppercase; }
        .print-receipt-header, .print-receipt-footer, .print-order-details { display: none; }
        .print-receipt-header { align-items: flex-start; justify-content: space-between; gap: 20px; }
        .print-store-name { margin: 0; font-size: 17px; font-weight: 800; text-transform: uppercase; }
        .print-document-title { margin: 4px 0 0; color: #444; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .print-receipt-meta { font-size: 10px; line-height: 1.6; text-align: right; }
        .print-receipt-meta strong, .print-receipt-meta span { display: block; }
        .print-order-details { margin-top: 20px; }
        .print-order-details h3 { margin: 0 0 9px; font-size: 11px; text-transform: uppercase; }
        .print-order-details table { width: 100%; border-collapse: collapse; font-size: 10px; }
        .print-order-details th, .print-order-details td { padding: 7px 5px; border-bottom: 1px solid #ddd; text-align: left; }
        .print-order-details th:last-child, .print-order-details td:not(:first-child) { text-align: right; }
        .print-order-details thead th { border-bottom: 1px solid #777; }
        .print-order-details tfoot th { border-top: 1px solid #777; border-bottom: 0; }
        .print-receipt-footer { margin-top: 24px; padding-top: 12px; border-top: 1px dashed #999; color: #444; font-size: 10px; text-align: center; }
        .pos-footer { max-width: 1120px; margin: 20px auto 0; padding: 13px 4px; color: #e8d9c8; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        @media (max-width: 1250px) {
            .pos-header { grid-template-columns: 1fr auto; }
            .workflow { grid-column: 1 / -1; grid-row: 2; justify-self: center; }
            .header-tools { grid-column: 2; grid-row: 1; }
        }
        @media (max-width: 800px) { .payment-layout { grid-template-columns: 1fr; } }
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
            .payment-main { margin-top: 25px; }
            .payment-heading { align-items: flex-start; flex-direction: column; gap: 14px; }
            .payment-title { font-size: 24px; }
            .payment-panel { padding: 17px; }
            .amount-value { font-size: 29px; }
        }
        @media (max-width: 380px) { .brand-caption { display: none; } }
        @media print {
            @page { size: A5 portrait; margin: 0; }
            body, .pos-shell { min-height: 0; color: #111; background: #fff !important; font-family: Arial, sans-serif; }
            .pos-shell { padding: 10mm; }
            .pos-header, .payment-heading, .payment-actions, .pos-footer { display: none !important; }
            .payment-main { max-width: none; margin: 0; }
            .print-receipt-header { display: flex; padding-bottom: 14px; border-bottom: 2px solid #222; }
            .print-order-details, .print-receipt-footer { display: block; }
            .payment-title, .amount-value, .detail-value { color: #111; }
            .payment-layout { grid-template-columns: 1fr; gap: 12px; }
            .payment-panel { padding: 14px 0 0; color: #111; background: #fff; border: 0; border-radius: 0; box-shadow: none; }
            .panel-title { margin-bottom: 12px; color: #111; font-size: 12px; }
            .amount-label, .detail-label { color: #444; }
            .amount-value { margin-bottom: 14px; font-size: 28px; }
            .detail-row { padding: 8px 0; border-color: #ccc; break-inside: avoid; }
            .detail-value { max-width: 65%; }
            .payment-panel > .action-link { display: none !important; }
            .print-order-details { break-inside: avoid; }
            .print-order-details thead { display: table-header-group; }
            .print-order-details tr { break-inside: avoid; }
            .print-receipt-footer { break-inside: avoid; }
            .status-badge { color: #111; background: #fff; border: 1px solid #999; }
            .payment-notes { color: #222; background: #fff; border: 1px solid #bbb; break-inside: avoid; }
        }
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
                <a href="{{ route('orders.index') }}">Order</a>
                <span class="workflow-arrow" aria-hidden="true">→</span>
                <a href="{{ route('payments.index') }}">Pembayaran</a>
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
            <div class="print-receipt-header">
                <div>
                    <p class="print-store-name">Kedai Smart Pinky</p>
                    <p class="print-document-title">Bukti Pembayaran</p>
                </div>
                <div class="print-receipt-meta">
                    <strong>No. Pembayaran #{{ $payment->id }}</strong>
                    <span>Dicetak {{ now('Asia/Jakarta')->format('d M Y, H:i') }} WIB</span>
                </div>
            </div>
            <div class="payment-heading">
                <div>
                    <p class="payment-kicker">Transaksi Kedai</p>
                    <h1 class="payment-title">Detail Pembayaran</h1>
                    <p class="payment-reference">Pembayaran #{{ $payment->id }}</p>
                </div>
                <div class="payment-actions">
                    <button type="button" class="action-link" onclick="window.print()">Cetak</button>
                    <a href="{{ route('payments.index') }}" class="action-link secondary">Riwayat Pembayaran</a>
                    <a href="{{ route('payments.edit', $payment) }}" class="action-link">Edit Pembayaran</a>
                </div>
            </div>

            <div class="payment-layout">
                <section class="payment-panel" aria-labelledby="amount-title">
                    <h2 class="panel-title" id="amount-title">Informasi Pembayaran</h2>
                    <span class="amount-label">Total Dibayar</span>
                    <p class="amount-value">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>

                    @if($payment->order)
                        <div class="detail-row">
                            <span class="detail-label">Invoice</span>
                            <span class="detail-value">{{ $payment->order->invoice }}</span>
                        </div>
                    @endif
                    <div class="detail-row">
                        <span class="detail-label">Status Pembayaran</span>
                        <span class="status-badge">{{ ['completed' => 'Selesai', 'pending' => 'Menunggu', 'failed' => 'Gagal'][strtolower($payment->status)] ?? ucfirst($payment->status) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Metode Pembayaran</span>
                        <span class="detail-value">{{ $payment->method }}</span>
                    </div>
                    @php($paymentTimestamp = $payment->paid_at ?? $payment->created_at)
                    <div class="detail-row">
                        <span class="detail-label">Waktu Pembayaran</span>
                        <span class="detail-value">{{ $paymentTimestamp ? \Carbon\Carbon::parse($paymentTimestamp)->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB' : 'Belum tersedia' }}</span>
                    </div>
                    @if($payment->order)
                        <div class="detail-row">
                            <span class="detail-label">Total Pesanan</span>
                            <span class="detail-value">Rp{{ number_format($payment->order->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Status Pesanan</span>
                            <span class="detail-value">{{ ['paid' => 'Lunas', 'pending' => 'Menunggu', 'processing' => 'Diproses', 'cancelled' => 'Dibatalkan'][strtolower($payment->order->status)] ?? ucfirst($payment->order->status) }}</span>
                        </div>
                        <a href="{{ route('orders.show', $payment->order) }}" class="action-link" style="width: 100%; margin-top: 16px;">Lihat Pesanan</a>
                        @if($payment->order->items->isNotEmpty())
                            <div class="print-order-details">
                                <h3>Rincian Pesanan</h3>
                                <table>
                                    <thead>
                                        <tr>
                                            <th scope="col">Menu</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($payment->order->items as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                                <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" scope="row">Total Pesanan</th>
                                            <th>Rp{{ number_format($payment->order->total, 0, ',', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    @else
                        <p class="detail-value">Pembayaran ini tidak terhubung ke pesanan.</p>
                    @endif
                    @if($payment->notes)
                        <div class="payment-notes"><strong>Catatan</strong>{{ $payment->notes }}</div>
                    @endif
                </section>
            </div>
            <div class="print-receipt-footer">Terima kasih telah bertransaksi. Simpan bukti pembayaran ini sebagai referensi.</div>
        </main>

        <footer class="pos-footer">&copy; Kedai Smart Pinky</footer>
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
