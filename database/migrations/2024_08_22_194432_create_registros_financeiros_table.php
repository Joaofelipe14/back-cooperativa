<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosFinanceirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros_financeiros', function (Blueprint $table) {
            $table->id();
            $table->string('periodicidade')->nullable();
            $table->string('transporte')->nullable();
            $table->string('combustivel')->nullable();
            $table->string('embarcacao')->nullable();
            $table->string('energia')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('material')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registros_financeiros');
    }
}
