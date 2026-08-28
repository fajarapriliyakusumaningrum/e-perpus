@extends('layouts.user')

@section('content')

    <!-- STATISTIC CARDS (Khusus data User) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Card 1: Sedang Dipinjam -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/70 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 mb-1">Buku Dipinjam</p>
                <h3 class="text-3xl font-extrabold text-slate-900">
                    {{ is_countable($bukuDipinjam) ? count($bukuDipinjam) : 0 }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">menu_book</span>
            </div>
        </div>

        <!-- Card 2: Total Riwayat -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/70 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 mb-1">Total Riwayat</p>
                <h3 class="text-3xl font-extrabold text-slate-900">{{ $totalRiwayat ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">history</span>
            </div>
        </div>

        <!-- Card 3: Dikembalikan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/70 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 mb-1">Buku Selesai</p>
                <h3 class="text-3xl font-extrabold text-slate-900">{{ $bukuDikembalikan ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">assignment_turned_in</span>
            </div>
        </div>

        <!-- Card 4: Denda / Status -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/70 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 mb-1">Total Denda</p>
                <h3 class="text-3xl font-extrabold text-slate-900">
                    Rp {{ number_format($denda ?? 0, 0, ',', '.') }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">payments</span>
            </div>
        </div>

    </div>

    <!-- WELCOME BANNER -->
    <div class="bg-[#0f172a] rounded-2xl p-8 text-white relative overflow-hidden shadow-xl">
        <div class="relative z-10 max-w-2xl space-y-3">
            <h3 class="text-2xl font-bold flex items-center gap-2">
                Selamat Datang, {{ Auth::user()->name }}! 👋
            </h3>
            <p class="text-slate-400 text-sm leading-relaxed">
                Nikmati akses peminjaman buku perpustakaan secara digital. Kamu bisa menjelajahi katalog buku populer, mengajukan pinjaman, dan melihat riwayat peminjaman kamu di sini.
            </p>
        </div>
    </div>

@endsection