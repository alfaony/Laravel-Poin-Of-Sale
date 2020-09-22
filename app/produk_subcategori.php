<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class produk_subcategori extends Model
{
    protected $table = "produk_subcategori";
    protected $fillable =  [
        'subcategori_id',
        'harga',
        'hpp',
        'laba'
    ];
    public function produk()
    {
        return $this->belongsTo(produk::class);
    }
    public function subcategori()
    {
        return $this->belongsTo(Subcategori::class);
    }
    public function produk_material()
    {
        return $this->hasMany(produk_material::class);
    }
}
