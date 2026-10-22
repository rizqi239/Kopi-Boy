<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#321b10">
    <title>History Kopi - Kedai Smart Pinky</title>
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
        .history-main { max-width: 1500px; margin: 36px auto 0; }
        .history-heading { margin: 0 0 18px; display: flex; align-items: end; justify-content: space-between; gap: 20px; }
        .history-kicker { margin: 0 0 7px; color: #dbb78f; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
        .history-title { margin: 0; color: #fff7ed; font-size: 29px; font-weight: 800; }
        .history-description { margin: 7px 0 0; color: #e9d8c5; font-size: 13px; }
        .story-hero { min-height: 300px; margin-bottom: 38px; display: grid; grid-template-columns: minmax(0, 1fr); overflow: hidden; background: var(--cream); border: 1px solid rgb(255 255 255 / 75%); border-radius: 14px; box-shadow: 0 12px 36px rgb(0 0 0 / 18%); }
        .story-copy { max-width: 900px; padding: 42px 52px; display: flex; flex-direction: column; align-items: flex-start; justify-content: center; }
        .story-kicker { margin: 0 0 12px; color: #8a5835; font-size: 10px; font-weight: 800; letter-spacing: 1.7px; text-transform: uppercase; }
        .story-title { max-width: 620px; margin: 0; color: #2b1d13; font-size: 42px; font-weight: 800; line-height: 1.08; }
        .story-intro { max-width: 540px; margin: 15px 0 0; color: #665546; font-size: 14px; line-height: 1.7; }
        .chapter-links { margin-top: 23px; display: flex; flex-wrap: wrap; gap: 8px; }
        .chapter-links a { padding: 8px 12px; color: #573a25; background: #e8dcc9; border-radius: 999px; font-size: 10px; font-weight: 800; text-decoration: none; }
        .chapter-links a:hover { color: #fffaf2; background: #70472d; }
        .chapter { margin: 0 0 38px; scroll-margin-top: 24px; }
        .chapter-heading { margin-bottom: 15px; }
        .chapter-kicker { margin: 0 0 6px; color: #dbb78f; font-size: 9px; font-weight: 800; letter-spacing: 1.6px; text-transform: uppercase; }
        .chapter-title { margin: 0; color: #fff7ed; font-size: 23px; font-weight: 800; }
        .chapter-intro { margin: 7px 0 0; color: #e9d8c5; font-size: 12px; line-height: 1.6; }
        .knowledge-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; }
        .knowledge-card { min-width: 0; padding: 18px; background: var(--cream); border: 1px solid rgb(255 255 255 / 70%); border-radius: 10px; box-shadow: 0 7px 18px rgb(0 0 0 / 12%); }
        .card-index { color: #986b49; font-size: 9px; font-weight: 800; letter-spacing: 1.2px; }
        .knowledge-card h3 { margin: 9px 0 7px; color: #2b1d13; font-size: 16px; font-weight: 800; }
        .knowledge-card p { margin: 0; color: #685747; font-size: 11px; line-height: 1.65; }
        .card-origin { margin-top: 12px !important; padding-top: 10px; color: #815b3d !important; border-top: 1px solid #dfd2bf; font-size: 9px !important; font-weight: 700; }
        .coffee-timeline { margin: 0 0 38px; padding: 22px; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; background: rgb(52 29 17 / 82%); border: 1px solid rgb(255 255 255 / 14%); border-radius: 12px; }
        .timeline-entry { padding-left: 12px; border-left: 2px solid #bd8c62; }
        .timeline-entry strong { display: block; color: #e0b789; font-size: 10px; letter-spacing: 0.8px; text-transform: uppercase; }
        .timeline-entry span { display: block; margin-top: 5px; color: #f1e7db; font-size: 10px; line-height: 1.5; }
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
            .history-main { margin-top: 25px; }
            .story-copy { padding: 25px; }
            .story-title { font-size: 32px; }
            .chapter-title { font-size: 20px; }
            .knowledge-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .coffee-timeline { grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 17px; }
        }
        @media (max-width: 420px) {
            .brand-caption { display: none; }
            .knowledge-grid, .coffee-timeline { grid-template-columns: 1fr; }
            .knowledge-card { padding: 16px; }
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
                <a href="{{ route('payments.index') }}">Pembayaran</a>
                <span class="workflow-arrow" aria-hidden="true">→</span>
                <a href="{{ route('orders.history') }}" aria-current="page">History Kopi</a>
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

        <main class="history-main">
            <section class="story-hero" aria-labelledby="story-title">
                <div class="story-copy">
                    <p class="story-kicker">Catatan kopi · biji · racikan · seduhan</p>
                    <h1 class="story-title" id="story-title">Setiap cangkir punya cerita.</h1>
                    <p class="story-intro">Kenali karakter biji kopi, perjalanan espresso, dan cara seduh yang membentuk rasa di cangkir.</p>
                    <nav class="chapter-links" aria-label="Daftar bab">
                        <a href="#beans">Biji kopi</a>
                        <a href="#espresso">Racikan espresso</a>
                        <a href="#brew">Metode seduh</a>
                    </nav>
                </div>
            </section>

            <section class="chapter" id="beans" aria-labelledby="beans-title">
                <div class="chapter-heading">
                    <p class="chapter-kicker">01 · Dari kebun</p>
                    <h2 class="chapter-title" id="beans-title">Kenali biji kopinya</h2>
                    <p class="chapter-intro">Spesies, tempat tumbuh, dan proses pascapanen memberi tiap biji karakter yang berbeda.</p>
                </div>
                <div class="knowledge-grid">
                    <article class="knowledge-card">
                        <span class="card-index">BIJI 01</span>
                        <h3>Arabika</h3>
                        <p>Tumbuh baik di dataran tinggi. Rasanya sering lebih berlapis, dengan aroma bunga atau buah dan keasaman yang terasa jelas.</p>
                        <p class="card-origin">Jejak awal: Ethiopia dan dataran tinggi sekitarnya.</p>
                    </article>
                    <article class="knowledge-card">
                        <span class="card-index">BIJI 02</span>
                        <h3>Robusta</h3>
                        <p>Lebih tahan terhadap panas dan hama. Cenderung punya body tebal, rasa kuat, dan kadar kafeina lebih tinggi daripada Arabika.</p>
                        <p class="card-origin">Banyak dibudidayakan di Afrika Barat dan Asia Tenggara.</p>
                    </article>
                    <article class="knowledge-card">
                        <span class="card-index">BIJI 03</span>
                        <h3>Liberika</h3>
                        <p>Bijinya besar dengan aroma khas, kadang mengingatkan pada kayu, bunga, atau buah matang. Jumlah produksinya lebih terbatas.</p>
                        <p class="card-origin">Berasal dari Afrika Barat; kini juga tumbuh di Asia.</p>
                    </article>
                    <article class="knowledge-card">
                        <span class="card-index">BIJI 04</span>
                        <h3>Ekselsa</h3>
                        <p>Dikenal dengan profil asam-buah yang unik. Dalam klasifikasi modern, Excelsa kerap ditempatkan sebagai varietas Liberika.</p>
                        <p class="card-origin">Ditemukan di Afrika Tengah dan ditanam di Asia Tenggara.</p>
                    </article>
                </div>
            </section>

            <section class="coffee-timeline" aria-label="Linimasa singkat kopi">
                <div class="timeline-entry"><strong>Legenda Ethiopia</strong><span>Kisah Kaldi dan kambingnya adalah legenda populer tentang awal kopi.</span></div>
                <div class="timeline-entry"><strong>Yaman · abad ke-15</strong><span>Kopi mulai tercatat sebagai minuman dan dibudidayakan secara luas.</span></div>
                <div class="timeline-entry"><strong>Italia · abad ke-20</strong><span>Mesin bertekanan membentuk budaya espresso modern.</span></div>
                <div class="timeline-entry"><strong>Hari ini</strong><span>Biji dan metode seduh dari berbagai daerah hadir di kedai-kedai dunia.</span></div>
            </section>

            <section class="chapter" id="espresso" aria-labelledby="espresso-title">
                <div class="chapter-heading">
                    <p class="chapter-kicker">02 · Dari mesin espresso</p>
                    <h2 class="chapter-title" id="espresso-title">Racikan yang berawal dari espresso</h2>
                    <p class="chapter-intro">Ekstraksi singkat bertekanan tinggi menjadi dasar berbagai minuman klasik.</p>
                </div>
                <div class="knowledge-grid">
                    <article class="knowledge-card">
                        <span class="card-index">RACIKAN 01</span>
                        <h3>Espresso</h3>
                        <p>Kopi pekat dalam takaran kecil, dibuat dengan mendorong air panas bertekanan melalui bubuk kopi halus. Menjadi dasar banyak menu kedai.</p>
                        <p class="card-origin">Budaya mesin espresso berkembang di Italia pada pergantian abad ke-20.</p>
                    </article>
                    <article class="knowledge-card">
                        <span class="card-index">RACIKAN 02</span>
                        <h3>Americano</h3>
                        <p>Espresso yang ditambahkan air panas. Hasilnya lebih panjang dan ringan, tetapi tetap mempertahankan karakter espresso.</p>
                        <p class="card-origin">Asal namanya sering dikaitkan dengan kebiasaan tentara Amerika di Italia.</p>
                    </article>
                    <article class="knowledge-card">
                        <span class="card-index">RACIKAN 03</span>
                        <h3>Cappuccino</h3>
                        <p>Perpaduan espresso, susu panas, dan busa susu. Tekstur busa memberi lapisan lembut di atas rasa kopi yang tegas.</p>
                        <p class="card-origin">Minuman klasik dalam budaya bar kopi Italia.</p>
                    </article>
                    <article class="knowledge-card">
                        <span class="card-index">RACIKAN 04</span>
                        <h3>Latte</h3>
                        <p>Espresso dengan porsi susu panas lebih banyak dan lapisan busa tipis. Rasanya lembut dan cocok untuk latte art.</p>
                        <p class="card-origin">Nama café latte berarti kopi susu dalam bahasa Italia.</p>
                    </article>
                </div>
            </section>

            <section class="chapter" id="brew" aria-labelledby="brew-title">
                <div class="chapter-heading">
                    <p class="chapter-kicker">03 · Cara menyeduh</p>
                    <h2 class="chapter-title" id="brew-title">Metode seduh dari berbagai tempat</h2>
                    <p class="chapter-intro">Ukuran giling, suhu air, dan waktu ekstraksi mengubah hasil akhir di cangkir.</p>
                </div>
                <div class="knowledge-grid">
                    <article class="knowledge-card">
                        <span class="card-index">SEDUH 01</span>
                        <h3>V60</h3>
                        <p>Dripper berbentuk kerucut dengan lubang besar dan alur spiral. Air dituangkan bertahap untuk mengatur laju aliran dan kejernihan rasa.</p>
                        <p class="card-origin">Dripper V60 dikembangkan oleh Hario, Jepang.</p>
                    </article>
                    <article class="knowledge-card">
                        <span class="card-index">SEDUH 02</span>
                        <h3>Moka Pot</h3>
                        <p>Air di bagian bawah dipanaskan; tekanan uap mendorongnya melewati kopi menuju ruang atas. Hasilnya pekat, tetapi bukan espresso mesin.</p>
                        <p class="card-origin">Diciptakan Alfonso Bialetti di Italia pada 1933.</p>
                    </article>
                    <article class="knowledge-card">
                        <span class="card-index">SEDUH 03</span>
                        <h3>French Press</h3>
                        <p>Kopi direndam langsung di air, lalu dipisahkan dengan plunger dan saringan logam. Minuman terasa penuh karena minyak kopi ikut terbawa.</p>
                        <p class="card-origin">Teknik imersi yang populer di rumah dan kedai.</p>
                    </article>
                    <article class="knowledge-card">
                        <span class="card-index">SEDUH 04</span>
                        <h3>AeroPress</h3>
                        <p>Kopi dan air direndam singkat di tabung, kemudian ditekan melalui filter. Ringkas, mudah dibawa, dan fleksibel untuk berbagai resep.</p>
                        <p class="card-origin">Diperkenalkan oleh Alan Adler pada 2005.</p>
                    </article>
                </div>
            </section>
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
