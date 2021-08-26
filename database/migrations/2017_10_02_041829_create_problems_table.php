<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('current_stage_id')->unsigned()->nullable()->index();
            $table->foreign('current_stage_id')->references('id')->on('stages')->onDelete('set null');

            $table->integer('department_id')->unsigned()->nullable()->index();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');

            $table->integer('vehicle_model_id')->unsigned()->index();
            $table->foreign('vehicle_model_id')->references('id')->on('vehicle_models');

            $table->integer('dealer_id')->unsigned()->index();
            $table->foreign('dealer_id')->references('id')->on('dealers');

            $table->integer('region_id')->unsigned()->index();
            $table->foreign('region_id')->references('id')->on('regions');

            $table->string('vin',20);
            $table->string('part_type',50)->nullable();
            $table->string('part_number',10)->nullable();
            $table->text('description')->nullable();
            $table->string('contact_info',255)->nullable();

            $table->integer('problem_type_id')->unsigned()->nullable()->index();
            $table->foreign('problem_type_id')->references('id')->on('problem_types')->onDelete('set null');
            $table->boolean('has_penalty')->default(false);
            $table->string('attachment', 255)->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->tinyInteger('status')->default(\App\Problem::STATUS_OPEN);
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
        Schema::dropIfExists('problems');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
