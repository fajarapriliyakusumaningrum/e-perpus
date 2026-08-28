@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_heading', 'Ringkasan Dashboard')

@section('content')
    <!-- STATS CARDS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Total Buku -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 mb-1">Total Buku</p>
                <h3 class="text-2xl font-extrabold text-slate-900">{{ $totalBuku }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">menu_book</span>
            </div>
        </div>

        <!-- Card 2: Buku Dipinjam -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 mb-1">Buku Dipinjam</p>
                <h3 class="text-2xl font-extrabold text-slate-900">{{ $bukuDipinjam }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">auto_stories</span>
            </div>
        </div>

        <!-- Card 3: Total Anggota -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 mb-1">Total Anggota</p>
                <h3 class="text-2xl font-extrabold text-slate-900">{{ $totalAnggota }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">group</span>
            </div>
        </div>

        <!-- Card 4: Transaksi Aktif -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 mb-1">Transaksi Aktif</p>
                <h3 class="text-2xl font-extrabold text-slate-900">{{ $transaksiAktif }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">swap_horiz</span>
            </div>
        </div>
    </div>

    <!-- WELCOME BANNER -->
    <div class="bg-slate-900 text-white rounded-2xl p-8 relative overflow-hidden shadow-lg">
        <div class="relative z-10 max-w-xl">
            <h3 class="text-2xl font-bold mb-2">Selamat Datang di Panel Administrator! 👋</h3>
            <p class="text-slate-400 text-sm leading-relaxed">
                Melalui halaman ini kamu dapat mengelola seluruh koleksi buku, kategori, data anggota, serta memantau transaksi peminjaman perpustakaan.
            </p>
        </div>
    </div>
@endsection