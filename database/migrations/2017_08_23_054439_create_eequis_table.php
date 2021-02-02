<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEequisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eequis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('units_id');
            $table->integer('areas_id');
            $table->integer('tequis_id');
            $table->string('tag');
            $table->integer('hours');
            $table->integer('est_qty'); //cantidad estimada
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
        //
    }
}
