<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard User - E-Perpus</title>
    
    <!-- Tailwind CSS & Google Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex h-screen overflow-hidden">

    <!-- SIDEBAR (Khusus User) -->
    <aside class="w-64 bg-[#0f172a] text-slate-300 flex flex-col justify-between p-4 flex-shrink-0">
        <div>
            <!-- App Logo / Brand -->
            <div class="flex items-center gap-3 px-3 py-4 mb-6">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                    <span class="material-symbols-outlined text-2xl">local_library</span>
                </div>
                <div>
                    <h1 class="font-bold text-white text-base leading-tight">E-Perpus</h1>
                    <span class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase">USER PANEL</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="space-y-6">
                <!-- Menu Utama -->
                <div>
                    <p class="px-3 text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-2">MENU UTAMA</p>
                    <nav class="space-y-1">
                        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-blue-600 text-white font-medium text-sm transition-all shadow-md shadow-blue-600/30">
                            <span class="material-symbols-outlined text-xl">grid_view</span>
                            Dashboard
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:text-slate-200 hover:bg-slate-800/60 font-medium text-sm transition-all">
                            <span class="material-symbols-outlined text-xl">menu_book</span>
                            Katalog Buku
                        </a>
                    </nav>
                </div>

                <!-- Aktivitas Saya -->
                <div>
                    <p class="px-3 text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-2">AKTIVITAS SAYA</p>
                    <nav class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:text-slate-200 hover:bg-slate-800/60 font-medium text-sm transition-all">
                            <span class="material-symbols-outlined text-xl">swap_horiz</span>
                            Peminjaman Saya
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:text-slate-200 hover:bg-slate-800/60 font-medium text-sm transition-all">
                            <span class="material-symbols-outlined text-xl">history</span>
                            Riwayat Kembali
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Tombol Logout -->
        <div class="pt-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-800/80 hover:bg-red-600/20 text-slate-300 hover:text-red-400 border border-slate-700/50 hover:border-red-500/30 font-medium text-sm transition-all">
                    <span class="material-symbols-outlined text-lg">logout</span>
                    Keluar / Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        
        <!-- TOPBAR -->
        <header class="h-20 bg-white border-b border-slate-200/80 px-8 flex items-center justify-between sticky top-0 z-10">
            <h2 class="text-xl font-bold text-slate-900">Ringkasan Dashboard</h2>
            
            <!-- Profil User (Kanan Topbar) -->
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-900 leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400">{{ Auth::user()->email }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-sm border border-blue-200">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- DASHBOARD BODY -->
        <main class="p-8 space-y-8 max-w-7xl flex-1">
            @yield('content')
        </main>
    </div>

</body>
</html>