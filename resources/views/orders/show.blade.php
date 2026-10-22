<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#321b10">
    <title>Detail Pesanan - Kedai Smart Pinky</title>
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
        main { max-width: 1100px; margin: 36px auto 0; }
        .page-heading { margin-bottom: 18px; }
        .kicker { margin: 0 0 7px; color: #dbb78f; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
        h1 { margin: 0; color: #fff7ed; font-size: 29px; font-weight: 800; }
        .panel { margin-bottom: 16px; padding: 22px; background: var(--cream); border: 1px solid rgb(255 255 255 / 75%); border-radius: 14px; box-shadow: 0 12px 36px rgb(0 0 0 / 18%); }
        .details { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .detail-label { display: block; margin-bottom: 5px; color: #806b57; font-size: 10px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; }
        .detail-value { color: #2b1d13; font-size: 14px; font-weight: 700; overflow-wrap: anywhere; }
        .status { display: inline-block; padding: 5px 9px; color: #573a25; background: #e8dcc9; border-radius: 999px; }
        .section-title { margin: 0 0 14px; color: #2b1d13; font-size: 17px; font-weight: 800; }
        .table-scroll { overflow-x: auto; }
        table { width: 100%; min-width: 520px; border-collapse: collapse; font-size: 13px; }
        th { padding: 12px 10px; color: #806b57; border-bottom: 1px solid #ded2c0; font-size: 10px; font-weight: 800; letter-spacing: 1px; text-align: left; text-transform: uppercase; }
        td { padding: 14px 10px; color: #4c3b2c; border-bottom: 1px solid #e6dccd; }
        tbody tr:last-child td { border-bottom: 0; }
        .numeric { text-align: right; white-space: nowrap; }
        .total-row { display: flex; justify-content: space-between; gap: 16px; margin-top: 16px; padding-top: 16px; color: #2b1d13; border-top: 1px solid #ded2c0; font-size: 16px; font-weight: 800; }
        footer { max-width: 1100px; margin: 20px auto 0; padding: 13px 4px; color: #e8d9c8; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        @media (max-width: 620px) {
            .page-shell { padding: 10px; }
            .page-header { align-items: flex-start; flex-direction: column; padding: 13px; }
            main { margin-top: 25px; }
            h1 { font-size: 24px; }
            .panel { padding: 15px; }
            .details { grid-template-columns: 1fr; gap: 14px; }
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <header class="page-header">
            <a href="{{ route('dashboard') }}" class="brand">Kedai Smart Pinky</a>
            <nav class="header-links" aria-label="Navigasi">
                <a href="{{ route('orders.history') }}">Riwayat Pesanan</a>
                <a href="{{ route('payments.index') }}">Pembayaran</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Keluar</button>
                </form>
            </nav>
        </header>

        <main>
            <div class="page-heading">
                <p class="kicker">Rincian transaksi</p>
                <h1>Detail Pesanan</h1>
            </div>

            <section class="panel" aria-label="Informasi pesanan">
                <div class="details">
                    <div>
                        <span class="detail-label">Invoice</span>
                        <span class="detail-value">{{ $order->invoice }}</span>
                    </div>
                    <div>
                        <span class="detail-label">Tanggal Pesanan</span>
                        <span class="detail-value">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        <span class="detail-label">Status Pesanan</span>
                        <span class="detail-value status">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div>
                        <span class="detail-label">Metode Pembayaran</span>
                        <span class="detail-value">{{ $order->payment_method }}</span>
                    </div>
                </div>
            </section>

            <section class="panel" aria-labelledby="items-title">
                <h2 class="section-title" id="items-title">Item Pesanan</h2>
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th class="numeric">Jumlah</th>
                                <th class="numeric">Harga</th>
                                <th class="numeric">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td class="numeric">{{ $item->quantity }}</td>
                                    <td class="numeric">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="numeric">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Belum ada item dalam pesanan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="total-row">
                    <span>Total Pesanan</span>
                    <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </section>
        </main>

        <footer>&copy; 2026 Kedai Smart Pinky</footer>
    </div>
</body>
</html>
