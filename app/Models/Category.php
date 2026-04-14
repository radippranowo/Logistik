<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    protected $table = 'categorys';
    protected $fillable = ['kode_category', 'nama_category'];
    public function barangs() {
        
        // return $this->hasMany(Barang::class);
        return $this->hasMany(Barang::class, 'category_code', 'kode_category');
        
    }
    
    
}
