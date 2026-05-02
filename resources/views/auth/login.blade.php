<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Premium Look</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="antialiased">

    <!-- Wrapper Utama dengan Background dari Pinterest -->
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat relative p-4" 
         style="background-image: url('{{ asset('image/kedai-pinky.jpg') }}');">
        
        <!-- Overlay Gelap biar gambar gak terlalu nabrak sama form -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- Card Login Glassmorphism -->
        <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-3xl shadow-2xl">
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white tracking-tight">Selamat Datang Di Kedai Smart Pinky</h1>
                <p class="text-gray-200 text-sm mt-2">Silakan masuk ke akun mu</p>
            </div>

            <!-- Error Handling -->
            @if($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-500/20 border border-red-500/50 text-red-100 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                @csrf
                
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-white mb-1 ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           class="w-full px-4 py-3 rounded-xl bg-white/20 border border-white/30 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:bg-white/30 transition duration-200" 
                           placeholder="nama@email.com" required />
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-white mb-1 ml-1">Password</label>
                    <input type="password" name="password" 
                           class="w-full px-4 py-3 rounded-xl bg-white/20 border border-white/30 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:bg-white/30 transition duration-200" 
                           placeholder="••••••••" required />
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-white mb-1 ml-1">Login Sebagai</label>
                    <select name="role" 
                            class="w-full px-4 py-3 rounded-xl bg-white/20 border border-white/30 text-white focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:bg-white/30 transition duration-200 appearance-none cursor-pointer" required>
                        <option value="admin" class="text-gray-900">Admin</option>
                        <option value="kasir" class="text-gray-900">Kasir</option>
                        <option value="karyawan" class="text-gray-900">Karyawan</option>
                        <option value="owner" class="text-gray-900">Owner</option>
                    </select>
                </div>

                <!-- Button -->
                <button type="submit" 
                        class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl shadow-lg transition duration-300 transform hover:scale-[1.02] active:scale-[0.98]">
                    Login Sekarang
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-gray-300 text-sm">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-white font-semibold hover:underline decoration-indigo-400">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>