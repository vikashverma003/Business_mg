<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('company_name')->nullable();
            $table->string('name_rfc')->nullable();
            $table->string('address')->nullable();
            $table->string('number')->nullable();
            $table->string('municipality')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('telephone')->nullable();
            $table->string('mail')->nullable();
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
        Schema::dropIfExists('billing_data');
    }
}
