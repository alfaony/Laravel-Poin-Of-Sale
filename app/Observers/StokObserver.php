<?php

namespace App\Observers;

use App\stok;
use App\produk_material;
use App\produk_subcategori;

class StokObserver
{
    private function generatePrice($stok)
    {   
        $stok = stok::with('material')->find($stok->id);
        $material = $stok->material()->get();
        foreach ($material as $a)
        {
            $update = $stok->material()->where('id',$a->id)->first();
            
            $nilai_ekenomis_pakai = $stok->harga_ekonomis* $a->qty_pakai;
            $update->update([
                'nilai_ekenomis_pakai'=>$nilai_ekenomis_pakai
            ]);
            $produk = produk_subcategori::with('produk_material')->find($a->produk_subcategori_id);
            $material = $produk->produk_material()->get();
            $hpp = $material->sum(function($q){
                return $q->nilai_ekenomis_pakai;
            });
            $laba = $produk->harga - $hpp;
            $produk->update([
                'laba'=>$laba,
                'hpp'=>$hpp
            ]);
            
        }
    }
    public function created(Stok $stok)
    {
        //  
    }

    /**
     * Handle the stok "updated" event.
     *
     * @param  \App\Stok  $stok
     * @return void
     */
    public function updated(Stok $stok)
    {
        $this->generatePrice($stok);
    }

    /**
     * Handle the stok "deleted" event.
     *
     * @param  \App\Stok  $stok
     * @return void
     */
    public function deleted(Stok $stok)
    {
        //
    }

    /**
     * Handle the stok "restored" event.
     *
     * @param  \App\Stok  $stok
     * @return void
     */
    public function restored(Stok $stok)
    {
        //
    }

    /**
     * Handle the stok "force deleted" event.
     *
     * @param  \App\Stok  $stok
     * @return void
     */
    public function forceDeleted(Stok $stok)
    {
        //
    }
}
