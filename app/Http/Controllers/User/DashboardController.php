<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman; // Sesuaikan dengan model kamu
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $bukuDipinjam = collect([]); // Sesuaikan dengan query model kamu
        $totalRiwayat = 0;
        $bukuDikembalikan = 0;
        $denda = 0;

        return view('user.dashboard', compact(
            'bukuDipinjam', 
            'totalRiwayat', 
            'bukuDikembalikan', 
            'denda'
        ));
    }
}