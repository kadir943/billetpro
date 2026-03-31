<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationBilletsTable extends Migration
{
    public function up()
    {
        Schema::create('verification_billets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('billet_id');
            $table->unsignedInteger('verifie_par');
            $table->dateTime('date_verification')->nullable();
            $table->string('statut', 50)->default('valide');
            $table->timestamps();
            $table->foreign('billet_id')->references('id')->on('billets')->onDelete('cascade');
            $table->foreign('verifie_par')->references('id')->on('organisateurs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('verification_billets');
    }
}
