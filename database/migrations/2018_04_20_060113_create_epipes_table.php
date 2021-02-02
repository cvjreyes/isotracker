<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epipes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('units_id')->nullable();
            $table->integer('areas_id')->nullable();
            $table->float('diameters_id')->nullable();
            $table->string('line_number')->nullable();            
            $table->string('pdms_linenumber')->nullable();
            $table->string('calc_notes')->nullable();
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
