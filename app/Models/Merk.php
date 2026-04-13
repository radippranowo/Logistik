<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    protected $guarded = [];
    protected $table = 'merks';
    protected $fillable = ['kode_merk', 'nama_merk'];
    public function merks() {
        
        return $this->hasMany(Merk::class);
    }
}
