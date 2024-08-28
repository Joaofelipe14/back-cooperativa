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
            $table->string('local');
            $table->timestamp('data_com_hora');
            $table->string('codigo');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registro_pesca');
    }
}
