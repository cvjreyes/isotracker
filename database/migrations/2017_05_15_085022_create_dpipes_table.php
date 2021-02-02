<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDpipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dpipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('zone_name');
            $table->string('pipe_name');
            $table->string('pid');
            $table->integer('ppipe_pids_id')->unsigned();
            $table->foreign('ppipe_pids_id')->references('id')->on('ppipe_pids');
            $table->string('iso');
            $table->integer('ppipe_isos_id')->unsigned();
            $table->foreign('ppipe_isos_id')->references('id')->on('ppipe_isos');
            $table->string('stress');
            $table->integer('ppipe_stresses_id')->unsigned();
            $table->foreign('ppipe_stresses_id')->references('id')->on('ppipe_stresses');
            $table->string('support');
            $table->integer('ppipe_supports_id')->unsigned();
            $table->foreign('ppipe_supports_id')->references('id')->on('ppipe_supports');
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
        Schema::dropIfExists('dpipes');
    }
}
