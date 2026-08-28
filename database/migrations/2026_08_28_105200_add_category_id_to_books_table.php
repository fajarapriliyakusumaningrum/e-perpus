<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Hapus kolom kategori teks yang lama jika ada, lalu ganti dengan foreign key category_id
            $table->dropColumn('kategori'); // Hapus baris ini kalau di database kamu kolom 'kategori' sudah terlanjur tidak ada
            $table->foreignId('category_id')->after('penerbit')->constrained('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
