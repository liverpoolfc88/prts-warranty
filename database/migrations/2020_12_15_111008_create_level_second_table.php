<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelSecondTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_seconds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('level_first_id')->unsigned();
            $table->foreign('level_first_id')->references('id')->on('level_firsts');
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
