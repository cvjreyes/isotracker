<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmanagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pmanagers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('weight')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('multiplier')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->integer('weeks')->nullable();
            $table->integer('startweek')->nullable();
            $table->boolean('locked')->nullable();
            $table->boolean('feed')->nullable();
            $table->float('per_feed')->nullable();
            $table->boolean('weight_total')->nullable();
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
