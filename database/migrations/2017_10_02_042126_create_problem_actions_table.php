<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problem_actions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('problem_id')->unsigned()->index();
            $table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->integer('stage_id')->unsigned()->nullable()->index();
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('set null');

            $table->text('content')->nullable();
            $table->string('attachment')->nullable();
            $table->boolean('accepted')->nullable();
            $table->dateTime('deadline_at')->nullable();
            $table->boolean('completed')->default(false);
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
        Schema::dropIfExists('problem_actions');
    }
}
