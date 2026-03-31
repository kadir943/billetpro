<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToOrganisateursTable extends Migration
{
    public function up()
    {
        Schema::table('organisateurs', function (Blueprint $table) {
            $table->string('nom_organisation')->nullable()->after('nom');
            $table->enum('type_organisation', ['entreprise', 'association', 'particulier'])->default('particulier')->after('nom_organisation');
            $table->string('telephone_pro')->nullable()->after('telephone');
            $table->string('numero_ifu')->nullable()->after('telephone_pro');
            $table->string('photo_identite')->nullable()->after('numero_ifu');
        });
    }

    public function down()
    {
        Schema::table('organisateurs', function (Blueprint $table) {
            $table->dropColumn(['nom_organisation', 'type_organisation', 'telephone_pro', 'numero_ifu', 'photo_identite']);
        });
    }
}
