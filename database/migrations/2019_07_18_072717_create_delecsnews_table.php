<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDelecsnewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delecsnews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('units_id')->nullable();
            $table->integer('areas_id');
            $table->integer('telecs_id');
            $table->string('tag');
            $table->integer('pelecs_id');
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
