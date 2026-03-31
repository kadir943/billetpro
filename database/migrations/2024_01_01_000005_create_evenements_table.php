<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvenementsTable extends Migration
{
    public function up()
    {
        Schema::create('evenements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titre', 200);
            $table->text('description')->nullable();
            $table->dateTime('date_evenement')->nullable();
            $table->string('lieu', 200)->nullable();
            $table->decimal('prix', 10, 2)->default(0);
            $table->integer('capacite')->default(0);
            $table->integer('places_disponibles')->default(0);
            $table->string('image', 255)->nullable();
            $table->unsignedInteger('organisateur_id');
            $table->unsignedInteger('categorie_id')->nullable();
            $table->enum('statut', ['actif', 'annule', 'termine'])->default('actif');
            $table->timestamps();
            $table->foreign('organisateur_id')->references('id')->on('organisateurs')->onDelete('cascade');
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('evenements');
    }
}
