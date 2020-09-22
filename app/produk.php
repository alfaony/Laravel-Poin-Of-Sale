<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    protected $table = 'produk';
    protected $guarded = [];

    public function categori(){
        return $this->belongsTo(Categori::class);
    }
    public function subcategori()
    {
        return $this->hasMany(produk_subcategori::class);
    }
}
