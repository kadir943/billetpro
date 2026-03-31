<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecuToPaiementsTable extends Migration
{
    public function up()
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->string('recu_paiement')->nullable()->after('reference');
            $table->string('code_transaction')->nullable()->after('recu_paiement');
            $table->integer('employe_id')->unsigned()->nullable()->after('code_transaction');
            $table->timestamp('date_verification')->nullable()->after('employe_id');
        });
    }

    public function down()
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropColumn(['recu_paiement', 'code_transaction', 'employe_id', 'date_verification']);
        });
    }
}
