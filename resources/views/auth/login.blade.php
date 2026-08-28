<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Masuk - LuminaLib</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet"/>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo Header -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2 mb-2">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                    <span class="material-symbols-outlined text-2xl">local_library</span>
                </div>
                <span class="font-display font-bold text-2xl text-slate-900 tracking-tight">E-<span class="text-blue-600">Perpus</span></span>
            </a>
            <h2 class="text-xl font-bold text-slate-900">Selamat Datang Kembali</h2>
            <p class="text-xs text-slate-500 mt-1">Masuk untuk melanjutkan aktivitas membaca</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-xl p-8 rounded-3xl shadow-xl border border-slate-200/60">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            placeholder="nama@email.com"
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition-all"/>
                    </div>
                    @if($errors->has('email'))
                        <p class="text-xs text-red-500 mt-1.5 font-medium">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                        <input id="password" type="password" name="password" required autocomplete="current-password" oninput="handlePasswordInput()"
                            placeholder="••••••••"
                            class="w-full pl-11 pr-12 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition-all"/>
                        <button type="button" id="toggle-btn" onclick="togglePassword()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none hidden">
                            <span id="toggle-icon" class="material-symbols-outlined text-xl">visibility</span>
                        </button>
                    </div>
                    @if($errors->has('password'))
                        <p class="text-xs text-red-500 mt-1.5 font-medium">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500">
                    <label for="remember_me" class="ml-2 text-xs text-slate-600 font-medium">Ingat saya di perangkat ini</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-xl transition-all shadow-lg shadow-blue-500/30 text-sm">
                    Masuk
                </button>
            </form>

            <p class="text-center text-xs text-slate-500 mt-6">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline">Daftar gratis</a>
            </p>
        </div>
    </div>

    <!-- Script Toggle Password & Conditional Visibility -->
    <script>
        function handlePasswordInput() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.getElementById('toggle-btn');
            
            // Munculkan tombol jika ada isi, sembunyikan jika kosong
            if (passwordInput.value.length > 0) {
                toggleBtn.classList.remove('hidden');
            } else {
                toggleBtn.classList.add('hidden');
                passwordInput.type = 'password';
                document.getElementById('toggle-icon').textContent = 'visibility';
            }
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>