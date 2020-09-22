<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barista extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    protected $table = "barista";
}
