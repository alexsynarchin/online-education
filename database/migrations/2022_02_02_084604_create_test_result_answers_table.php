<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_result_answers', function (Blueprint $table) {
            $table->id();
            $table->Biginteger('test_result_id')->unsigned()->nullable();
            $table->foreign('test_result_id')->references('id')->on('test_results')->onDelete('cascade');
            $table->Biginteger('question_id')->unsigned()->nullable();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->Biginteger('option_id')->unsigned()->nullable();
            $table->foreign('option_id')->references('id')->on('question_options')->onDelete('cascade');
            $table->tinyInteger('correct')->default(0);
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
        Schema::dropIfExists('test_result_answers');
    }
}
