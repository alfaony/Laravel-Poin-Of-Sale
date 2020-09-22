<?php

namespace App\Imports;

use App\produk;
use Maatwebsite\Excel\Concerns\ToModel;

class ProdukImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new produk(
            [
            'kode'=>$row['0'],
            'name'=>$row['1'],
            'categori_id'=>$row['2']
        ]);
    }
}
