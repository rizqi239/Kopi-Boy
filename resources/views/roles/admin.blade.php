<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .nav-glass { background: rgba(255,255,255,0.8); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(244,114,182,0.1); }
  </style>
</head>
<body class="bg-[#fcfcfd] text-slate-900 antialiased">
  <main class="max-w-7xl mx-auto py-10 px-6">
    @if(session('success'))
      <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-600 rounded">{{ session('error') }}</div>
    @endif

    <h1 class="text-2xl font-black">Admin Dashboard</h1>
    <p class="mt-2">Halo, {{ auth()->user()->name ?? 'Admin' }}.</p>
  </main>

  <footer class="max-w-7xl mx-auto py-10 px-6 border-t border-slate-100">
    <div class="flex justify-between items-center text-slate-400"><p class="text-xs font-bold">&copy; 2026 KOPI-BOY</p></div>
  </footer>

  @stack('scripts')
</body>
</html>

