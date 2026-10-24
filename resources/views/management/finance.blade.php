<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#321b10">
    <title>Keuangan - KOPI-BOY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --cream: #f5edda; --cream-light: #fffaf0; --ink: #241a14; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; padding: 16px; color: var(--ink); background: linear-gradient(110deg, rgb(36 20 12 / 88%), rgb(47 26 16 / 72%)), url('{{ asset('image/coffee-login.jpg') }}') center / cover fixed; font-family: 'DM Sans', sans-serif; }
        .finance-shell { max-width: 1300px; margin: 0 auto; }
        .finance-header { min-height: 82px; padding: 15px 20px; display: flex; align-items: center; justify-content: space-between; gap: 16px; background: var(--cream); border: 1px solid rgb(255 255 255 / 68%); border-radius: 14px; box-shadow: 0 8px 25px rgb(0 0 0 / 12%); }
        .finance-brand { color: #4b2b19; font-size: 16px; font-weight: 800; letter-spacing: 1px; text-decoration: none; text-transform: uppercase; }
        .finance-nav { display: flex; align-items: center; gap: 9px; }
        .finance-nav a, .finance-nav button { min-height: 40px; padding: 0 14px; display: inline-flex; align-items: center; justify-content: center; color: #fff8ed; background: #482817; border: 0; border-radius: 9px; font: inherit; font-size: 11px; font-weight: 800; text-decoration: none; cursor: pointer; }
        .finance-nav a:hover, .finance-nav button:hover { background: #684329; }
        .finance-nav form { margin: 0; }
        .finance-heading { margin: 36px 0 18px; }
        .finance-kicker { margin: 0 0 7px; color: #dbb78f; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
        .finance-title { margin: 0; color: #fff7ed; font-size: clamp(26px, 4vw, 34px); font-weight: 800; }
        .finance-description { margin: 9px 0 0; color: #e9d8c5; font-size: 13px; line-height: 1.6; }
        .finance-summary { margin-bottom: 16px; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }
        .summary-card { padding: 19px; background: var(--cream); border: 1px solid rgb(255 255 255 / 75%); border-radius: 12px; box-shadow: 0 8px 22px rgb(0 0 0 / 14%); }
        .summary-label { margin: 0 0 7px; color: #806b57; font-size: 10px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; }
        .summary-value { margin: 0; color: #3b281b; font-size: 24px; font-weight: 800; }
        .summary-caption { margin: 6px 0 0; color: #806f60; font-size: 10px; }
        .summary-card.balance .summary-value { color: {{ $financeSummary['balance'] < 0 ? '#a22b24' : '#14885e' }}; }
        .finance-panel { padding: 18px; background: var(--cream); border: 1px solid rgb(255 255 255 / 75%); border-radius: 15px; box-shadow: 0 12px 36px rgb(0 0 0 / 18%); }
        .panel-heading { margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        .panel-title { margin: 0; color: #2b1d13; font-size: 17px; font-weight: 800; }
        .export-button { min-height: 38px; padding: 0 13px; display: inline-flex; align-items: center; justify-content: center; color: #fff8ed; background: #14885e; border-radius: 8px; font-size: 10px; font-weight: 800; text-decoration: none; white-space: nowrap; }
        .export-button:hover { background: #0e6f4c; }
        .finance-panel + .finance-panel { margin-top: 16px; }
        .expense-actions { display: flex; align-items: flex-start; justify-content: flex-end; gap: 8px; }
        .expense-edit-toggle, .expense-delete { min-height: 32px; padding: 0 10px; display: inline-flex; align-items: center; justify-content: center; border: 0; border-radius: 7px; cursor: pointer; font: inherit; font-size: 10px; font-weight: 800; }
        .expense-edit-toggle { color: #fff8ed; background: #59341e; }
        .expense-delete { color: #fff8ed; background: #8b312a; }
        .expense-edit-form { min-width: 280px; margin-top: 9px; padding: 12px; display: grid; gap: 8px; background: #f8f5ed; border: 1px solid #e5dac9; border-radius: 9px; }
        .expense-edit-form input, .expense-edit-form textarea { width: 100%; min-height: 36px; padding: 7px 9px; color: #2b1d13; background: #fffaf0; border: 1px solid #d9c9b3; border-radius: 7px; font: inherit; font-size: 11px; }
        .expense-edit-form textarea { min-height: 56px; resize: vertical; }
        .expense-delete-form { margin: 0; }
        .flash-message { margin-bottom: 14px; padding: 12px 15px; color: #20563c; background: #e8f1e6; border: 1px solid #cbdcc6; border-radius: 9px; font-size: 12px; font-weight: 700; }
        .validation-errors { margin-bottom: 14px; padding: 12px 15px; color: #7c2620; background: #fff0e9; border: 1px solid #edc6b7; border-radius: 9px; font-size: 12px; }
        .validation-errors ul { margin: 0; padding-left: 18px; }
        .expense-form { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
        .expense-field { display: grid; gap: 6px; }
        .expense-field.full { grid-column: 1 / -1; }
        .expense-field label { color: #6b5745; font-size: 10px; font-weight: 800; text-transform: uppercase; }
        .expense-field input, .expense-field textarea { width: 100%; min-height: 42px; padding: 9px 11px; color: #2b1d13; background: var(--cream-light); border: 1px solid #d9c9b3; border-radius: 8px; font: inherit; font-size: 12px; }
        .expense-field textarea { min-height: 74px; resize: vertical; }
        .expense-field input:focus, .expense-field textarea:focus { border-color: #9c6c45; outline: 2px solid rgb(156 108 69 / 20%); }
        .field-error { color: #8b312a; font-size: 10px; font-weight: 700; }
        .submit-expense { min-height: 42px; grid-column: 1 / -1; justify-self: start; padding: 0 16px; color: #fff8ed; background: #7c1d1d; border: 0; border-radius: 9px; cursor: pointer; font: inherit; font-size: 11px; font-weight: 800; }
        .submit-expense:hover { background: #541515; }
        .table-scroll { overflow-x: auto; }
        .finance-table { width: 100%; min-width: 850px; border-collapse: collapse; font-size: 12px; }
        .finance-table th { padding: 13px 11px; color: #806b57; border-bottom: 1px solid #ded2c0; font-size: 9px; font-weight: 800; letter-spacing: 0.9px; text-align: left; text-transform: uppercase; }
        .finance-table td { padding: 14px 11px; color: #4c3b2c; border-bottom: 1px solid #e6dccd; vertical-align: middle; }
        .finance-table tbody tr:last-child td { border-bottom: 0; }
        .finance-id, .finance-customer { color: #2b1d13 !important; font-weight: 800; }
        .finance-products { max-width: 270px; color: #806f60 !important; line-height: 1.5; }
        .finance-amount { color: #3b281b !important; font-weight: 800; text-align: right; white-space: nowrap; }
        .expense-amount { color: #a22b24 !important; font-weight: 800; text-align: right; white-space: nowrap; }
        .expense-category { color: #2b1d13 !important; font-weight: 800; }
        .expense-description { max-width: 300px; color: #806f60 !important; line-height: 1.5; }
        .expense-user { color: #806f60 !important; }
        .finance-method { white-space: nowrap; }
        .empty-state { padding: 48px 16px; color: #887966; font-size: 12px; font-weight: 700; text-align: center; }
        .pagination-wrap { margin-top: 14px; padding-top: 14px; border-top: 1px solid #e5dac9; }
        .pagination-wrap nav { display: flex; justify-content: center; }
        @media (max-width: 620px) {
            body { padding: 9px; background-attachment: scroll; }
            .finance-header { padding: 12px; }
            .finance-brand { font-size: 12px; }
            .finance-nav { gap: 5px; }
            .finance-nav a, .finance-nav button { min-height: 36px; padding: 0 9px; font-size: 10px; }
            .finance-heading { margin-top: 28px; }
            .finance-summary { grid-template-columns: minmax(0, 1fr); gap: 8px; }
            .summary-card { padding: 15px; }
            .summary-value { font-size: 21px; }
            .expense-form { grid-template-columns: minmax(0, 1fr); }
            .expense-field.full, .submit-expense { grid-column: 1; }
            .panel-heading { align-items: flex-start; flex-direction: column; }
            .finance-panel { padding: 12px 9px; }
            .finance-table { min-width: 800px; }
        }
    </style>
</head>
<body>
    <main class="finance-shell">
        <header class="finance-header">
            <a class="finance-brand" href="{{ route('dashboard') }}">KOPI-BOY</a>
            <nav class="finance-nav" aria-label="Navigasi keuangan">
                <a href="{{ route('management.index') }}">Manajemen</a>
                <a href="{{ route('payments.index') }}">Pembayaran</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </nav>
        </header>

        <section aria-labelledby="finance-title">
            <div class="finance-heading">
                <p class="finance-kicker">Laporan transaksi</p>
                <h1 id="finance-title" class="finance-title">Keuangan</h1>
                <p class="finance-description">Catat uang keluar dan pantau pemasukan, pengeluaran, serta saldo bersih kedai.</p>
            </div>

            @if (session('success'))
                <div class="flash-message" role="status">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="validation-errors" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="finance-summary" aria-label="Ringkasan keuangan">
                <article class="summary-card">
                    <p class="summary-label">Total pemasukan</p>
                    <p class="summary-value">Rp{{ number_format($financeSummary['revenue'], 0, ',', '.') }}</p>
                    <p class="summary-caption">Dari pembayaran pesanan yang sudah diterima</p>
                </article>
                <article class="summary-card">
                    <p class="summary-label">Total pengeluaran</p>
                    <p class="summary-value">Rp{{ number_format($financeSummary['expenses'], 0, ',', '.') }}</p>
                    <p class="summary-caption">{{ number_format($financeSummary['expenseCount'], 0, ',', '.') }} catatan pengeluaran</p>
                </article>
                <article class="summary-card balance">
                    <p class="summary-label">Saldo bersih</p>
                    <p class="summary-value">Rp{{ number_format($financeSummary['balance'], 0, ',', '.') }}</p>
                    <p class="summary-caption">Pemasukan dikurangi pengeluaran</p>
                </article>
            </section>

            <section class="finance-panel" aria-labelledby="expense-form-title">
                <div class="panel-heading">
                    <h2 id="expense-form-title" class="panel-title">Catat Uang Keluar</h2>
                </div>
                <form class="expense-form" action="{{ route('management.expenses.store') }}" method="POST">
                    @csrf
                    <div class="expense-field">
                        <label for="expense-category">Kategori pengeluaran</label>
                        <input
                            id="expense-category"
                            name="category"
                            type="text"
                            maxlength="100"
                            value="{{ old('category') }}"
                            placeholder="Contoh: bahan baku, listrik, sewa"
                            required
                        >
                        @error('category')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="expense-field">
                        <label for="expense-amount">Nominal (Rp)</label>
                        <input
                            id="expense-amount"
                            name="amount"
                            type="number"
                            min="1"
                            max="9999999999"
                            step="1"
                            value="{{ old('amount') }}"
                            placeholder="Contoh: 50000"
                            required
                        >
                        @error('amount')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="expense-field">
                        <label for="expense-date">Tanggal pengeluaran</label>
                        <input
                            id="expense-date"
                            name="expense_date"
                            type="date"
                            value="{{ old('expense_date', now()->toDateString()) }}"
                            required
                        >
                        @error('expense_date')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="expense-field full">
                        <label for="expense-description">Keterangan (opsional)</label>
                        <textarea id="expense-description" name="description" maxlength="1000" placeholder="Tambahkan detail pengeluaran">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <button class="submit-expense" type="submit">Simpan Pengeluaran</button>
                </form>
            </section>

            <section class="finance-panel" aria-labelledby="expenses-title">
                <div class="panel-heading">
                    <h2 id="expenses-title" class="panel-title">Riwayat Uang Keluar</h2>
                </div>
                @if ($expenses->isEmpty())
                    <div class="empty-state">Belum ada pengeluaran yang dicatat.</div>
                @else
                    <div class="table-scroll">
                        <table class="finance-table">
                            <thead>
                                <tr>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Dicatat oleh</th>
                                    <th scope="col" style="text-align: right">Nominal</th>
                                    <th scope="col" style="text-align: right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ \Illuminate\Support\Carbon::parse($expense->expense_date)->format('d M Y') }}</td>
                                        <td class="expense-category">{{ $expense->category }}</td>
                                        <td class="expense-description">{{ $expense->description ?: '—' }}</td>
                                        <td class="expense-user">{{ $expense->user?->name ?? 'Pengguna dihapus' }}</td>
                                        <td class="expense-amount">Rp{{ number_format($expense->amount, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="expense-actions">
                                                <details>
                                                    <summary class="expense-edit-toggle">Edit</summary>
                                                    <form class="expense-edit-form" action="{{ route('management.expenses.update', $expense) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="text" name="category" value="{{ $expense->category }}" maxlength="100" aria-label="Kategori pengeluaran" required>
                                                        <input type="number" name="amount" value="{{ (int) $expense->amount }}" min="1" max="9999999999" step="1" aria-label="Nominal pengeluaran" required>
                                                        <input type="date" name="expense_date" value="{{ \Illuminate\Support\Carbon::parse($expense->expense_date)->toDateString() }}" aria-label="Tanggal pengeluaran" required>
                                                        <textarea name="description" maxlength="1000" aria-label="Keterangan pengeluaran" placeholder="Keterangan (opsional)">{{ $expense->description }}</textarea>
                                                        <button class="expense-edit-toggle" type="submit">Simpan Perubahan</button>
                                                    </form>
                                                </details>
                                                <form class="expense-delete-form" action="{{ route('management.expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus catatan pengeluaran ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="expense-delete" type="submit">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($expenses->hasPages())
                        <div class="pagination-wrap">{{ $expenses->links() }}</div>
                    @endif
                @endif
            </section>

            <section class="finance-panel" aria-labelledby="finance-transactions-title">
                <div class="panel-heading">
                    <h2 id="finance-transactions-title" class="panel-title">Riwayat Pemasukan Pelanggan</h2>
                    <a class="export-button" href="{{ route('management.finance.export') }}">Unduh XLSX</a>
                </div>
                @if ($payments->isEmpty())
                    <div class="empty-state">Belum ada pembayaran pesanan yang selesai.</div>
                @else
                    <div class="table-scroll">
                        <table class="finance-table">
                            <thead>
                                <tr>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Pelanggan</th>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Waktu Dibayar</th>
                                    <th scope="col">Metode</th>
                                    <th scope="col" style="text-align: right">Pemasukan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td class="finance-id">{{ $payment->order->invoice }}</td>
                                        <td class="finance-customer">{{ $payment->order->user?->name ?? 'Pelanggan dihapus' }}</td>
                                        <td class="finance-products">
                                            {{ $payment->order->items->map(fn ($item) => $item->name . ' × ' . $item->quantity)->implode(', ') ?: '—' }}
                                        </td>
                                        <td>{{ \Illuminate\Support\Carbon::parse($payment->paid_at ?? $payment->created_at)->format('d M Y • H:i') }}</td>
                                        <td class="finance-method">{{ $payment->method ?? '—' }}</td>
                                        <td class="finance-amount">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($payments->hasPages())
                        <div class="pagination-wrap">{{ $payments->links() }}</div>
                    @endif
                @endif
            </section>
        </section>
    </main>
</body>
</html>
