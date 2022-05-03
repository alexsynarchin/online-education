<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileTypeInEduChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edu_chats', function (Blueprint $table) {
            $table->string('sender_type')->default('teacher');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('edu_chats', function (Blueprint $table) {
            $table->dropColumn(['sender_type']);
        });
    }
}
