<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kategori_stok extends Model
{
    protected $table = "kategori_stok";

    public function stok(){
        return $this->hasOne(stok::class);
    }

}
