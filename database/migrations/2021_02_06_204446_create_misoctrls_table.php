<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMisoctrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('misoctrls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename');
            $table->string('isoid');
            $table->integer('revision')->nullable();
            $table->integer('tie')->nullable();
            $table->integer('spo')->nullable();
            $table->integer('sit')->nullable();
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
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->longText('comments')->nullable();
            $table->string('user')->nullable();
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
