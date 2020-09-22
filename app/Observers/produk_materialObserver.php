<?php

namespace App\Observers;

use App\produk_material;
use App\produk;

class produk_materialObserver
{
       private function generatePrice($produkMaterial)
    {
        // / Produk
        $produk = produk::find($produkMaterial->produk_id);
        // id sotk
        $stok = $produkMaterial->stok_id;
        // Mengambil nilai dari sum
        $produk_material = produk_material::where('produk_id',$produk->id)->get();
        $total_hpp = $produk_material->sum(function($i){
            return $i->nilai_ekenomis_pakai;
        });
        
        $laba = $produk->harga - $total_hpp;
        
        $produk->update([
            'hpp'=>$total_hpp,
            'laba'=>$laba
        ]);

    }
    public function created(produk_material $produkMaterial)
    {

        
        // $this->generatePrice($produkMaterial);
    }

    /**
     * Handle the produk_material "updated" event.
     *
     * @param  \App\produk_material  $produkMaterial
     * @return void
     */
    public function updated(produk_material $produkMaterial)
    {
        // $this->generatePrice($produkMaterial);
    }

    /**
     * Handle the produk_material "deleted" event.
     *
     * @param  \App\produk_material  $produkMaterial
     * @return void
     */
    public function deleted(produk_material $produkMaterial)
    {
        // $this->generatePrice($produkMaterial);
    }

    /**
     * Handle the produk_material "restored" event.
     *
     * @param  \App\produk_material  $produkMaterial
     * @return void
     */
    public function restored(produk_material $produkMaterial)
    {
        // $this->generatePrice($produkMaterial);
    }

    /**
     * Handle the produk_material "force deleted" event.
     *
     * @param  \App\produk_material  $produkMaterial
     * @return void
     */
    public function forceDeleted(produk_material $produkMaterial)
    {
        // $this->generatePrice($produkMaterial);
    }
}
