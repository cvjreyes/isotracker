<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisoctrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('disoctrls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('isostatus_id');
            $table->string('filename');
            $table->float('progress');
            $table->float('progressreal');
            $table->float('progressmax');
            $table->string('revision');
            $table->string('issuedfolder');
            $table->string('issuedate');
            $table->string('deleted');
            $table->string('ddesign')->nullable();
            $table->string('instress')->nullable();
            $table->string('dstress')->nullable();
            $table->string('insupports')->nullable();
            $table->string('dsupports')->nullable();
            $table->string('inmaterials')->nullable();
            $table->string('dmaterials')->nullable();
            $table->string('inlead')->nullable();
            $table->string('dlead')->nullable();
            $table->string('iniso')->nullable(); 
            $table->string('diso')->nullable();           
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
