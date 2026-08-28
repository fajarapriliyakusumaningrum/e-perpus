<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Lumina Library - Digital Library Experience</title>
    
    <!-- Scripts & Fonts -->
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
                    },
                    colors: {
                        brand: {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .hero-gradient {
            background: radial-gradient(circle at 50% 0%, rgba(59, 130, 246, 0.12) 0%, rgba(255, 255, 255, 0) 70%);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased selection:bg-blue-500 selection:text-white">

    <!-- Top Navigation Bar -->
    <nav class="w-full sticky top-0 z-50 glass-nav border-b border-slate-200/60 transition-all">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                    <span class="material-symbols-outlined text-2xl">local_library</span>
                </div>
                <span class="font-display font-bold text-xl text-slate-900 tracking-tight">E-<span class="text-blue-600">Perpus</span></span>
            </div>
            
            <div class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-600">
                <a class="text-blue-600 transition-colors" href="#">Jelajah</a>
                <a class="hover:text-blue-600 transition-colors" href="#kategori">Kategori</a>
                <a class="hover:text-blue-600 transition-colors" href="#populer">Populer</a>
                <a class="hover:text-blue-600 transition-colors" href="#cara-kerja">Cara Kerja</a>
            </div>

            <!-- Kondisional Auth/Guest + Form Logout -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Tampilan jika pengguna SUDAH Login -->
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors px-4 py-2">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors px-4 py-2">
                            Dashboard Saya
                        </a>
                    @endif

                    <!-- Form Logout Laravel Breeze -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 transition-all px-5 py-2 rounded-full border border-red-200">
                            Keluar
                        </button>
                    </form>
                @else
                    <!-- Tampilan jika pengguna BELUM Login -->
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors px-4 py-2">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition-all px-6 py-2.5 rounded-full shadow-md shadow-blue-500/20 hover:shadow-blue-500/40">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        <!-- Hero Section -->
        <section class="relative pt-20 pb-28 px-6 hero-gradient overflow-hidden">
            <div class="max-w-5xl mx-auto text-center relative z-10">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold tracking-wide uppercase mb-6 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span> Perpustakaan Digital Masa Kini
                </span>
                
                <h1 class="font-display text-4xl sm:text-6xl font-extrabold text-slate-900 mb-6 leading-tight tracking-tight">
                    Temukan & Pinjam Buku Favoritmu <br class="hidden sm:inline"/> Tanpa Ribet
                </h1>
                
                <p class="text-lg text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Nikmati kemudahan mengakses ribuan pustaka ilmu pengetahuan, fiksi populer, dan literatur akademik langsung dalam genggaman.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-lg shadow-blue-500/30 text-sm flex items-center justify-center gap-2">
                                Masuk Panel Admin
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-lg shadow-blue-500/30 text-sm flex items-center justify-center gap-2">
                                Buka Dashboard
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-lg shadow-blue-500/30 text-sm flex items-center justify-center gap-2">
                            Mulai Pinjam Sekarang
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    @endauth
                    
                    <a href="#populer" class="w-full sm:w-auto bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 font-bold py-3.5 px-8 rounded-xl transition-all text-sm flex items-center justify-center">
                        Lihat Katalog Buku
                    </a>
                </div>

                <!-- Stats Counter -->
                <div class="pt-8 border-t border-slate-200/60 max-w-3xl mx-auto grid grid-cols-3 gap-4 text-center">
                    <div>
                        <h4 class="font-display font-extrabold text-2xl text-slate-900">1,200+</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Koleksi Buku</p>
                    </div>
                    <div class="border-x border-slate-200/60">
                        <h4 class="font-display font-extrabold text-2xl text-slate-900">850+</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Anggota Aktif</p>
                    </div>
                    <div>
                        <h4 class="font-display font-extrabold text-2xl text-slate-900">24/7</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Akses Digital</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section id="kategori" class="py-16 px-6 max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="font-display text-3xl font-bold text-slate-900 mb-3">Kategori Pilihan</h2>
                <p class="text-slate-500 text-sm">Temukan buku berdasarkan minat dan bidang favoritmu</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="group bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl">auto_stories</span>
                    </div>
                    <h3 class="font-bold text-slate-800 group-hover:text-blue-600 transition-colors">Fiksi & Sastra</h3>
                </div>

                <div class="group bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl">terminal</span>
                    </div>
                    <h3 class="font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">Teknologi & IT</h3>
                </div>

                <div class="group bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-14 h-14 bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl">history_edu</span>
                    </div>
                    <h3 class="font-bold text-slate-800 group-hover:text-amber-600 transition-colors">Sejarah & Budaya</h3>
                </div>

                <div class="group bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl">biotech</span>
                    </div>
                    <h3 class="font-bold text-slate-800 group-hover:text-purple-600 transition-colors">Sains & Riset</h3>
                </div>
            </div>
        </section>

        <!-- Featured Books Section -->
        <section id="populer" class="py-16 px-6 bg-slate-100/70 border-y border-slate-200/60">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-end mb-12">
                    <div>
                        <h2 class="font-display text-3xl font-bold text-slate-900 mb-2">Buku Populer Minggu Ini</h2>
                        <p class="text-slate-500 text-sm">Koleksi buku terbanyak dipinjam oleh pembaca</p>
                    </div>
                    <a href="#" class="hidden sm:flex items-center text-blue-600 font-semibold hover:text-blue-700 text-sm gap-1">
                        Lihat Semua <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Book Card 1 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-200/70 flex flex-col group">
                        <div class="h-64 relative overflow-hidden bg-slate-100">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&q=80&w=600" alt="Book cover"/>
                            <span class="absolute top-4 left-4 bg-emerald-500/90 backdrop-blur-md text-white font-bold text-xs px-3 py-1 rounded-full shadow-sm">Tersedia</span>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-bold text-slate-900 text-base mb-1 group-hover:text-blue-600 transition-colors line-clamp-1">Seni Berpikir Modern</h3>
                            <p class="text-xs text-slate-500 mb-6">Penulis: Ahmad Ridwan</p>
                            <div class="mt-auto">
                                <button class="w-full bg-slate-900 hover:bg-blue-600 text-white font-semibold py-2.5 rounded-xl text-xs transition-colors shadow-sm">
                                    Pinjam Buku
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Book Card 2 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-200/70 flex flex-col group">
                        <div class="h-64 relative overflow-hidden bg-slate-100">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=600" alt="Book cover"/>
                            <span class="absolute top-4 left-4 bg-blue-500/90 backdrop-blur-md text-white font-bold text-xs px-3 py-1 rounded-full shadow-sm">Populer</span>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-bold text-slate-900 text-base mb-1 group-hover:text-blue-600 transition-colors line-clamp-1">Algoritma & Masa Depan</h3>
                            <p class="text-xs text-slate-500 mb-6">Penulis: Dian Sastro</p>
                            <div class="mt-auto">
                                <button class="w-full bg-slate-900 hover:bg-blue-600 text-white font-semibold py-2.5 rounded-xl text-xs transition-colors shadow-sm">
                                    Pinjam Buku
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Book Card 3 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-200/70 flex flex-col group">
                        <div class="h-64 relative overflow-hidden bg-slate-100">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&q=80&w=600" alt="Book cover"/>
                            <span class="absolute top-4 left-4 bg-emerald-500/90 backdrop-blur-md text-white font-bold text-xs px-3 py-1 rounded-full shadow-sm">Tersedia</span>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-bold text-slate-900 text-base mb-1 group-hover:text-blue-600 transition-colors line-clamp-1">Jejak Peradaban Dunia</h3>
                            <p class="text-xs text-slate-500 mb-6">Penulis: Budi Pratama</p>
                            <div class="mt-auto">
                                <button class="w-full bg-slate-900 hover:bg-blue-600 text-white font-semibold py-2.5 rounded-xl text-xs transition-colors shadow-sm">
                                    Pinjam Buku
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Book Card 4 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-200/70 flex flex-col group">
                        <div class="h-64 relative overflow-hidden bg-slate-100">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&q=80&w=600" alt="Book cover"/>
                            <span class="absolute top-4 left-4 bg-amber-500/90 backdrop-blur-md text-white font-bold text-xs px-3 py-1 rounded-full shadow-sm">Baru</span>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-bold text-slate-900 text-base mb-1 group-hover:text-blue-600 transition-colors line-clamp-1">Desain Antarmuka Pengguna</h3>
                            <p class="text-xs text-slate-500 mb-6">Penulis: Siti Rahma</p>
                            <div class="mt-auto">
                                <button class="w-full bg-slate-900 hover:bg-blue-600 text-white font-semibold py-2.5 rounded-xl text-xs transition-colors shadow-sm">
                                    Pinjam Buku
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How it Works Section -->
        <section id="cara-kerja" class="py-20 px-6 max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="font-display text-3xl font-bold text-slate-900 mb-3">3 Langkah Mudah</h2>
                <p class="text-slate-500 text-sm">Proses peminjaman cepat tanpa antre</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center relative">
                <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm relative">
                    <div class="w-16 h-16 bg-blue-600 text-white font-bold rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-500/30">
                        <span class="material-symbols-outlined text-3xl">person_add</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-2">1. Buat Akun</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Daftarkan diri kamu secara gratis untuk mendapatkan hak akses ke sistem peminjaman.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm relative">
                    <div class="w-16 h-16 bg-blue-600 text-white font-bold rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-500/30">
                        <span class="material-symbols-outlined text-3xl">menu_book</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-2">2. Pilih Buku</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Cari judul buku yang kamu inginkan lalu ajukan peminjaman dalam hitungan detik.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm relative">
                    <div class="w-16 h-16 bg-blue-600 text-white font-bold rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-500/30">
                        <span class="material-symbols-outlined text-3xl">local_shipping</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-2">3. Ambil / Baca</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Konfirmasi status peminjaman dan nikmati membaca buku pilihanmu.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer yang Diperkaya (Modern & Rich) -->
    <footer class="bg-slate-900 text-slate-400 pt-16 pb-12 px-6 border-t border-slate-800">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
            <!-- Kolom 1: Brand Info -->
            <div class="space-y-4 md:col-span-1">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-lg">local_library</span>
                    </div>
                    <span class="font-display font-bold text-lg text-white">E-Perpus</span>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Platform perpustakaan digital modern untuk memudahkan akses literatur, riset, dan bacaan berkualitas kapan saja dan di mana saja.
                </p>
            </div>

            <!-- Kolom 2: Navigasi Cepat -->
            <div>
                <h4 class="text-white text-sm font-bold uppercase tracking-wider mb-4">Navigasi</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#" class="hover:text-white transition-colors">Jelajah Koleksi</a></li>
                    <li><a href="#kategori" class="hover:text-white transition-colors">Kategori Buku</a></li>
                    <li><a href="#populer" class="hover:text-white transition-colors">Buku Terpopuler</a></li>
                    <li><a href="#cara-kerja" class="hover:text-white transition-colors">Cara Kerja Sistem</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Kategori Utama -->
            <div>
                <h4 class="text-white text-sm font-bold uppercase tracking-wider mb-4">Kategori</h4>
                <ul class="space-y-2 text-xs">
                    <li><span class="hover:text-white transition-colors cursor-pointer">Fiksi & Sastra</span></li>
                    <li><span class="hover:text-white transition-colors cursor-pointer">Teknologi & IT</span></li>
                    <li><span class="hover:text-white transition-colors cursor-pointer">Sejarah & Budaya</span></li>
                    <li><span class="hover:text-white transition-colors cursor-pointer">Sains & Riset</span></li>
                </ul>
            </div>

            <!-- Kolom 4: Hubungi Kami -->
            <div>
                <h4 class="text-white text-sm font-bold uppercase tracking-wider mb-4">Dukungan</h4>
                <p class="text-xs text-slate-400 mb-3 leading-relaxed">Punya pertanyaan seputar peminjaman buku? Hubungi administrator perpustakaan kami.</p>
                <div class="flex items-center gap-2 text-xs text-slate-300">
                    <span class="material-symbols-outlined text-sm text-blue-500">mail</span>
                    <span>support@eperpus.digital</span>
                </div>
            </div>
        </div>

        <!-- Garis Bawah & Hak Cipta -->
        <div class="max-w-7xl mx-auto pt-8 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
            <p>© 2026 E-Perpus Digital Library. All rights reserved.</p>
            <div class="flex space-x-6">
                <span class="hover:text-slate-400 cursor-pointer">Kebijakan Privasi</span>
                <span class="hover:text-slate-400 cursor-pointer">Syarat & Ketentuan</span>
            </div>
        </div>
    </footer>

</body>
</html>