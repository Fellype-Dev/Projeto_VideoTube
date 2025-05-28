<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('url', 2048)->change(); // Aumenta para 2048 caracteres
        });
    }

    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('url', 255)->change(); // Reverte para o tamanho original
        });
    }
};