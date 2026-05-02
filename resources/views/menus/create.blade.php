<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Kedai Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#423F1F] text-slate-900 antialiased">
  <div class="min-h-screen bg-red-700 p-4">
  <main class="max-w-7xl mx-auto py-4">
    <div class="flex flex-col md:flex-row items-center justify-between mb-6 bg-white p-4 rounded-2xl shadow-sm border border-slate-100 gap-4">
      <div>
        <h2 class="text-2xl font-black text-red-700 uppercase tracking-tighter">Tambah <span class="text-red-900">Menu</span></h2>
        <p class="text-xs font-bold text-red-700 uppercase tracking-widest mt-1">Tambahkan item makanan/minuman baru beserta gambar.</p>
      </div>
      <a href="{{ route('menus.index') }}" class="px-4 py-2 bg-slate-100 text-slate-800 rounded-2xl font-black text-sm hover:bg-slate-200 transition">Kembali</a>
    </div>

    <form method="POST" action="{{ route('menus.store') }}" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
      @csrf

      <div>
        <label class="block text-sm font-bold mb-2">Nama Menu</label>
        <input type="text" name="name" value="{{ old('name') }}" required class="w-full p-3 border-2 border-slate-300 rounded-lg focus:border-red-700 focus:ring-0 outline-none transition-all font-bold text-slate-800" />
      </div>

      <div>
        <label class="block text-sm font-bold mb-2">Deskripsi</label>
        <textarea name="description" class="w-full p-3 border-2 border-slate-300 rounded-lg focus:border-red-700 focus:ring-0 outline-none transition-all font-bold text-slate-800" rows="4">{{ old('description') }}</textarea>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-bold mb-2">Harga</label>
          <input type="number" name="price" value="{{ old('price') }}" required min="0" class="w-full p-3 border-2 border-slate-300 rounded-lg focus:border-red-700 focus:ring-0 outline-none transition-all font-bold text-slate-800" />
        </div>
        <div>
          <label class="block text-sm font-bold mb-2">Kategori</label>
          <input type="text" name="category" value="{{ old('category') }}" class="w-full p-3 border-2 border-slate-300 rounded-lg focus:border-red-700 focus:ring-0 outline-none transition-all font-bold text-slate-800" />
        </div>
        <div>
          <label class="block text-sm font-bold mb-2">Gambar (jpg,png,webp,gif)</label>
          <input type="file" name="image" accept="image/*" class="w-full p-2 border-2 border-slate-300 rounded-lg focus:border-red-700 outline-none transition-all text-sm font-bold text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" />
        </div>
      </div>

      <div class="flex items-center justify-end gap-4">
        <a href="{{ route('menus.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold">Batal</a>
        <button type="submit" class="px-6 py-2 bg-red-700 text-white rounded-xl font-bold hover:bg-red-800 shadow-md">Simpan Menu</button>
      </div>
    </form>
  </main>

  <footer class="max-w-7xl mx-auto py-4 px-6 border-t-2 border-red-800 mt-4">
      <div class="flex justify-between items-center text-white">
          <p class="text-xs font-bold uppercase tracking-widest">&copy; Kedai Smart Pinky</p>
      </div>
  </footer>
  </div>

  @stack('scripts')
</body>
</html>