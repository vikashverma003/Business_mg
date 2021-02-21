<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUseCfdiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('use_cfdi', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('purchase_goods')->nullable();
            $table->string('returns')->nullable();
            $table->string('accessories')->nullable();
            $table->string('telephone_communications')->nullable();
            $table->string('satellite_communications')->nullable();
            $table->string('hospital_fees')->nullable();
            $table->string('handicap')->nullable();
            $table->string('insurance_premiums')->nullable();
            $table->string('educational_services')->nullable();
            $table->string('be_defined')->nullable();
           
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
        Schema::dropIfExists('use_cfdi');
    }
}
