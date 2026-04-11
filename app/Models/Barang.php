<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
protected $guarded = [];
protected $fillable = [
    'kode_barang', 
    'nama_barang', 
    'category_code', 
    'stok', 
    'harga', 
    'deskripsi'
];
    public function kategori()
    {
        // Menghubungkan kolom category_code di Barangs ke kode_category di Categorys
        return $this->belongsTo(Category::class, 'category_code', 'kode_category');
    }
}
