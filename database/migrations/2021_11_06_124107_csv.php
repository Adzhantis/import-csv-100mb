<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Csv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descending_year_orders', function (Blueprint $table) {
            $table->id();
            $table->string('anzsic06');
            $table->string('area');
            $table->integer('year');
            $table->integer('geo_count');
            $table->integer('ec_count');
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
        Schema::drop('descending_year_orders');
    }
}
