<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvisTable extends Migration
{
    public function up()
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('evenement_id');
            $table->integer('note')->default(5);
            $table->text('commentaire')->nullable();
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('evenement_id')->references('id')->on('evenements')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('avis');
    }
}
