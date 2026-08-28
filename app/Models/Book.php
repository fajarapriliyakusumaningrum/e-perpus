<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'category_id', // Ganti 'kategori' teks dengan 'category_id'
        'isbn',
        'tahun_terbit',
        'stok',
        'cover',
    ];

    // Relasi balik: Buku milik satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}