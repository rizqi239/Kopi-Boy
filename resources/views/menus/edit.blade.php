<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#321b10">
  <title>Edit Menu: {{ $menu->name }} - Kedai Smart Pinky</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --coffee: #4b2b19; --cream: #f5edda; --cream-light: #fffaf0; --ink: #241a14; --muted: #85776c; }
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
    .form-main { max-width: 1150px; margin: 36px auto 0; }
    .form-heading { margin-bottom: 20px; display: flex; align-items: end; justify-content: space-between; gap: 20px; }
    .form-kicker { margin: 0 0 7px; color: #dbb78f; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
    .form-title { margin: 0; color: #fff7ed; font-size: 29px; font-weight: 800; }
    .form-description { margin: 7px 0 0; color: #e9d8c5; font-size: 13px; }
    .back-link { min-height: 42px; padding: 0 16px; display: inline-flex; align-items: center; justify-content: center; color: #3f2a1b; background: var(--cream); border-radius: 9px; font-size: 12px; font-weight: 800; text-decoration: none; white-space: nowrap; }
    .back-link:hover { background: #fffaf0; }
    .error-panel { margin-bottom: 16px; padding: 13px 16px; color: #64271f; background: #f8e3d9; border: 1px solid #e9b8a7; border-left: 4px solid #ad513c; border-radius: 8px; font-size: 12px; }
    .error-panel ul { margin: 0; padding-left: 18px; }
    .menu-form { padding: 24px; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; background: var(--cream); border: 1px solid rgb(255 255 255 / 70%); border-radius: 16px; box-shadow: 0 12px 36px rgb(0 0 0 / 18%); }
    .field { min-width: 0; }
    .field.full { grid-column: 1 / -1; }
    .field label { margin-bottom: 7px; display: block; color: #49301e; font-size: 12px; font-weight: 800; }
    .field input, .field textarea, .field select { width: 100%; min-height: 46px; padding: 11px 13px; color: #2d2118; background: #fffdf8; border: 1px solid #d9cbb7; border-radius: 7px; outline: none; font: inherit; font-size: 13px; }
    .field textarea { min-height: 118px; resize: vertical; }
    .field input:focus, .field textarea:focus, .field select:focus { border-color: #9a6945; box-shadow: 0 0 0 2px rgb(154 105 69 / 16%); }
    .field input::placeholder, .field textarea::placeholder { color: #a09283; }
    .field input[type="file"] { padding: 7px; color: #6f5b49; }
    .field input[type="file"]::file-selector-button { margin-right: 12px; padding: 8px 12px; color: #fff8ed; background: #59341e; border: 0; border-radius: 6px; cursor: pointer; font: inherit; font-size: 11px; font-weight: 700; }
    .image-preview-card { display: flex; align-items: center; gap: 14px; margin-bottom: 10px; padding: 10px 14px; background: #ede3d1; border: 1px solid #ddceba; border-radius: 9px; }
    .image-preview-thumb { width: 64px; height: 64px; border-radius: 7px; object-fit: cover; border: 1px solid #c7b8a5; background: #e0d2bf; }
    .image-preview-info { font-size: 12px; color: #583c27; }
    .image-preview-info strong { display: block; margin-bottom: 2px; }
    .form-actions { grid-column: 1 / -1; padding-top: 17px; display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dfd3c2; }
    .form-button { min-height: 44px; padding: 0 18px; display: inline-flex; align-items: center; justify-content: center; border: 0; border-radius: 8px; cursor: pointer; font: inherit; font-size: 12px; font-weight: 800; text-decoration: none; }
    .form-button.cancel { color: #473629; background: #e9dfd0; }
    .form-button.cancel:hover { background: #ded0bc; }
    .form-button.submit { color: #fffaf1; background: #59341e; }
    .form-button.submit:hover { background: #7b4b2c; }
    .pos-footer { max-width: 1150px; margin: 20px auto 0; padding: 13px 4px; color: #e8d9c8; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
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
      .form-main { margin-top: 25px; }
      .form-heading { align-items: flex-start; flex-direction: column; gap: 14px; }
      .form-title { font-size: 24px; }
      .menu-form { padding: 16px; grid-template-columns: 1fr; gap: 16px; border-radius: 12px; }
      .field.full, .form-actions { grid-column: auto; }
      .form-actions { justify-content: stretch; }
      .form-button { flex: 1; }
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
        <a href="{{ route('menus.index') }}" aria-current="page">Menu</a>
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

    <main class="form-main">
      <div class="form-heading">
        <div>
          <p class="form-kicker">Pengelolaan Menu</p>
          <h1 class="form-title">Edit Menu: {{ $menu->name }}</h1>
          <p class="form-description">Perbarui informasi item yang ditampilkan di katalog dan sistem kasir.</p>
        </div>
        <a href="{{ route('menus.index') }}" class="back-link">Kembali ke Daftar Menu</a>
      </div>

      @if(isset($errors) && $errors->any())
        <div class="error-panel" role="alert">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('menus.update', $menu) }}" enctype="multipart/form-data" class="menu-form">
        @csrf
        @method('PUT')

        <div class="field">
          <label for="name">Nama Menu</label>
          <input id="name" type="text" name="name" value="{{ old('name', $menu->name) }}" placeholder="Contoh: Cappuccino" required>
        </div>

        <div class="field">
          <label for="category">Kategori</label>
          <input id="category" list="category-options" type="text" name="category" value="{{ old('category', $menu->category) }}" placeholder="Pilih atau ketik kategori..." required>
          <datalist id="category-options">
            <option value="Kopi"></option>
            <option value="Non Kopi"></option>
            <option value="Pastry"></option>
            <option value="Makanan"></option>
            <option value="Minuman"></option>
            <option value="Snack"></option>
          </datalist>
        </div>

        <div class="field">
          <label for="price">Harga (Rp)</label>
          <input id="price" type="number" name="price" value="{{ old('price', (int)$menu->price) }}" min="0" step="1" placeholder="0" required>
        </div>

        <div class="field">
          <label for="stock">Stok Tersedia</label>
          <input id="stock" type="number" name="stock" value="{{ old('stock', $menu->stock ?? 0) }}" min="0" step="1" placeholder="0">
        </div>

        <div class="field full">
          <label for="image">Gambar Menu</label>
          @if($menu->image)
            <div class="image-preview-card">
              <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="image-preview-thumb" onerror="this.onerror=null; this.src='{{ asset('image/coffee-login.jpg') }}';">
              <div class="image-preview-info">
                <strong>Foto Saat Ini</strong>
                <span>Pilih file baru di bawah ini jika ingin mengganti gambar produk.</span>
              </div>
            </div>
          @endif
          <input id="image" type="file" name="image" accept=".jpg,.jpeg,.png,.webp,.gif,image/jpeg,image/png,image/webp,image/gif">
        </div>

        <div class="field full">
          <label for="description">Deskripsi</label>
          <textarea id="description" name="description" rows="4" placeholder="Deskripsi singkat menu">{{ old('description', $menu->description) }}</textarea>
        </div>

        <div class="form-actions">
          <a href="{{ route('menus.index') }}" class="form-button cancel">Batal</a>
          <button type="submit" class="form-button submit">Simpan Perubahan</button>
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
