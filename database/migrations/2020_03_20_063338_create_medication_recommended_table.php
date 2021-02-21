<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicationRecommendedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('medication_recommended', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('request_id');
            $table->string('name')->nullable();
            $table->string('dosage')->nullable();
            $table->string('no_day')->nullable();
            $table->string('frequency')->nullable();
            $table->string('instruction')->nullable();
            $table->string('route_administrations')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')
                ->references('id')
                ->on("users")
                ->onDelete('cascade');

            $table->foreign('doctor_id')
            ->references('id')
            ->on("users")
            ->onDelete('cascade');
            
            $table->foreign('request_id')
            ->references('id')
            ->on("chat_request")
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
        Schema::dropIfExists('medication_recommended');
    }
}
