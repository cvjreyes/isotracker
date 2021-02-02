<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTpipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tpipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('hours');
            $table->string('code');
            $table->integer('pid');
            $table->integer('iso');
            $table->integer('stress');
            $table->integer('support');
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
