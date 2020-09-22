<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProdukMaterialToProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produk_material', function (Blueprint $table)
        {
            $table->integer('produk_subcategori_id')->unsigned()->change();
            $table->foreign('produk_subcategori_id')->references('id')->on('produk_subcategori')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('stok_id')->unsigned()->change();
            $table->foreign('stok_id')->references('id')->on('stok')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produk_material', function(Blueprint $table){
            $table->dropForeign('produk_material_produk_subcategori_id_foreign');
        });
        Schema::table('produk_material', function(Blueprint $table) {
            $table->dropIndex('produk_material_produk_subcategori_id_foreign');
        });
        Schema::table('produk_material', function(Blueprint $table) {
            $table->integer('produk_subcategori_id')->change();
        });

        Schema::table('produk_material', function(Blueprint $table){
            $table->dropForeign('produk_material_stok_id_foreign');
        });
        Schema::table('produk_material', function(Blueprint $table) {
            $table->dropIndex('produk_material_stok_id_foreign');
        });
        Schema::table('produk_material', function(Blueprint $table) {
            $table->integer('stok_id')->change();
        });
    }
}
