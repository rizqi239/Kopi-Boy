<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#321b10">
    <title>Manajemen - KOPI-BOY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --cream: #f5edda; --cream-light: #fffaf0; --ink: #241a14; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; padding: 16px; color: var(--ink); background: linear-gradient(110deg, rgb(36 20 12 / 88%), rgb(47 26 16 / 72%)), url('{{ asset('image/coffee-login.jpg') }}') center / cover fixed; font-family: 'DM Sans', sans-serif; }
        .management-shell { max-width: 1100px; margin: 0 auto; }
        .management-header { min-height: 82px; padding: 15px 20px; display: flex; align-items: center; justify-content: space-between; gap: 16px; background: var(--cream); border: 1px solid rgb(255 255 255 / 68%); border-radius: 14px; box-shadow: 0 8px 25px rgb(0 0 0 / 12%); }
        .management-brand { color: #4b2b19; font-size: 16px; font-weight: 800; letter-spacing: 1px; text-decoration: none; text-transform: uppercase; }
        .management-nav { display: flex; align-items: center; gap: 9px; }
        .management-nav a, .management-nav button { min-height: 40px; padding: 0 14px; display: inline-flex; align-items: center; justify-content: center; color: #fff8ed; background: #482817; border: 0; border-radius: 9px; font: inherit; font-size: 11px; font-weight: 800; text-decoration: none; cursor: pointer; }
        .management-nav a:hover, .management-nav button:hover { background: #684329; }
        .management-nav form { margin: 0; }
        .management-heading { margin: 44px 0 22px; }
        .management-kicker { margin: 0 0 7px; color: #dbb78f; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
        .management-title { margin: 0; color: #fff7ed; font-size: clamp(26px, 4vw, 36px); font-weight: 800; }
        .management-description { margin: 9px 0 0; color: #e9d8c5; font-size: 14px; }
        .management-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .management-card { min-height: 235px; padding: 24px; display: flex; flex-direction: column; align-items: flex-start; background: var(--cream-light); border: 1px solid rgb(255 255 255 / 70%); border-radius: 14px; box-shadow: 0 8px 22px rgb(0 0 0 / 16%); }
        .management-icon { width: 48px; height: 48px; margin-bottom: 18px; display: grid; place-items: center; color: #fff8ed; background: #59341e; border-radius: 12px; font-size: 22px; font-weight: 800; }
        .management-card h2 { margin: 0; color: #2b1d13; font-size: 20px; font-weight: 800; }
        .management-card p { margin: 8px 0 20px; color: #806f60; font-size: 13px; line-height: 1.6; }
        .management-card a { min-height: 42px; margin-top: auto; padding: 0 16px; display: inline-flex; align-items: center; justify-content: center; color: #fff8ed; background: #7c1d1d; border-radius: 9px; font-size: 11px; font-weight: 800; text-decoration: none; }
        .management-card a:hover { background: #541515; }
        @media (max-width: 620px) {
            body { padding: 9px; background-attachment: scroll; }
            .management-header { padding: 12px; }
            .management-brand { font-size: 12px; }
            .management-nav a, .management-nav button { min-height: 36px; padding: 0 10px; font-size: 10px; }
            .management-heading { margin-top: 30px; }
            .management-grid { grid-template-columns: minmax(0, 1fr); }
            .management-card { min-height: 210px; padding: 20px; }
        }
    </style>
</head>
<body>
    <main class="management-shell">
        <header class="management-header">
            <a class="management-brand" href="{{ route('dashboard') }}">KOPI-BOY</a>
            <nav class="management-nav" aria-label="Navigasi manajemen">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </nav>
        </header>

        <section aria-labelledby="management-title">
            <div class="management-heading">
                <p class="management-kicker">Operasional kedai</p>
                <h1 id="management-title" class="management-title">Manajemen</h1>
                <p class="management-description">Pilih bagian yang ingin Anda kelola.</p>
            </div>

            <div class="management-grid">
                <article class="management-card">
                    <div class="management-icon" aria-hidden="true">Rp</div>
                    <h2>Keuangan</h2>
                    <p>Kelola transaksi pembayaran dan tinjau catatan pembayaran pesanan.</p>
                    <a href="{{ route('management.finance') }}">Kelola Keuangan</a>
                </article>

                @if (auth()->user()?->role === 'admin')
                    <article class="management-card">
                        <div class="management-icon" aria-hidden="true">#</div>
                        <h2>Stock Opname</h2>
                        <p>Catat jumlah fisik setiap menu, bandingkan dengan stok sistem, dan lihat riwayat selisih.</p>
                        <a href="{{ route('stock-opnames.index') }}">Kelola Stock Opname</a>
                    </article>
                @endif
            </div>
        </section>
    </main>
</body>
</html>
