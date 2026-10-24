<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#321b10">
    <title>Stock Opname - KOPI-BOY</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --cream: #f5edda; --cream-light: #fffaf0; --ink: #241a14; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; padding: 16px; color: var(--ink); background: linear-gradient(110deg, rgb(36 20 12 / 88%), rgb(47 26 16 / 72%)), url('{{ asset('image/coffee-login.jpg') }}') center / cover fixed; font-family: 'DM Sans', sans-serif; }
        .opname-shell { max-width: 1300px; margin: 0 auto; }
        .opname-header { min-height: 82px; padding: 15px 20px; display: flex; align-items: center; justify-content: space-between; gap: 16px; background: var(--cream); border: 1px solid rgb(255 255 255 / 68%); border-radius: 14px; box-shadow: 0 8px 25px rgb(0 0 0 / 12%); }
        .opname-brand { color: #4b2b19; font-size: 16px; font-weight: 800; letter-spacing: 1px; text-decoration: none; text-transform: uppercase; }
        .opname-nav { display: flex; align-items: center; gap: 9px; }
        .opname-nav a, .opname-nav button { min-height: 40px; padding: 0 14px; display: inline-flex; align-items: center; justify-content: center; color: #fff8ed; background: #482817; border: 0; border-radius: 9px; font: inherit; font-size: 11px; font-weight: 800; text-decoration: none; cursor: pointer; }
        .opname-nav a:hover, .opname-nav button:hover { background: #684329; }
        .opname-nav form { margin: 0; }
        .opname-heading { margin: 36px 0 18px; }
        .opname-kicker { margin: 0 0 7px; color: #dbb78f; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
        .opname-title { margin: 0; color: #fff7ed; font-size: clamp(26px, 4vw, 34px); font-weight: 800; }
        .opname-description { margin: 9px 0 0; color: #e9d8c5; font-size: 13px; line-height: 1.6; }
        .flash-message, .validation-message { margin-bottom: 14px; padding: 13px 16px; border-radius: 9px; font-size: 12px; font-weight: 700; }
        .flash-message { color: #20563c; background: #e8f1e6; border: 1px solid #cbdcc6; }
        .validation-message { color: #7c2620; background: #fff0e9; border: 1px solid #edc6b7; }
        .opname-panel { margin-bottom: 18px; padding: 20px; background: var(--cream); border: 1px solid rgb(255 255 255 / 75%); border-radius: 14px; box-shadow: 0 12px 36px rgb(0 0 0 / 18%); }
        .panel-heading { margin: 0 0 14px; color: #2b1d13; font-size: 17px; font-weight: 800; }
        .table-scroll { overflow-x: auto; }
        .opname-table { width: 100%; border-collapse: collapse; font-size: 12px; }
        .opname-table th { padding: 12px 10px; color: #806b57; border-bottom: 1px solid #ded2c0; font-size: 9px; font-weight: 800; letter-spacing: 0.9px; text-align: left; text-transform: uppercase; }
        .opname-table td { padding: 12px 10px; color: #4c3b2c; border-bottom: 1px solid #e6dccd; vertical-align: middle; }
        .opname-table tbody tr:last-child td { border-bottom: 0; }
        .stock-value { color: #2b1d13; font-weight: 800; }
        .count-input { width: 130px; min-height: 40px; padding: 0 11px; color: #2b1d13; background: #fffaf0; border: 1px solid #d9c9b3; border-radius: 8px; font: inherit; font-size: 13px; font-weight: 700; }
        .count-input:focus, .notes-input:focus { border-color: #9c6c45; outline: 2px solid rgb(156 108 69 / 20%); }
        .field-error { margin: 5px 0 0; color: #8b312a; font-size: 10px; font-weight: 700; }
        .notes-label { margin: 16px 0 6px; display: block; color: #6b5745; font-size: 10px; font-weight: 800; text-transform: uppercase; }
        .notes-input { width: 100%; min-height: 72px; padding: 10px 12px; color: #2b1d13; background: #fffaf0; border: 1px solid #d9c9b3; border-radius: 8px; font: inherit; font-size: 12px; resize: vertical; }
        .submit-opname { min-height: 44px; margin-top: 14px; padding: 0 17px; color: #fff8ed; background: #7c1d1d; border: 0; border-radius: 9px; cursor: pointer; font: inherit; font-size: 11px; font-weight: 800; }
        .submit-opname:hover { background: #541515; }
        .submit-opname:disabled { opacity: 0.5; cursor: not-allowed; }
        .empty-state { padding: 30px 14px; color: #887966; font-size: 12px; font-weight: 700; text-align: center; }
        .history-list { display: grid; gap: 12px; }
        .history-entry { padding: 15px; background: var(--cream-light); border: 1px solid #e6dccd; border-radius: 10px; }
        .history-heading { margin-bottom: 8px; display: flex; justify-content: space-between; gap: 14px; color: #2b1d13; font-size: 12px; font-weight: 800; }
        .history-meta { color: #806f60; font-size: 10px; font-weight: 600; }
        .history-note { margin: 0 0 9px; color: #806f60; font-size: 11px; }
        .history-items { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 6px 14px; }
        .history-item { display: flex; justify-content: space-between; gap: 10px; color: #4c3b2c; font-size: 11px; }
        .difference { font-weight: 800; white-space: nowrap; }
        .difference.positive { color: #14885e; }
        .difference.negative { color: #a22b24; }
        .difference.neutral { color: #806f60; }
        .pagination-wrap { margin-top: 14px; padding-top: 14px; border-top: 1px solid #e5dac9; }
        .pagination-wrap nav { display: flex; justify-content: center; }
        @media (max-width: 620px) {
            body { padding: 9px; background-attachment: scroll; }
            .opname-header { padding: 12px; }
            .opname-brand { font-size: 12px; }
            .opname-nav { gap: 5px; }
            .opname-nav a, .opname-nav button { min-height: 36px; padding: 0 9px; font-size: 10px; }
            .opname-heading { margin-top: 28px; }
            .opname-panel { padding: 14px 10px; }
            .opname-table { min-width: 470px; }
            .history-heading { flex-direction: column; gap: 4px; }
            .history-items { grid-template-columns: minmax(0, 1fr); }
        }
    </style>
</head>
<body>
    <main class="opname-shell">
        <header class="opname-header">
            <a class="opname-brand" href="{{ route('dashboard') }}">KOPI-BOY</a>
            <nav class="opname-nav" aria-label="Navigasi stock opname">
                <a href="{{ route('management.index') }}">Manajemen</a>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </nav>
        </header>

        <section aria-labelledby="opname-title">
            <div class="opname-heading">
                <p class="opname-kicker">Manajemen persediaan</p>
                <h1 id="opname-title" class="opname-title">Stock Opname</h1>
                <p class="opname-description">Masukkan jumlah fisik seluruh menu. Stok sistem akan diperbarui setelah opname berhasil disimpan.</p>
            </div>

            @if (session('success'))
                <div class="flash-message" role="status">{{ session('success') }}</div>
            @endif
            @if ($errors->has('counts'))
                <div class="validation-message" role="alert">{{ $errors->first('counts') }}</div>
            @endif

            <section class="opname-panel" aria-labelledby="new-opname-title">
                <h2 id="new-opname-title" class="panel-heading">Catat Stok Fisik</h2>
                @if ($menus->isEmpty())
                    <div class="empty-state">Belum ada menu yang dapat dihitung. Tambahkan menu terlebih dahulu.</div>
                @else
                    <form action="{{ route('stock-opnames.store') }}" method="POST">
                        @csrf
                        <div class="table-scroll">
                            <table class="opname-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Menu</th>
                                        <th scope="col">Stok Sistem</th>
                                        <th scope="col">Stok Fisik</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <td>{{ $menu->name }}</td>
                                            <td class="stock-value">{{ $menu->stock }} unit</td>
                                            <td>
                                                <input
                                                    class="count-input"
                                                    type="number"
                                                    name="counts[{{ $menu->id }}]"
                                                    min="0"
                                                    step="1"
                                                    value="{{ old('counts.' . $menu->id) }}"
                                                    aria-label="Stok fisik {{ $menu->name }}"
                                                    required
                                                >
                                                @error('counts.' . $menu->id)
                                                    <p class="field-error">{{ $message }}</p>
                                                @enderror
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <label class="notes-label" for="opname-notes">Catatan (opsional)</label>
                        <textarea class="notes-input" id="opname-notes" name="notes" maxlength="1000" placeholder="Contoh: pemeriksaan stok akhir minggu">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                        <button class="submit-opname" type="submit">Simpan Stock Opname</button>
                    </form>
                @endif
            </section>

            <section class="opname-panel" aria-labelledby="opname-history-title">
                <h2 id="opname-history-title" class="panel-heading">Riwayat Stock Opname</h2>
                @forelse ($opnames as $opname)
                    <article class="history-entry">
                        <div class="history-heading">
                            <span>{{ $opname->created_at->format('d/m/Y H:i') }}</span>
                            <span class="history-meta">Oleh {{ $opname->user?->name ?? 'Pengguna dihapus' }}</span>
                        </div>
                        @if ($opname->notes)
                            <p class="history-note">{{ $opname->notes }}</p>
                        @endif
                        <div class="history-items">
                            @foreach ($opname->items as $item)
                                <div class="history-item">
                                    <span>{{ $item->menu_name }} ({{ $item->expected_stock }} &rarr; {{ $item->counted_stock }})</span>
                                    <span class="difference {{ $item->difference > 0 ? 'positive' : ($item->difference < 0 ? 'negative' : 'neutral') }}">
                                        {{ $item->difference > 0 ? '+' : '' }}{{ $item->difference }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </article>
                @empty
                    <div class="empty-state">Belum ada riwayat stock opname.</div>
                @endforelse

                @if ($opnames->hasPages())
                    <div class="pagination-wrap">{{ $opnames->links() }}</div>
                @endif
            </section>
        </section>
    </main>
</body>
</html>
