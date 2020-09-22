<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categori extends Model
{
    protected $table = 'categori';
    protected $fillable = ['name','created_at','updated_at'];

    public function subcategori()
    {
        return $this->hasMany(Subcategori::class);
    }
    public function produk()
    {
        return $this->belongsTo(produk::class);
    }
}
