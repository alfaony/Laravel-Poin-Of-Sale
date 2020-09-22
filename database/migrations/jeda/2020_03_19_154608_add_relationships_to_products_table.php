<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produk', function (Blueprint $table)
        {
            $table->integer('categori_id')->unsigned()->change();
            $table->foreign('categori_id')->references('id')->on('categori')
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
        Schema::table('produk', function(Blueprint $table){
            $table->dropForeign('produk_categori_id_foreign');
        });
        Schema::table('produk', function(Blueprint $table) {
            $table->dropIndex('produk_categori_id_foreign');
        });
        Schema::table('produk', function(Blueprint $table) {
            $table->integer('categori_id')->change();
        });
    }
}
