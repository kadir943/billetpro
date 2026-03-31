<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResetCodesTable extends Migration
{
    public function up()
    {
        Schema::create('reset_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('code', 6);
            $table->string('role');
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reset_codes');
    }
}
