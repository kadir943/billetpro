<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBilletsTable extends Migration
{
    public function up()
    {
        Schema::create('billets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('evenement_id');
            $table->string('numero_billet', 100)->unique();
            $table->string('code_qr', 255)->nullable();
            $table->enum('statut', ['valide', 'utilise', 'annule'])->default('valide');
            $table->integer('quantite')->default(1);
            $table->decimal('prix_unitaire', 10, 2)->default(0);
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('evenement_id')->references('id')->on('evenements')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('billets');
    }
}
