<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasi Maps | Kedai Smart Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --coffee: #4b2b19; --cream: #f5edda; --cream-light: #fffaf0; --ink: #241a14; --muted: #7d695d; --green: #2d7a4b; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'DM Sans', sans-serif; background: linear-gradient(120deg, #4a2a1a 0%, #2a1a12 100%); color: var(--ink); }
        .page { min-height: 100vh; padding: 26px 18px; display: grid; place-items: center; }
        .card { width: min(860px, 100%); background: rgba(255, 250, 240, 0.96); border: 1px solid rgba(255,255,255,0.7); border-radius: 18px; box-shadow: 0 28px 80px rgba(0,0,0,0.25); overflow: hidden; }
        .header { padding: 22px 26px; background: var(--coffee); color: #fffaf2; }
        .header h1 { margin: 0; font-size: clamp(24px, 3vw, 38px); font-weight: 800; }
        .body { padding: 24px 26px 28px; }
        .info { margin-bottom: 18px; color: var(--muted); font-size: 15px; line-height: 1.7; }
        .map-box { position: relative; overflow: hidden; border-radius: 14px; border: 1px solid #dccaae; background: #f3eadb; }
        .map-box iframe { width: 100%; min-height: 380px; border: 0; display: block; }
        .actions { margin-top: 18px; display: flex; flex-wrap: wrap; gap: 12px; }
        .btn { display: inline-flex; align-items: center; justify-content: center; min-height: 46px; padding: 0 18px; border-radius: 10px; text-decoration: none; font-weight: 800; font-size: 13px; }
        .btn.primary { background: var(--coffee); color: #fffaf2; }
        .btn.secondary { background: #efe3d2; color: var(--coffee); }
    </style>
</head>
<body>
    <div class="page">
        <div class="card">
            <div class="header">
                <h1>Lokasi Maps</h1>
            </div>
            <div class="body">
                <div class="info">
                    Kedai Smart Pinky<br>
                    GXQG+9GW Cikahuripan, Bogor Regency, West Java
                </div>

                <div class="map-box">
                    <iframe
                        src="https://www.google.com/maps?q=GXQG%2B9GW+Cikahuripan,+Bogor+Regency,+West+Java&z=17&output=embed"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi Kedai Smart Pinky">
                    </iframe>
                </div>

                <div class="actions">
                    <a class="btn primary" href="https://www.google.com/maps/search/?api=1&query=Kedai+Smart+Pinky" target="_blank" rel="noopener noreferrer">Buka di Google Maps</a>
                    <a class="btn secondary" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
