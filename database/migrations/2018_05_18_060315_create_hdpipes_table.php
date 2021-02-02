<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHdpipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hdpipes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('pid');
            $table->string('iso');
            $table->string('stress');
            $table->string('support');
            $table->string('pdms_linenumber');
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
