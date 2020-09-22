<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProdukSubcategoriToProdukTable extends Migration
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
            $table->integer('produk_id')->unsigned()->change();
            $table->foreign('produk_id')->references('id')->on('produk')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('subcategori_id')->unsigned()->change();
            $table->foreign('subcategori_id')->references('id')->on('subcategoris')
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
        Schema::table('produk_subcategori', function(Blueprint $table){
            $table->dropForeign('produk_subcategori_subcategori_id_foreign');
        });
        Schema::table('produk_subcategori', function(Blueprint $table) {
            $table->dropIndex('produk_subcategori_subcategori_id_foreign');
        });
        Schema::table('produk_subcategori', function(Blueprint $table) {
            $table->integer('subcategori_id')->change();
        });

        Schema::table('produk_subcategori', function(Blueprint $table){
            $table->dropForeign('produk_subcategori_produk_id_foreign');
        });
        Schema::table('produk_subcategori', function(Blueprint $table) {
            $table->dropIndex('produk_subcategori_produk_id_foreign');
        });
        Schema::table('produk_subcategori', function(Blueprint $table) {
            $table->integer('produk_id')->change();
        });
    
    }
}
