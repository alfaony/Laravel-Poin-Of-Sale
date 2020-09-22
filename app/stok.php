<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stok extends Model
{
    protected $guarded = [];
    protected $table = 'stok';

    public function kategori_stok()
    {
        return $this->belongsTo(kategori_stok::class);
    }
    public function material(){
        return $this->hasMany(produk_material::class);
    }
}
