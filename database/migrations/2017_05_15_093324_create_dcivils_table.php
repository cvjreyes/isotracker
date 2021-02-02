<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDcivilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dcivils', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag');
            $table->integer('progress');
            //$table->integer('pequis_id')->unsigned();
            //$table->foreign('pequis_id')->references('id')->on('pequis');
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
        Schema::dropIfExists('dcivils');
    }
}
