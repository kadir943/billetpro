<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStatutBilletsTable extends Migration
{
    public function up()
    {
        \DB::statement("ALTER TABLE billets MODIFY COLUMN statut ENUM('valide','utilise','annule','en_attente') NOT NULL DEFAULT 'en_attente'");
    }

    public function down()
    {
        \DB::statement("ALTER TABLE billets MODIFY COLUMN statut ENUM('valide','utilise','annule') NOT NULL DEFAULT 'valide'");
    }
}
