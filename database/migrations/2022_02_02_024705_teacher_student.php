<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TeacherStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_student', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('teacher_id')->unsigned()->index();
            $table->foreign('teacher_id')->references('id')->on('teacher_accounts')->onDelete('cascade');
            $table->bigInteger('student_id')->unsigned()->index();
            $table->foreign('student_id')->references('id')->on('student_accounts')->onDelete('cascade');
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
        Schema::dropIfExists('teacher_student');
    }
}
