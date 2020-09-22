<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class produk_material extends Model
{
    protected $guarded = [];
    protected $table = 'produk_material';
    
    public function produk()
    {
        return $this->belongsTo(produk_subcategori::class);
    }

    public function stok()
    {
        return $this->belongsTo(stok::class);
    }
}
