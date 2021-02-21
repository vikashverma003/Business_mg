<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralDocumentationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_documentation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('professional_card')->nullable();
            $table->string('professional_document')->nullable();
            $table->string('professional_title')->nullable();
            $table->string('official_identification')->nullable();
            $table->string('curp')->nullable();
            $table->string('curp_document')->nullable();
            $table->string('rfc')->nullable();
            $table->string('rfc_document')->nullable();
            $table->string('proof_address')->nullable();
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
        Schema::dropIfExists('general_documentation');
    }
}
