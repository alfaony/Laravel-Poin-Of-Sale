<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToSubcategoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subcategoris', function (Blueprint $table) 
        {
            $table->integer('categori_id')->unsigned()->change();
            $table->foreign('categori_id')->references('id')->on('categories')
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
        Schema::table('subcategoris', function(Blueprint $table){
            $table->dropForeign('subcategori_categori_id_foreign');
        });
        Schema::table('subcategoris', function(Blueprint $table) {
            $table->dropIndex('subcategori_categori_id_foreign');
        });
        Schema::table('subcategoris', function(Blueprint $table) {
            $table->integer('categori_id')->change();
        });
    }
}
