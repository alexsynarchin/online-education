<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseThemeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_theme', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id')->unsigned()->index();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->bigInteger('theme_id')->unsigned()->index();
            $table->foreign('theme_id')->references('id')->on('category_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_theme');
    }
}
