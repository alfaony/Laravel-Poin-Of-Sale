<?php

namespace App\Observers;

use App\to_order;
use App\total_order;
use App\produk_material;
use App\stok;

class to_orderObserver
{
    /**
     * Handle the to_order "created" event.
     *
     * @param  \App\to_order  $toOrder
     * @return void
     */
    private function generateLaba(to_order $toOrder)
    {
        $to_order = to_order::where('total_order_code',$toOrder->total_order_code)->get();
        // total
        
        $laba = $to_order->sum(function($i)
        {
            return $i->laba * $i->qty;
        });

        //Update total Pemesanan
        $total_order = total_order::where('code',$toOrder->total_order_code)
        ->update([
            'laba'=>$laba
        ]);
    }
    private function generateUang()
    {
        $to_order = to_order::where('total_order_code',$toOrder->total_order_code)->get();
        // total
        
        $harga = $to_order->sum(function($i)
        {
            return $i->harga * $i->qty;
        });

        //Update total Pemesanan
        $total_order = total_order::where('code',$toOrder->total_order_code)
        ->update([
            'harga'=>$harga
        ]);
    }
    public function created(to_order $toOrder)
    {
        $this->generateLaba($toOrder);
    }

    /**
     * Handle the to_order "updated" event.
     *
     * @param  \App\to_order  $toOrder
     * @return void
     */
    public function updated(to_order $toOrder)
    {
        $this->generateLaba();
    }

    /**
     * Handle the to_order "deleted" event.
     *
     * @param  \App\to_order  $toOrder
     * @return void
     */
    public function delete(to_order $toOrder)
    {
        dd("oke");
    }

    /**
     * Handle the to_order "restored" event.
     *
     * @param  \App\to_order  $toOrder
     * @return void
     */
    public function restored(to_order $toOrder)
    {
        dd("oke");
    }

    /**
     * Handle the to_order "force deleted" event.
     *
     * @param  \App\to_order  $toOrder
     * @return void
     */
    public function forceDeleted(to_order $toOrder)
    {
        dd("oke");
    }
}
