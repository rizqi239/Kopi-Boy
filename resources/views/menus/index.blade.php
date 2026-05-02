<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Kedai Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#423F1F] text-slate-900 antialiased">
  <div class="min-h-screen bg-red-700 p-4">
    <main class="max-w-7xl mx-auto py-4">
      <div class="flex flex-col md:flex-row items-center justify-between mb-6 bg-white p-4 rounded-2xl shadow-sm border border-slate-100 gap-4">
        <div>
            <h2 class="text-2xl font-black text-red-700 uppercase tracking-tighter">Daftar <span class="text-red-900">Menu</span></h2>
            <p class="text-xs font-bold text-red-700 uppercase tracking-widest">Kelola item makanan dan minuman di Kedai Pinky.</p>
        </div>

        <div class="flex items-center gap-3">
          <nav class="flex items-center gap-2">
              <a href="{{ route('menus.index') }}" class="px-3 py-1 rounded-full text-sm font-black hover:bg-red-800 hover:text-white transition {{ empty($category) ? 'bg-red-700 text-white' : 'bg-white text-red-700 border border-red-200' }}">Semua</a>
              <a href="{{ route('menus.index', ['category' => 'Makanan']) }}" class="px-3 py-1 rounded-full text-sm font-black hover:bg-red-800 hover:text-white transition {{ (isset($category) && $category === 'Makanan') ? 'bg-red-700 text-white' : 'bg-white text-red-700 border border-red-200' }}">Makanan</a>
              <a href="{{ route('menus.index', ['category' => 'Minuman']) }}" class="px-3 py-1 rounded-full text-sm font-black hover:bg-red-800 hover:text-white transition {{ (isset($category) && $category === 'Minuman') ? 'bg-red-700 text-white' : 'bg-white text-red-700 border border-red-200' }}">Minuman</a>
          </nav>

          <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-100 text-slate-800 rounded-2xl font-bold hover:bg-slate-200 transition text-sm">Dashboard</a>
          <a href="{{ route('menus.create') }}" class="px-6 py-3 bg-red-700 text-white rounded-2xl font-bold shadow-lg shadow-red-100 hover:bg-red-800 transition-all active:scale-95 text-sm uppercase tracking-widest">
              Tambah Menu
          </a>
        </div>
      </div>

    @if(session('success'))
      <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
          <span class="font-bold text-sm">{{ session('success') }}</span>
      </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse($menus as $menu)
        <div class="bg-white p-5 rounded-[2.5rem] border border-slate-100 shadow-sm hover:border-red-200 transition-all duration-300 group">
          <div class="relative h-48 w-full mb-5 overflow-hidden rounded-[1.8rem] bg-slate-50">
              @if($menu->image)
                  <img src="{{ asset('storage/' . $menu->image) }}" 
                       alt="{{ $menu->name }}" 
                       class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
              @else
                  <div class="flex flex-col items-center justify-center h-full text-slate-300">
                      <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                      <span class="text-[10px] font-black uppercase tracking-widest">No Image</span>
                  </div>
              @endif
              
              <div class="absolute top-3 left-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full shadow-sm">
                  <span class="text-[10px] font-black text-red-700 uppercase tracking-widest">{{ $menu->category ?? 'Umum' }}</span>
              </div>
          </div>

          <div class="px-1">
              <h3 class="font-black text-lg text-slate-800 leading-tight">{{ $menu->name }}</h3>
              <p class="text-xs text-slate-500 mt-2 leading-relaxed h-8 overflow-hidden">{{ \Illuminate\Support\Str::limit($menu->description, 70) }}</p>
              
              <div class="mt-5 flex items-center justify-between">
                  <div>
                      <p class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1">Harga</p>
                      <div class="font-black text-xl text-slate-900 tracking-tighter">Rp{{ number_format($menu->price,0,',','.') }}</div>
                  </div>
                  
                  <div class="flex gap-2">
                      <a href="{{ route('menus.edit', $menu) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-colors" title="Edit">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                      </a>
                      <form method="POST" action="{{ route('menus.destroy', $menu) }}" onsubmit="return confirm('Hapus menu {{ $menu->name }}?');">
                          @csrf
                          @method('DELETE')
                          <button class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors" title="Hapus">
                              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                          </button>
                      </form>
                  </div>
              </div>
          </div>
        </div>
      @empty
        <div class="col-span-full py-20 text-center bg-white rounded-[2.5rem] border border-dashed border-slate-200">
          <svg class="w-16 h-16 mx-auto text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
          <p class="text-slate-400 font-bold uppercase text-xs tracking-widest">Belum ada menu yang didaftarkan</p>
        </div>
      @endforelse
    </div>

    <div class="mt-10 px-4">
      {{ $menus->links() }}
    </div>
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
