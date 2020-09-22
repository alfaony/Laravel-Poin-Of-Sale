<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSubcateogi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subcategoris', function (Blueprint $table) {
            $table->increment("id");
            $table->integer("categori_id");
            $table->string("name");
            $table->timestamp();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subcategori', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("categori_id");
            $table->string("name");
            $table->timestamps();
        });
    }
}
