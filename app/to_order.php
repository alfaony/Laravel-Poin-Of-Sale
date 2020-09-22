<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class to_order extends Model
{
    protected $table = 'to_order';
    protected $guarded = [];
    public $timestamps = false;


    public function total_order()
    {
        return $this->belongsTo(total_order::class,'code');
    }
    public function produkSubcategori()
    {
        return $this->belongsTo(produk_subcategori::class);
    }
}
