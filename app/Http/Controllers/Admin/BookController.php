<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category; // <-- Jangan lupa import model Category
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Menampilkan data + fitur search
    public function index(Request $request)
    {
        $search = $request->input('search');

        $buku = Book::with('category') // Eager load relasi category agar cepat
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                      ->orWhere('penulis', 'like', "%{$search}%")
                      ->orWhere('isbn', 'like', "%{$search}%")
                      ->orWhereHas('category', function($catQuery) use ($search) {
                          $catQuery->where('name', 'like', "%{$search}%"); // Bisa search berdasarkan nama kategori juga
                      });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Ambil semua data kategori untuk dropdown di modal tambah & edit
        $categories = Category::all();

        return view('admin.buku.index', compact('buku', 'search', 'categories'));
    }

    // Menyimpan data buku baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer',
            'category_id' => 'required|exists:categories,id',
            'stok' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Book::create($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    // Mengupdate data buku
    public function update(Request $request, Book $buku)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer',
            'category_id' => 'required|exists:categories,id',
            'stok' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        } else {
            unset($data['cover']);
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    // Menghapus data buku
    public function destroy(Book $buku)
    {
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}