<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#321b10">
    <title>Edit Pembayaran - Kedai Smart Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --coffee: #4b2b19; --cream: #f5edda; --cream-light: #fffaf0; --ink: #241a14; }
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
        .edit-main { max-width: 1120px; margin: 34px auto 0; }
        .edit-heading { margin-bottom: 20px; display: flex; align-items: end; justify-content: space-between; gap: 20px; }
        .edit-kicker { margin: 0 0 7px; color: #dbb78f; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
        .edit-title { margin: 0; color: #fff7ed; font-size: 29px; font-weight: 800; }
        .edit-description { margin: 7px 0 0; color: #e9d8c5; font-size: 13px; }
        .back-link { min-height: 42px; padding: 0 16px; display: inline-flex; align-items: center; justify-content: center; color: #3f2a1b; background: var(--cream); border-radius: 9px; font-size: 12px; font-weight: 800; text-decoration: none; white-space: nowrap; }
        .back-link:hover { background: var(--cream-light); }
        .error-panel { margin-bottom: 16px; padding: 13px 16px; color: #64271f; background: #f8e3d9; border: 1px solid #e9b8a7; border-left: 4px solid #ad513c; border-radius: 8px; font-size: 12px; }
        .error-panel ul { margin: 0; padding-left: 18px; }
        .edit-form { padding: 24px; background: var(--cream); border: 1px solid rgb(255 255 255 / 72%); border-radius: 15px; box-shadow: 0 12px 36px rgb(0 0 0 / 18%); }
        .edit-columns { display: grid; grid-template-columns: minmax(0, 1.1fr) minmax(280px, 0.9fr); align-items: stretch; gap: 20px; }
        .edit-fields { display: grid; align-content: start; gap: 18px; }
        .field label { margin-bottom: 7px; display: block; color: #49301e; font-size: 11px; font-weight: 800; letter-spacing: 0.8px; text-transform: uppercase; }
        .field input, .field select, .field textarea { width: 100%; min-height: 46px; padding: 11px 13px; color: #2d2118; background: #fffdf8; border: 1px solid #d9cbb7; border-radius: 7px; outline: none; font: inherit; font-size: 13px; }
        .field input:focus, .field select:focus, .field textarea:focus { border-color: #9a6945; box-shadow: 0 0 0 2px rgb(154 105 69 / 16%); }
        .field textarea { min-height: 95px; resize: vertical; }
        .payment-info, .cash-info { min-height: 240px; padding: 22px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #2d2118; background: var(--cream-light); border: 1px solid #e6dac8; border-radius: 11px; text-align: center; }
        .payment-info { gap: 10px; }
        .payment-info-label { color: #70472d; font-size: 10px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; }
        .payment-info-number { color: #2b1d13; font-size: 20px; font-weight: 800; overflow-wrap: anywhere; }
        .payment-info-name { color: #806f60; font-size: 10px; font-weight: 700; text-transform: uppercase; }
        .qr-frame { margin-bottom: 7px; padding: 9px; background: #fff; border: 1px solid #e5daca; border-radius: 8px; }
        .qr-frame img { width: 132px; height: 132px; display: block; }
        .cash-info { color: #806a55; border-style: dashed; font-size: 11px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; }
        .edit-actions { margin-top: 20px; padding-top: 17px; display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dfd3c2; }
        .edit-button { min-height: 44px; padding: 0 19px; display: inline-flex; align-items: center; justify-content: center; border: 0; border-radius: 8px; cursor: pointer; font: inherit; font-size: 12px; font-weight: 800; text-decoration: none; }
        .edit-button.submit { color: #fffaf1; background: #59341e; }
        .edit-button.submit:hover { background: #7b4b2c; }
        .edit-button.cancel { color: #473629; background: #e9dfd0; }
        .edit-button.cancel:hover { background: #ded0bc; }
        .pos-footer { max-width: 1120px; margin: 20px auto 0; padding: 13px 4px; color: #e8d9c8; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        @media (max-width: 1250px) {
            .pos-header { grid-template-columns: 1fr auto; }
            .workflow { grid-column: 1 / -1; grid-row: 2; justify-self: center; }
            .header-tools { grid-column: 2; grid-row: 1; }
        }
        @media (max-width: 760px) { .edit-columns { grid-template-columns: 1fr; } .payment-info, .cash-info { min-height: 200px; } }
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
            .edit-main { margin-top: 25px; }
            .edit-heading { align-items: flex-start; flex-direction: column; gap: 14px; }
            .edit-title { font-size: 24px; }
            .edit-form { padding: 15px; }
            .edit-actions { flex-direction: column-reverse; }
            .edit-button { width: 100%; }
        }
        @media (max-width: 380px) { .brand-caption { display: none; } }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { scroll-behavior: auto !important; transition-duration: 0.01ms !important; } }
    </style>
</head>
<body x-data="{
    selectedMethod: @js(strtolower(old('method', $payment->method))),
    akun: {
        qris: { nama: 'Kedai Pinky Smart', nomor: 'Scan QR di bawah' },
        ewallet: { nama: 'Rizqi Ramadhan', nomor: 'DANA: 0812XXXXXX' },
        transfer: { nama: 'Rizqi Ramadhan', nomor: 'BSI: 7123XXXXXX' },
        cash: { nama: '-', nomor: 'Bayar di Kasir' }
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
                <a href="{{ route('dashboard') }}" class="header-action test-connection">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="header-action">Logout</button>
                </form>
            </div>
        </header>

        <main class="edit-main">
            <div class="edit-heading">
                <div>
                    <p class="edit-kicker">Transaksi Kedai</p>
                    <h1 class="edit-title">Edit Pembayaran</h1>
                    <p class="edit-description">Perbarui nominal, metode, atau status pembayaran.</p>
                </div>
                <a href="{{ route('payments.index') }}" class="back-link">Daftar Pembayaran</a>
            </div>

            @if($errors->any())
                <div class="error-panel" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('payments.update', $payment) }}" method="POST" class="edit-form">
                @csrf
                @method('PUT')

                <div class="edit-columns">
                    <div class="edit-fields">
                        <div class="field">
                            <label for="amount">Jumlah Pembayaran</label>
                            <input id="amount" type="number" name="amount" min="0" value="{{ old('amount', $payment->amount) }}" required>
                        </div>

                        <div class="field">
                            <label for="method">Metode Bayar</label>
                            <select id="method" name="method" x-model="selectedMethod" required>
                                <option value="cash" @selected(strtolower(old('method', $payment->method)) === 'cash')>Cash / Tunai</option>
                                <option value="qris" @selected(strtolower(old('method', $payment->method)) === 'qris')>QRIS</option>
                                <option value="ewallet" @selected(strtolower(old('method', $payment->method)) === 'ewallet')>E-Wallet (DANA)</option>
                                <option value="transfer" @selected(strtolower(old('method', $payment->method)) === 'transfer')>Bank Transfer</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="status">Status</label>
                            <select id="status" name="status" required>
                                <option value="completed" @selected(old('status', $payment->status) === 'completed')>Selesai</option>
                                <option value="pending" @selected(old('status', $payment->status) === 'pending')>Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="payment-info" x-show="selectedMethod !== 'cash'" x-cloak x-transition>
                        <div x-show="selectedMethod === 'qris'" class="qr-frame">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=KEDAI-PINKY-SMART" alt="QRIS pembayaran">
                        </div>
                        <span class="payment-info-label" x-text="selectedMethod"></span>
                        <span class="payment-info-number" x-text="akun[selectedMethod]?.nomor"></span>
                        <span class="payment-info-name" x-text="'a/n ' + akun[selectedMethod]?.nama"></span>
                    </div>

                    <div class="cash-info" x-show="selectedMethod === 'cash'" x-cloak x-transition>Pembayaran Tunai</div>
                </div>

                <div class="field" style="margin-top: 20px;">
                    <label for="notes">Catatan</label>
                    <textarea id="notes" name="notes" rows="3">{{ old('notes', $payment->notes) }}</textarea>
                </div>

                <div class="edit-actions">
                    <a href="{{ route('payments.index') }}" class="edit-button cancel">Batal</a>
                    <button type="submit" class="edit-button submit">Simpan Perubahan</button>
                </div>
            </form>
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