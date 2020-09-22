<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class total_order extends Model
{
    
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    protected $table = 'total_order';

    protected $guarded = [];

    public $timestamps = false;

    public function to_order()
    {
        return $this->hasMany(to_order::class,'total_order_code');
    }
}
