<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remetente_id')->constrained('users');
            $table->foreignId('destinatario_id')->constrained('users');
            $table->text('conteudo');
            $table->boolean('lida')->default(false);
            $table->foreignId('resposta_id')->nullable()->constrained('mensagens');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensagens');
    }
};
