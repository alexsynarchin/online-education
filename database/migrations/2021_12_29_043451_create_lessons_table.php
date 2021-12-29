<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')->unsigned()->nullable();
            $table->string('title')->nullable();
            $table->string('slug');
            $table->BigInteger('course_id')->unsigned()->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->boolean('deleted')->default(0);
            $table->integer('price')->default(0);
            $table->integer('price_user');
            $table->boolean('type_text') ->default(false);
            $table->boolean('type_video')->default(false);
            $table->boolean('type_image')->default(false);
            $table->smallInteger('time')->nullable();
            $table->tinyInteger('status')->unsigned()->default(0);
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
        Schema::dropIfExists('lessons');
    }
}
