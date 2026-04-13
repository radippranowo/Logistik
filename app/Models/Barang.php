<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
protected $guarded = [];
protected $fillable = [
    'kode_barang', 
    'part_number', 
    'nama_barang', 
    'category_code', 
    'merk_code', 
    'group_code', 
    'stok', 
    'harga', 
    'deskripsi'
];
    public function kategori()
    {
        // Menghubungkan kolom category_code di Barangs ke kode_category di Categorys
        return $this->belongsTo(Category::class, 'category_code', 'kode_category');
    }
      public function merk()
    {
        // Menghubungkan kolom category_code di Barangs ke kode_category di Categorys
        return $this->belongsTo(Merk::class, 'merk_code', 'kode_merk');
    }
      public function group()
    {
        // Menghubungkan kolom category_code di Barangs ke kode_category di Categorys
        return $this->belongsTo(Group::class, 'group_code', 'kode_group');
    }
}
