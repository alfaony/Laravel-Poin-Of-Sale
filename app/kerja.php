<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kerja extends Model
{
    // protected $guarded = [];
    protected $fillable = ['tanggal','user_id','status','antrian','jam_buka','jam_tutup','total','sales','profit'];
    protected $table = "kerja";
    public $timestamps = false; 
}
