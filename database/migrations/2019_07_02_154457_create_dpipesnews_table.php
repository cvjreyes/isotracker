<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDpipesnewsTable extends Migration
{
    /**
     * Run the migrations.migr
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dpipesnews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('units_id')->nullable();
            $table->integer('areas_id');
            $table->string('tag');
            $table->integer('diameters_id');
            $table->boolean('calc_notes');
            $table->integer('ppipe_pids_id');
            $table->integer('ppipe_isos_id');
            $table->integer('ppipe_stresses_id');
            $table->integer('ppipe_supports_id');
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
