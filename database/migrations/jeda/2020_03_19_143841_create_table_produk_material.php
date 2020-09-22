<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProdukMaterial extends Migration
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
            $table->increments("id");
            $table->integer("produk_subcategori_id");
            $table->integer("stok_id");
            $table->decimal("qty_pakai");
            $table->decimal("nilai_ekonomis_pakai");
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
        Schema::table('produk_material', function (Blueprint $table) {
            //
        });
    }
}
