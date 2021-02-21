<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('role');
            $table->string('profile_image')->nullable();
            $table->string('account_status')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('otp')->nullable();
            $table->string('device_token')->nullable();
            $table->boolean("is_complete")->default(0);
            $table->boolean("paid_consultation")->default(0);
            $table->boolean("free_consultation")->default(0);
            $table->string("rating")->nullable();
            $table->string("fees")->nullable();
            $table->string('password')->nullable();
            $table->string('block_status')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
