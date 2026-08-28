<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->withCount('books')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.kategori.index', compact('categories', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Category $kategori)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $kategori->id,
        ]);

        $kategori->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $kategori)
    {
        if ($kategori->books()->count() > 0) {
            return redirect()->route('admin.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh buku!');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}