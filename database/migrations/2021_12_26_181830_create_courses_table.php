<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->mediumText('description')->nullable();
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('edu_type_id')->unsigned()->nullable();
            $table->bigInteger('subject_id')->unsigned()->nullable();
            $table->bigInteger('edu_level_id')->unsigned()->nullable();
            $table->smallInteger('lessons_count')->default(0);
            $table->bigInteger('author_id') -> unsigned()->nullable();
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
        Schema::dropIfExists('courses');
    }
}
