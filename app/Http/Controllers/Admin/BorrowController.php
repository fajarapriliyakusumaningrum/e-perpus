<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index(Request $request)
    {
        $search = $request->input('search');

        $peminjaman = Borrow::with(['user', 'book'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('book', function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.peminjaman.index', compact('peminjaman', 'search'));
    }

    // Mengubah status peminjaman (misal: Disetujui/Dipinjam atau Dikembalikan)
    public function updateStatus(Request $request, Borrow $peminjaman)
    {
        $request->validate([
            'status' => 'required|in:Pending,Dipinjam,Dikembalikan,Ditolak',
        ]);

        $peminjaman->update([
            'status' => $request->status,
        ]);

        // Jika status diubah menjadi "Dikembalikan", stok buku bisa otomatis bertambah kembali jika diperlukan
        if ($request->status === 'Dikembalikan') {
            $peminjaman->book->increment('stok');
        } elseif ($request->status === 'Dipinjam') {
            $peminjaman->book->decrement('stok');
        }

        return redirect()->route('admin.peminjaman.index')->with('success', 'Status peminjaman berhasil diperbarui!');
    }

    // Menghapus data peminjaman
    public function destroy(Borrow $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus!');
    }
}