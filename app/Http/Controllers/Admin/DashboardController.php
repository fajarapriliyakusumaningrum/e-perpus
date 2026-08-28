<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data dummy untuk tampilan awal ringkasan statistik
        $totalBuku = 120;
        $bukuDipinjam = 15;
        $totalAnggota = 45;
        $transaksiAktif = 12;

        return view('admin.dashboard', compact('totalBuku', 'bukuDipinjam', 'totalAnggota', 'transaksiAktif'));
    }
}