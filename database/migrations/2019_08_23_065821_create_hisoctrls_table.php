<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHisoctrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hisoctrls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename');
            $table->integer('revision');
            $table->integer('tie');
            $table->integer('spo');
            $table->integer('sit');
            $table->boolean('requested')->nullable();
            $table->boolean('requestedlead')->nullable();
            $table->boolean('issued')->nullable();
            $table->boolean('deleted')->nullable();
            $table->boolean('hold')->nullable();
            $table->boolean('claimed')->nullable();
            $table->boolean('verifydesign')->nullable();
            $table->boolean('verifystress')->nullable();
            $table->boolean('verifysupports')->nullable();
            $table->boolean('fromldgsupports')->nullable();
            $table->string('from');
            $table->string('to');
            $table->longText('comments');
            $table->string('user');
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
