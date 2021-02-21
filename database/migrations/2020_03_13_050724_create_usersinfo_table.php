<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersinfo', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('gender');
            $table->string('born');
            $table->string('fathername')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('interior_house')->nullable();
            $table->string('exterior_house')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('country')->nullable();
            $table->string('chronic_illness')->nullable();
            $table->string('consume_medicines')->nullable();
            $table->string('allergic_medication')->nullable();
            $table->string('fractures')->nullable();
            $table->string('supervison')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('education_level')->nullable();
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
        Schema::dropIfExists('usersinfo');
    }
}
