<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];
    protected $table = 'groups';
    protected $fillable = ['kode_group', 'nama_group'];
    public function Group() {
        
        return $this->hasMany(Group::class);
    }
}
