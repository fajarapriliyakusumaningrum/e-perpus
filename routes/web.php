<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BorrowController;
use App\Http\Controllers\Admin\MemberController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Menampilkan landing page
Route::get('/', function () {
    return view('landing');
});

// Redirect bawaan dari sistem Auth (Breeze/Fortify) ke dashboard sesuai Role
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard');
});

// 1. ROUTE KHUSUS ADMIN (Hanya bisa dibuka role: admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Route CRUD Buku Lengkap
    Route::get('/admin/buku', [App\Http\Controllers\Admin\BookController::class, 'index'])->name('admin.buku.index');
    Route::post('/admin/buku', [App\Http\Controllers\Admin\BookController::class, 'store'])->name('admin.buku.store');
    Route::put('/admin/buku/{buku}', [App\Http\Controllers\Admin\BookController::class, 'update'])->name('admin.buku.update');
    Route::delete('/admin/buku/{buku}', [App\Http\Controllers\Admin\BookController::class, 'destroy'])->name('admin.buku.destroy');

    // Route kategori
    Route::resource('admin/kategori', CategoryController::class, ['names' => 'admin.kategori']);

    // Route peminjaman
    Route::resource('admin/peminjaman', App\Http\Controllers\Admin\BorrowController::class, ['names' => 'admin.peminjaman']);
    Route::get('/admin/peminjaman', [BorrowController::class, 'index'])->name('admin.peminjaman.index');
    Route::put('/admin/peminjaman/{peminjaman}/status', [BorrowController::class, 'updateStatus'])->name('admin.peminjaman.status');
    Route::delete('/admin/peminjaman/{peminjaman}', [BorrowController::class, 'destroy'])->name('admin.peminjaman.destroy');

    // Route anggota/member
    Route::get('/admin/member', [MemberController::class, 'index'])->name('admin.member.index');
    Route::post('/admin/member', [MemberController::class, 'store'])->name('admin.member.store');
    Route::put('/admin/member/{member}', [MemberController::class, 'update'])->name('admin.member.update');
    Route::delete('/admin/member/{member}', [MemberController::class, 'destroy'])->name('admin.member.destroy');
});

// 2. ROUTE KHUSUS USER/SISWA (Hanya bisa dibuka role: user)
Route::middleware(['auth', 'role:user'])->group(function () {
    // Memanggil controller agar semua variabel ($bukuDipinjam, dll) terisi dari controller
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

// 3. ROUTE PROFIL (Bisa dibuka semua user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';