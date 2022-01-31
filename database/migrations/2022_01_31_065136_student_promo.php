<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentPromo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_promo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->unsigned()->index();
            $table->foreign('student_id')->references('id')->on('student_accounts')->onDelete('cascade');
            $table->bigInteger('promo_id')->unsigned()->index();
            $table->foreign('promo_id')->references('id')->on('promo_codes')->onDelete('cascade');
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
        Schema::dropIfExists('student_promo');
    }
}
