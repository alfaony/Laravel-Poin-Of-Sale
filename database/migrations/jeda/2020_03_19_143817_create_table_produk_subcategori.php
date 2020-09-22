<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProdukSubcategori extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produk_subcategori', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('subcategori_id');
            $table->integer('produk_id');
            $table->integer('harga');
            $table->integer('hpp');
            $table->integer('laba');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produk_subcategori', function (Blueprint $table) {
            //
        });
    }
}
