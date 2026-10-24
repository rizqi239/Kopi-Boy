<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#14110e">
    <title>Masuk | KOPI-BOY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            color-scheme: light;
            --ink: #17130f;
            --coffee: #a45e2a;
            --cream: #f6f1e9;
            --muted: #756d64;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: var(--ink);
            background: var(--cream);
            font-family: 'DM Sans', sans-serif;
        }

        a { color: inherit; }

        .topbar {
            min-height: 72px;
            padding: 0 5.5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            color: #fff;
            background: #14110e;
            border-bottom: 1px solid rgb(255 255 255 / 10%);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            text-decoration: none;
        }

        .brand-mark {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            color: #f3c28d;
            border: 1px solid #936641;
            border-radius: 50%;
            font-size: 14px;
            font-weight: 700;
        }

        .brand-name { display: grid; gap: 1px; }
        .brand-name small { color: #d0a276; font-size: 9px; font-weight: 700; letter-spacing: 1.6px; }
        .brand-name strong { font-family: 'Caveat', cursive; font-size: 25px; font-weight: 700; line-height: 1; }

        .navigation { display: flex; align-items: center; gap: 30px; font-size: 13px; }
        .navigation a { color: #eee8e0; text-decoration: none; }
        .navigation a:hover { color: #e6b47d; }
        .navigation .active { color: #f0c18e; }
        .navigation .register-link { padding: 10px 18px; color: #20170f; background: #ddb487; border-radius: 999px; font-weight: 700; }

        .hero {
            position: relative;
            isolation: isolate;
            min-height: 610px;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 64px 5.5%;
            background: #21180f url('{{ asset('image/coffee-login.jpg') }}') center 54% / cover no-repeat;
        }

        .hero::before {
            position: absolute;
            z-index: -1;
            inset: 0;
            content: '';
            background: linear-gradient(90deg, rgb(16 13 10 / 83%) 0%, rgb(16 13 10 / 65%) 45%, rgb(16 13 10 / 30%) 100%);
        }

        .hero-content {
            width: min(1120px, 100%);
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(0, 1fr) 390px;
            align-items: center;
            gap: 70px;
        }

        .intro { max-width: 580px; color: #fff; animation: arrive 600ms ease both; }
        .eyebrow { margin: 0 0 15px; color: #e5b47e; font-size: 11px; font-weight: 700; letter-spacing: 2px; }
        .intro h1 { max-width: 570px; margin: 0; font-size: 54px; line-height: 1.04; font-weight: 700; }
        .intro h1 span { color: #d29a67; font-family: 'Caveat', cursive; font-size: 66px; }
        .intro-copy { max-width: 410px; margin: 22px 0 0; color: #e6dfd7; font-size: 16px; line-height: 1.7; }

        .login-panel {
            padding: 32px;
            background: #fffdf9;
            border: 1px solid rgb(255 255 255 / 75%);
            border-radius: 7px;
            box-shadow: 0 22px 65px rgb(0 0 0 / 24%);
            animation: arrive 600ms 100ms ease both;
        }

        .panel-kicker { margin: 0 0 7px; color: var(--coffee); font-size: 10px; font-weight: 700; letter-spacing: 1.7px; text-transform: uppercase; }
        .login-panel h2 { margin: 0; font-size: 27px; line-height: 1.2; }
        .panel-copy { margin: 8px 0 23px; color: var(--muted); font-size: 13px; }
        .form-fields { display: grid; gap: 16px; }
        .field label { display: block; margin-bottom: 7px; font-size: 12px; font-weight: 700; }
        .field input, .field select {
            width: 100%;
            min-height: 46px;
            padding: 0 13px;
            color: var(--ink);
            background: #fff;
            border: 1px solid #d9d1c7;
            border-radius: 4px;
            font: inherit;
            font-size: 13px;
        }

        .field input::placeholder { color: #9a9187; }
        .field input:focus, .field select:focus { outline: 2px solid #bd8656; outline-offset: 1px; border-color: #bd8656; }
        .submit-button {
            width: 100%;
            min-height: 47px;
            margin-top: 4px;
            color: #fff;
            background: #a45e2a;
            border: 0;
            border-radius: 4px;
            cursor: pointer;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            transition: background 160ms ease, transform 160ms ease;
        }

        .submit-button:hover { background: #87491f; transform: translateY(-1px); }
        .auth-divider { display: flex; align-items: center; gap: 12px; margin: 19px 0; color: var(--muted); font-size: 11px; }
        .auth-divider::before, .auth-divider::after { height: 1px; flex: 1; content: ''; background: #e5ded5; }
        .google-button { min-height: 46px; display: flex; align-items: center; justify-content: center; gap: 11px; color: #29241f; background: #fff; border: 1px solid #d9d1c7; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: 600; transition: background 160ms ease, border-color 160ms ease; }
        .google-button:hover { background: #f8f5f0; border-color: #b9afa3; }
        .google-mark { width: 21px; height: 21px; display: grid; place-items: center; color: #4285f4; border: 1px solid #d9d1c7; border-radius: 50%; font-size: 14px; font-weight: 700; }
        .register-note { margin: 18px 0 0; color: var(--muted); text-align: center; font-size: 12px; }
        .register-note a { color: #8c4e25; font-weight: 700; text-underline-offset: 3px; }
        .error-message { margin: 0 0 18px; padding: 11px 13px; color: #8b2e24; background: #fff0ed; border-left: 3px solid #bd5949; font-size: 12px; }
        .error-message ul { margin: 0; padding-left: 17px; }

        .highlights {
            min-height: 116px;
            padding: 22px 5.5%;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            align-items: center;
            background: #17130f;
            color: #fff;
        }

        .highlight { min-height: 54px; padding: 0 28px; display: flex; align-items: center; gap: 14px; }
        .highlight + .highlight { border-left: 1px solid rgb(221 180 135 / 26%); }
        .highlight-mark { width: 38px; height: 38px; flex: 0 0 auto; display: grid; place-items: center; color: #efc18f; border: 1px solid #765337; border-radius: 50%; font-size: 17px; }
        .highlight strong { display: block; font-size: 12px; }
        .highlight span:last-child { display: block; margin-top: 4px; color: #c9c0b7; font-size: 11px; line-height: 1.45; }

        @keyframes arrive { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 900px) {
            .hero { min-height: 0; padding-top: 52px; padding-bottom: 52px; }
            .hero-content { grid-template-columns: minmax(0, 1fr) 350px; gap: 36px; }
            .intro h1 { font-size: 44px; }
            .intro h1 span { font-size: 56px; }
            .login-panel { padding: 26px; }
            .highlight { padding: 0 15px; }
        }

        @media (max-width: 700px) {
            .topbar { min-height: 66px; padding: 0 20px; }
            .navigation { gap: 14px; }
            .navigation a:first-child { display: none; }
            .navigation .register-link { padding: 9px 13px; }
            .hero { padding: 44px 20px; background-position: 58% center; }
            .hero::before { background: linear-gradient(90deg, rgb(16 13 10 / 82%), rgb(16 13 10 / 62%)); }
            .hero-content { max-width: 470px; grid-template-columns: 1fr; gap: 30px; }
            .intro h1 { font-size: 40px; }
            .intro h1 span { font-size: 52px; }
            .intro-copy { margin-top: 14px; font-size: 14px; }
            .login-panel { padding: 25px 22px; }
            .highlights { grid-template-columns: 1fr; padding: 10px 20px; }
            .highlight { min-height: 68px; padding: 10px 0; }
            .highlight + .highlight { border-top: 1px solid rgb(221 180 135 / 20%); border-left: 0; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; scroll-behavior: auto !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <a class="brand" href="{{ url('/') }}" aria-label="KOPI-BOY">
            <span class="brand-mark" aria-hidden="true">KB</span>
            <span class="brand-name"><small>KEDAI</small><strong>KOPI-BOY</strong></span>
        </a>
        <nav class="navigation" aria-label="Navigasi utama">
            <a href="{{ url('/') }}">Beranda</a>
            <a class="active" href="{{ route('login') }}" aria-current="page">Masuk</a>
            <a class="register-link" href="{{ route('register') }}">Daftar</a>
        </nav>
    </header>

    <main>
        <section class="hero" aria-labelledby="welcome-title">
            <div class="hero-content">
                <div class="intro">
                    <p class="eyebrow">KOPI PILIHAN · SUASANA HANGAT · CERITA BARU</p>
                    <h1 id="welcome-title">Selamat datang di <span>KOPI-BOY</span></h1>
                    <p class="intro-copy">Tempat terbaik untuk menikmati kopi pilihan, menu favorit, dan suasana yang selalu terasa akrab.</p>
                </div>

                <section class="login-panel" aria-labelledby="login-title">
                    <p class="panel-kicker">Akun KOPI-BOY</p>
                    <h2 id="login-title">Masuk ke akun</h2>
                    <p class="panel-copy">Silakan masuk untuk melanjutkan.</p>

                    @if($errors->any())
                        <div class="error-message" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.attempt') }}" class="form-fields">
                        @csrf
                        <div class="field">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="username" required autofocus>
                        </div>
                        <div class="field">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
                        </div>
                        <p class="panel-copy" style="margin: 0 0 12px; color: #5a4a3d;">Akun yang dapat login adalah pelanggan. Admin dibuat secara manual oleh pengelola.</p>
                        <button class="submit-button" type="submit">Masuk sekarang</button>
                    </form>

                    <div class="auth-divider">atau</div>
                    <a class="google-button" href="{{ route('auth.google.redirect') }}">
                        <span class="google-mark" aria-hidden="true">G</span>
                        <span>Masuk dengan Google</span>
                    </a>

                    <p class="register-note">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                </section>
            </div>
        </section>

        <section class="highlights" aria-label="Keunggulan KOPI-BOY">
            <div class="highlight">
                <span class="highlight-mark" aria-hidden="true">01</span>
                <div><strong>Kopi pilihan</strong><span>Diracik dari bahan berkualitas.</span></div>
            </div>
            <div class="highlight">
                <span class="highlight-mark" aria-hidden="true">02</span>
                <div><strong>Menu beragam</strong><span>Temukan favorit untuk setiap suasana.</span></div>
            </div>
            <div class="highlight">
                <span class="highlight-mark" aria-hidden="true">03</span>
                <div><strong>Selalu hangat</strong><span>Tempat nyaman untuk menikmati waktu.</span></div>
            </div>
        </section>
    </main>
</body>
</html>