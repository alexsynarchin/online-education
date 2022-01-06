<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type');
            $table->string('slug');
            $table->boolean('active')->default(true);
            $table->integer('menuindex')->default(0);
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('category_types')->onDelete('cascade');
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
        Schema::dropIfExists('category_types');
    }
}
