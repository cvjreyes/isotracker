<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEcivilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecivils', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('units_id');
            $table->integer('tcivils_id');
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
