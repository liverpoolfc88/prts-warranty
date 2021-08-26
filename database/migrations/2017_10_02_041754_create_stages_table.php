<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',255);
            $table->unsignedSmallInteger('sequence');
            $table->integer('stage_group_id')->unsigned()->nullable()->index();
            $table->foreign('stage_group_id')->references('id')->on('stage_groups')->onDelete('set null');
            $table->boolean('has_action')->default(false);
            $table->boolean('has_date')->default(false);
            $table->boolean('has_attachment')->default(false);
            $table->boolean('has_approval')->default(false);
            $table->unsignedSmallInteger('owner')->default(\App\User::ROLE_SUPPLIER);
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('stages');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
