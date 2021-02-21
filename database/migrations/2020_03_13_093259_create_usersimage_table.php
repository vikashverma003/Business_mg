<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersimageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersimage', function (Blueprint $table) {
           
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('upload_id');
            $table->string('selfie');
            $table->string('upload_profile')->nullable();

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
        Schema::dropIfExists('usersimage');
    }
}
