<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#321b10">
    <title>Riwayat Pesanan - Kedai Smart Pinky</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --coffee: #4b2b19; --cream: #f5edda; --ink: #241a14; }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--ink); background: #321b10; font-family: 'DM Sans', sans-serif; }
        .page-shell { min-height: 100vh; padding: 16px; background: linear-gradient(110deg, rgb(36 20 12 / 88%), rgb(47 26 16 / 72%)), url('{{ asset('image/coffee-login.jpg') }}') center / cover fixed; }
        .page-header { max-width: 1500px; margin: 0 auto; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; gap: 16px; background: var(--cream); border: 1px solid rgb(255 255 255 / 68%); border-radius: 14px; }
        .brand { color: var(--coffee); font-size: 16px; font-weight: 800; letter-spacing: 1px; text-decoration: none; text-transform: uppercase; }
        .header-links { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; }
        .header-links a, .header-links button { padding: 10px 13px; color: #fff8ed; background: #482817; border: 0; border-radius: 8px; font: inherit; font-size: 12px; font-weight: 800; text-decoration: none; cursor: pointer; }
        .header-links a:hover, .header-links button:hover { background: #684329; }
        .header-links form { margin: 0; }
        main { max-width: 1500px; margin: 36px auto 0; }
        .page-heading { margin-bottom: 18px; }
        .kicker { margin: 0 0 7px; color: #dbb78f; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
        h1 { margin: 0; color: #fff7ed; font-size: 29px; font-weight: 800; }
        .panel { padding: 18px; background: var(--cream); border: 1px solid rgb(255 255 255 / 75%); border-radius: 14px; box-shadow: 0 12px 36px rgb(0 0 0 / 18%); }
        .table-scroll { overflow-x: auto; }
        table { width: 100%; min-width: 700px; border-collapse: collapse; font-size: 13px; }
        th { padding: 14px 11px; color: #806b57; border-bottom: 1px solid #ded2c0; font-size: 10px; font-weight: 800; letter-spacing: 1px; text-align: left; text-transform: uppercase; }
        td { padding: 15px 11px; color: #4c3b2c; border-bottom: 1px solid #e6dccd; vertical-align: middle; }
        tbody tr:last-child td { border-bottom: 0; }
        .invoice { color: #2b1d13; font-weight: 800; }
        .status { display: inline-block; padding: 5px 9px; color: #573a25; background: #e8dcc9; border-radius: 999px; font-size: 11px; font-weight: 700; }
        .total { color: #6d4529; font-weight: 800; text-align: right; white-space: nowrap; }
        .actions { text-align: right; white-space: nowrap; }
        .actions a { color: #70472d; font-size: 12px; font-weight: 800; text-decoration: none; }
        .actions a:hover { color: #29180e; text-decoration: underline; text-underline-offset: 3px; }
        .empty { padding: 45px 20px; color: #887966; font-size: 13px; font-weight: 700; text-align: center; }
        .pagination-wrap { margin-top: 14px; padding-top: 14px; border-top: 1px solid #e5dac9; }
        .pagination-wrap nav { display: flex; justify-content: center; }
        footer { max-width: 1500px; margin: 20px auto 0; padding: 13px 4px; color: #e8d9c8; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        @media (max-width: 620px) {
            .page-shell { padding: 10px; }
            .page-header { align-items: flex-start; flex-direction: column; padding: 13px; }
            main { margin-top: 25px; }
            h1 { font-size: 24px; }
            .panel { padding: 10px; }
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <header class="page-header">
            <a href="{{ route('dashboard') }}" class="brand">Kedai Smart Pinky</a>
            <nav class="header-links" aria-label="Navigasi">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('payments.index') }}">Pembayaran</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Keluar</button>
                </form>
            </nav>
        </header>

        <main>
            <div class="page-heading">
                <p class="kicker">Transaksi Kedai</p>
                <h1>Riwayat Pesanan</h1>
            </div>

            <section class="panel" aria-label="Daftar riwayat pesanan">
                @if($orders->count())
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    @if(auth()->user()?->role === 'admin')
                                        <th>Pelanggan</th>
                                    @endif
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="total">Total</th>
                                    <th class="actions">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="invoice">{{ $order->invoice }}</td>
                                        @if(auth()->user()?->role === 'admin')
                                            <td>{{ $order->user->name ?? '—' }}</td>
                                        @endif
                                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                        <td><span class="status">{{ ucfirst($order->status) }}</span></td>
                                        <td class="total">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td class="actions"><a href="{{ route('orders.show', $order) }}">Lihat Pesanan</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($orders, 'hasPages') && $orders->hasPages())
                        <div class="pagination-wrap">{{ $orders->links() }}</div>
                    @endif
                @else
                    <div class="empty">Belum ada pesanan.</div>
                @endif
            </section>
        </main>

        <footer>&copy; 2026 Kedai Smart Pinky</footer>
    </div>
</body>
</html>
