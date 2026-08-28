<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - E-Perpus</title>
    
    <!-- Tailwind CSS CDN (untuk pengembangan) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts & Material Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col fixed inset-y-0 left-0 z-30 transition-all">
        <!-- Brand / Logo -->
        <div class="h-16 px-6 flex items-center gap-3 border-b border-slate-800">
            <div class="bg-blue-600 text-white p-2 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-xl">local_library</span>
            </div>
            <div>
                <h1 class="font-bold text-white text-base tracking-wide leading-none">E-Perpus</h1>
                <span class="text-[10px] text-slate-400 font-medium tracking-wider uppercase">Admin Panel</span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider px-3 mb-2">Menu Utama</div>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                <span class="material-symbols-outlined text-xl">dashboard</span>
                Dashboard
            </a>

            <a href="{{ route('admin.buku.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-colors {{ request()->routeIs('admin.buku*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <span class="material-symbols-outlined text-xl">menu_book</span>
                Data Buku
            </a>

            <a href="{{ route('admin.kategori.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-colors {{ request()->routeIs('admin.kategori*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <span class="material-symbols-outlined text-xl">category</span>
                Kategori Buku
            </a>

            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider px-3 mt-6 mb-2">Transaksi & User</div>

            <a href="{{ route('admin.peminjaman.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-colors {{ request()->routeIs('admin.peminjaman*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <span class="material-symbols-outlined text-xl">swap_horiz</span>
                Peminjaman
            </a>

            <a href="{{ route('admin.member.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-colors {{ request()->routeIs('admin.member*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <span class="material-symbols-outlined text-xl">group</span>
                Data Anggota
            </a>
        </nav>

        <!-- User Profile Bottom / Logout -->
        <div class="p-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-red-600 text-slate-300 hover:text-white rounded-xl text-xs font-semibold transition-colors">
                    <span class="material-symbols-outlined text-base">logout</span>
                    Keluar / Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT CONTAINER -->
    <div class="flex-1 pl-64 flex flex-col min-h-screen">
        
        <!-- HEADER / NAVBAR TOP -->
        <header class="h-16 bg-white border-b border-slate-200/80 px-8 flex items-center justify-between sticky top-0 z-20">
            <h2 class="font-bold text-slate-800 text-lg">@yield('page_heading', 'Dashboard')</h2>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                    <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-xs font-bold text-slate-800">{{ Auth::user()->name ?? 'Administrator' }}</div>
                        <div class="text-[10px] text-slate-400">{{ Auth::user()->email ?? 'admin@perpus.com' }}</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN PAGE CONTENT -->
        <main class="p-8 flex-1">
            @yield('content')
        </main>
    </div>

</body>
</html>