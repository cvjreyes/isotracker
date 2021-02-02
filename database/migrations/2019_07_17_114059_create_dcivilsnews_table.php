<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDcivilsnewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('dcivilsnews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('units_id')->nullable();
            $table->integer('areas_id');
            $table->integer('tcivils_id');
            $table->string('tag');
            $table->integer('pcivils_id');
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
