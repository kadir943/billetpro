<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaiementsTable extends Migration
{
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('billet_id');
            $table->decimal('montant', 10, 2);
            $table->string('methode_paiement', 50)->default('carte');
            $table->enum('statut_paiement', ['en_attente', 'reussi', 'echoue'])->default('en_attente');
            $table->dateTime('date_paiement')->nullable();
            $table->string('reference', 100)->nullable();
            $table->timestamps();
            $table->foreign('billet_id')->references('id')->on('billets')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }
}
