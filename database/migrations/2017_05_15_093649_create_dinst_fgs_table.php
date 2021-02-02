<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDinstFgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dinst_fgs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('zone_name');
            $table->string('item_name');
            $table->string('item_type');
            $table->integer('status_fg');
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
        Schema::dropIfExists('dinst_fgs');
    }
}
