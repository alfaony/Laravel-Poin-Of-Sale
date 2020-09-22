<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

use App\Observers\to_orderObserver;
use App\Observers\total_orderObserver;
use App\Observers\StokObserver;
use App\Observers\produk_materialObserver;

use App\to_order;
use App\produk_material;
use App\stok;
use App\total_order;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        to_order::observe(to_orderObserver::class);
        total_order::observe(total_orderObserver::class);

        produk_material::observe(produk_materialObserver::class);
        stok::observe(StokObserver::class);

        Blade::component('components.card','card');
        Blade::component('components.alert',alertComponent::class);

        View::composer('transaksi.*', 'App\Http\View\CategoriComposer');
    }
}
