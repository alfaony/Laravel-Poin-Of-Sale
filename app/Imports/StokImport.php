<?php

namespace App\Imports;

use App\stok;
use Maatwebsite\Excel\Concerns\ToModel;

class StokImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row['2']==null or $row['3']==null)
        {
            $harga_ekonomis = 1 / 1;
        }else{
            $harga_ekonomis = $row['2']/$row['3'];
        }
        return new stok(
            [
            'stokcol'=>$row['0'],
            'kategori_stok_id'=>$row['1'],
            'harga'=>$row['2'],
            'berat'=>$row['3'],
            'harga_ekonomis'=> $harga_ekonomis
        ]);
    }
}
