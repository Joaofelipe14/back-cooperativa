<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registro_venda', function (Blueprint $table) {
            $table->id();
            $table->string('quantidade');
            $table->string('valor');
            $table->string('codigo');
            $table->unsignedBigInteger('ponto_venda');
            $table->string('pescado')->nullable();
            $table->unsignedBigInteger('id_user_venda');
            $table->foreign('id_user_venda')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
        
            $table->foreign('ponto_venda')->references('id')->on('localizacao')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};
