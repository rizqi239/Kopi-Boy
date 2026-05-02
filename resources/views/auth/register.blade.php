<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Kedai Pinky</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
    <meta name="robots" content="noindex,nofollow">
</head>
<body class="antialiased">

  <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat p-4" style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&auto=format&fit=crop&w=1400&q=80');">
    <div class="absolute inset-0 bg-black/40"></div>

    <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-3xl shadow-2xl">
      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-white">Buat Akun</h1>
        <p class="text-gray-200 text-sm mt-1">Silakan isi data untuk mendaftar</p>
      </div>

      @if($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-500/20 border border-red-500/50 text-red-100 text-sm">
          <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('register.perform') }}" class="space-y-4">
        @csrf

        <div>
          <label class="block text-sm font-medium text-white mb-1">Nama</label>
          <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl bg-white/20 border border-white/30 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        </div>

        <div>
          <label class="block text-sm font-medium text-white mb-1">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl bg-white/20 border border-white/30 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        </div>

        <div>
          <label class="block text-sm font-medium text-white mb-1">Password</label>
          <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl bg-white/20 border border-white/30 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        </div>

        <div>
          <label class="block text-sm font-medium text-white mb-1">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl bg-white/20 border border-white/30 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        </div>

        <div>
          <label class="block text-sm font-medium text-white mb-1">Role</label>
          <select name="role" required class="w-full px-4 py-3 rounded-xl bg-white/20 border border-white/30 text-white focus:outline-none focus:ring-2 focus:ring-indigo-400 appearance-none">
            <option value="admin" class="text-gray-900">Admin</option>
            <option value="kasir" class="text-gray-900">Kasir</option>
            <option value="karyawan" class="text-gray-900">Karyawan</option>
            <option value="owner" class="text-gray-900">Owner</option>
          </select>
        </div>

        <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl shadow-lg transition duration-200">Daftar Sekarang</button>
      </form>

      <div class="mt-6 text-center">
        <p class="text-gray-300 text-sm">Sudah punya akun? <a href="{{ route('login') }}" class="text-white font-semibold hover:underline">Masuk</a></p>
      </div>
    </div>
  </div>

</body>
</html>
