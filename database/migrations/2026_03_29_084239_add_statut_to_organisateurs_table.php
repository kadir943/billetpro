<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatutToOrganisateursTable extends Migration
{
    public function up()
    {
        Schema::table('organisateurs', function (Blueprint $table) {
            $table->string('statut')->default('en_attente')->after('telephone');
        });
    }

    public function down()
    {
        Schema::table('organisateurs', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
}
