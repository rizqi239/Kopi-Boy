<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#321b10">
  <title>Menu - Kedai Smart Pinky</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root { --coffee: #4b2b19; --cream: #f5edda; --cream-light: #fffaf0; --ink: #241a14; }
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
    .menu-main { max-width: 1720px; margin: 30px auto 0; }
    .menu-heading { margin-bottom: 20px; display: flex; align-items: end; justify-content: space-between; gap: 20px; }
    .menu-kicker { margin: 0 0 7px; color: #dbb78f; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
    .menu-title { margin: 0; color: #fff7ed; font-size: 29px; font-weight: 800; }
    .menu-subtitle { margin: 7px 0 0; color: #e9d8c5; font-size: 13px; }
    .menu-heading-actions { display: flex; flex-wrap: wrap; gap: 9px; }
    .heading-action { min-height: 42px; padding: 0 16px; display: inline-flex; align-items: center; justify-content: center; color: #fff8ed; background: #59341e; border-radius: 9px; font-size: 12px; font-weight: 800; text-decoration: none; white-space: nowrap; }
    .heading-action.secondary { color: #3f2a1b; background: var(--cream); }
    .heading-action:hover { filter: brightness(1.08); }
    .menu-toolbar { margin-bottom: 18px; display: flex; align-items: center; gap: 12px; }
    .category-tabs { min-width: 0; flex: 0 1 auto; display: flex; align-items: center; gap: 9px; overflow-x: auto; scrollbar-width: none; }
    .menu-toolbar > .heading-action { flex: 0 0 auto; }
    .category-tabs::-webkit-scrollbar { display: none; }
    .category-tab { padding: 9px 16px; color: #38271b; background: var(--cream); border: 1px solid rgb(255 255 255 / 40%); border-radius: 999px; font-size: 13px; font-weight: 700; text-decoration: none; white-space: nowrap; transition: background 150ms ease, color 150ms ease; }
    .category-tab:hover, .category-tab.active { color: #fff8ed; background: #7a4d30; }
    .menu-search { width: min(360px, 42%); min-height: 45px; padding: 0 15px; color: var(--ink); background: #fffaf0; border: 1px solid #e5d8c5; border-radius: 9px; outline: none; font: inherit; font-size: 12px; }
    .menu-search:focus { border-color: #c49a70; }
    .flash-message { margin-bottom: 18px; padding: 13px 16px; color: #20563c; background: #e8f1e6; border: 1px solid #cbdcc6; border-radius: 9px; font-size: 12px; font-weight: 700; }
    .menu-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; }
    .menu-card { min-width: 0; padding: 10px; display: flex; flex-direction: column; background: var(--cream-light); border: 1px solid rgb(255 255 255 / 70%); border-radius: 13px; box-shadow: 0 8px 22px rgb(0 0 0 / 16%); transition: transform 150ms ease, box-shadow 150ms ease; }
    .menu-card:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgb(0 0 0 / 22%); }
    .menu-card-image { position: relative; width: 100%; aspect-ratio: 1.2; overflow: hidden; background: #e8ddca; border-radius: 9px; }
    .menu-card-image img { width: 100%; height: 100%; display: block; object-fit: cover; transition: transform 180ms ease; }
    .menu-card:hover .menu-card-image img { transform: scale(1.035); }
    .menu-image-empty { width: 100%; height: 100%; display: grid; place-items: center; color: #9a8978; font-size: 10px; font-weight: 800; text-transform: uppercase; }
    .menu-category { position: absolute; top: 9px; left: 9px; padding: 6px 9px; color: #55361f; background: rgb(255 250 240 / 94%); border-radius: 999px; font-size: 9px; font-weight: 800; text-transform: uppercase; }
    .menu-card-body { padding: 12px 3px 5px; }
    .menu-card-title { margin: 0; overflow: hidden; color: #2b1d13; font-size: 15px; font-weight: 800; line-height: 1.25; text-overflow: ellipsis; white-space: nowrap; }
    .menu-description { min-height: 34px; margin: 6px 0 12px; overflow: hidden; color: #806f60; font-size: 11px; line-height: 1.55; }
    .menu-card-footer { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .menu-price-label { display: block; margin-bottom: 3px; color: #958572; font-size: 9px; font-weight: 800; letter-spacing: 0.8px; text-transform: uppercase; }
    .card-actions { display: flex; align-items: center; gap: 6px; }
    .edit-button { width: 36px; height: 36px; display: grid; place-items: center; color: #806a55; background: #f2e8d9; border: 0; border-radius: 8px; cursor: pointer; text-decoration: none; transition: color 150ms ease, background 150ms ease; }
    .edit-button:hover { color: #fff; background: #4b2b19; }
    .edit-button svg { width: 17px; height: 17px; }
    .delete-button { width: 36px; height: 36px; display: grid; place-items: center; color: #806a55; background: #f2e8d9; border: 0; border-radius: 8px; cursor: pointer; transition: color 150ms ease, background 150ms ease; }
    .delete-button:hover { color: #fff; background: #8b312a; }
    .delete-button svg { width: 17px; height: 17px; }
    .empty-menus { grid-column: 1 / -1; padding: 52px 18px; color: #efe2d1; background: rgb(52 29 17 / 75%); border: 1px dashed rgb(255 244 231 / 35%); border-radius: 14px; font-size: 13px; font-weight: 700; text-align: center; }
    .pagination-wrap { margin-top: 20px; padding: 13px 16px; background: var(--cream); border-radius: 10px; }
    .pagination-wrap nav { display: flex; justify-content: center; }
    .pos-footer { max-width: 1720px; margin: 20px auto 0; padding: 12px 4px 4px; color: #e8d9c8; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
    @media (max-width: 1250px) {
      .pos-header { grid-template-columns: 1fr auto; }
      .workflow { grid-column: 1 / -1; grid-row: 2; justify-self: center; }
      .header-tools { grid-column: 2; grid-row: 1; }
      .menu-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    @media (max-width: 900px) { .menu-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
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
      .menu-main { margin-top: 25px; }
      .menu-heading { align-items: flex-start; flex-direction: column; gap: 14px; }
      .menu-title { font-size: 24px; }
      .menu-toolbar { align-items: center; }
      .category-tabs { width: auto; }
      .menu-toolbar > .heading-action { min-height: 40px; padding: 0 12px; font-size: 11px; }
      .menu-search { width: 100%; }
      .menu-grid { gap: 10px; }
      .menu-card { padding: 8px; }
      .menu-card-image { aspect-ratio: 1.05; }
      .menu-card-title { font-size: 13px; }
      .menu-price { font-size: 14px; }
    }
    @media (max-width: 380px) { .brand-caption { display: none; } .menu-grid { grid-template-columns: 1fr; } }
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

    <main class="menu-main">
      <div class="menu-heading">
        <div>
          <p class="menu-kicker">Katalog Kedai</p>
          <h1 class="menu-title">Daftar Menu</h1>
          <p class="menu-subtitle">Kelola item yang tersedia di Kedai Pinky.</p>
        </div>
      </div>

      @if(session('success'))
        <div class="flash-message" role="status">{{ session('success') }}</div>
      @endif

      <div class="menu-toolbar">
        <nav class="category-tabs" aria-label="Filter kategori menu">
          <a href="{{ route('menus.index') }}" class="category-tab {{ empty($category) ? 'active' : '' }}">Semua</a>
          <a href="{{ route('menus.index', ['category' => 'Kopi']) }}" class="category-tab {{ $category === 'Kopi' ? 'active' : '' }}">Kopi</a>
          <a href="{{ route('menus.index', ['category' => 'Non Kopi']) }}" class="category-tab {{ $category === 'Non Kopi' ? 'active' : '' }}">Non Kopi</a>
          <a href="{{ route('menus.index', ['category' => 'Pastry']) }}" class="category-tab {{ $category === 'Pastry' ? 'active' : '' }}">Pastry</a>
        </nav>
        @if(auth()->user()?->role === 'admin')
          <a href="{{ route('menus.create') }}" class="heading-action">Tambah Menu</a>
        @endif
      </div>

      <div id="menu-grid" class="menu-grid">
        @forelse($menus as $menu)
          <article class="menu-card" data-menu-card>
            <div class="menu-card-image">
              @if($menu->image)
                <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" onerror="this.onerror=null; this.src='{{ asset('image/coffee-login.jpg') }}';">
              @else
                <div class="menu-image-empty">No Image</div>
              @endif
              <span class="menu-category">{{ $menu->category ?? 'Umum' }}</span>
            </div>

            <div class="menu-card-body">
              <h2 class="menu-card-title">{{ $menu->name }}</h2>
              <p class="menu-description">{{ \Illuminate\Support\Str::limit($menu->description, 70) }}</p>
              <div class="menu-card-footer">
                <div>
                  <span class="menu-price-label">Harga</span>
                  <span class="menu-price">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
                  @if(isset($menu->stock))
                    <span style="display:block;font-size:10px;color:#85776c;margin-top:2px;font-weight:600;">Stok: {{ $menu->stock }}</span>
                  @endif
                </div>
                @if(auth()->user()?->role === 'admin')
                  <div class="card-actions">
                    <a href="{{ route('menus.edit', $menu) }}" class="edit-button" title="Edit menu" aria-label="Edit {{ $menu->name }}">
                      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                    </a>
                    <form method="POST" action="{{ route('menus.destroy', $menu) }}" onsubmit="return confirm('Hapus menu {{ $menu->name }}?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="delete-button" title="Hapus menu" aria-label="Hapus {{ $menu->name }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16m-10 4v6m4-6v6M6 7l1 13h10l1-13M9 7V4h6v3"/></svg>
                      </button>
                    </form>
                  </div>
                @endif
              </div>
            </div>
          </article>
        @empty
          <div class="empty-menus">Belum ada menu yang didaftarkan.</div>
        @endforelse
      </div>

      @if($menus->hasPages())
        <div class="pagination-wrap">{{ $menus->links() }}</div>
      @endif
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

    const menuSearch = document.getElementById('menu-search');
    menuSearch?.addEventListener('input', () => {
      const query = menuSearch.value.trim().toLocaleLowerCase('id-ID');
      document.querySelectorAll('[data-menu-card]').forEach(card => {
        card.hidden = !card.textContent.toLocaleLowerCase('id-ID').includes(query);
      });
    });
  </script>
  @stack('scripts')
</body>
</html>
