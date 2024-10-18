<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroPescaTable extends Migration
{
    public function up()
    {
        Schema::create('registro_pesca', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('local');
            $table->timestamp('data_com_hora');
            $table->string('codigo');
            $table->string('quantidade')->nullable();;
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('pescado')->nullable();
            $table->foreign('local')->references('id')->on('localizacao')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registro_pesca');
    }
}
