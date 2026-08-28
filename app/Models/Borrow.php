<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    // Relasi ke User (Anggota)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Book (Buku)
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}