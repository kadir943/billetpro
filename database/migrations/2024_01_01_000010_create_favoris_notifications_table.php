<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavorisNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('evenement_id');
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('evenement_id')->references('id')->on('evenements')->onDelete('cascade');
            $table->unique(['client_id', 'evenement_id']);
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->text('message');
            $table->dateTime('date_envoi')->nullable();
            $table->string('statut', 50)->default('non_lu');
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });

        Schema::create('statistiques', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('evenement_id');
            $table->integer('billets_vendus')->default(0);
            $table->decimal('revenu_total', 10, 2)->default(0);
            $table->timestamps();
            $table->foreign('evenement_id')->references('id')->on('evenements')->onDelete('cascade');
        });

        Schema::create('historique_paiements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('paiement_id');
            $table->string('statut', 50);
            $table->dateTime('date_modification')->nullable();
            $table->timestamps();
            $table->foreign('paiement_id')->references('id')->on('paiements')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('historique_paiements');
        Schema::dropIfExists('statistiques');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('favoris');
    }
}
