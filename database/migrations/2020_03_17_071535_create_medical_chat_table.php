<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_chat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('fullname')->nullable();
            $table->string('professional_card')->nullable();
            $table->string('language')->nullable();
            $table->string('short_description')->nullable();
            $table->string('experience')->nullable();
            $table->string('degrees')->nullable();
            $table->string('workplace')->nullable();
            $table->string('profile_photo')->nullable();

            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on("users")
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_chat');
    }
}
