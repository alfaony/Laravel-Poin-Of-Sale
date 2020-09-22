<?php

namespace App\Observers;

use App\total_order;
use App\to_order;

class total_orderObserver
{
    /**
     * Handle the total_order "created" event.
     *
     * @param  \App\total_order  $totalOrder
     * @return void
     */
    public function created(total_order $totalOrder)
    {
        //
    }

    /**
     * Handle the total_order "updated" event.
     *
     * @param  \App\total_order  $totalOrder
     * @return void
     */
    public function updated(total_order $totalOrder)
    {
        $to_order = to_order::where('code',$totalOrder->code)->get();
        $to_order->update(
            [
            'status'=>'done'
        ]);
    }

    /**
     * Handle the total_order "deleted" event.
     *
     * @param  \App\total_order  $totalOrder
     * @return void
     */
    public function deleted(total_order $totalOrder)
    {
        //
    }

    /**
     * Handle the total_order "restored" event.
     *
     * @param  \App\total_order  $totalOrder
     * @return void
     */
    public function restored(total_order $totalOrder)
    {
        //
    }

    /**
     * Handle the total_order "force deleted" event.
     *
     * @param  \App\total_order  $totalOrder
     * @return void
     */
    public function forceDeleted(total_order $totalOrder)
    {
        //
    }
}
