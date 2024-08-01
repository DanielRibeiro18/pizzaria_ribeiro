<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('forma_pagamento');
            $table->string('situacao');
            $table->string('valor_produtos');
            $table->string('taxa_entrega');
            $table->string('subtotal');
            $table->string('endereco');
            $table->string('referencia');
            $table->unsignedBigInteger('usuarioId');
            $table->foreign('usuarioId')->references('id')->on('usuarios');
            $table->unsignedBigInteger('cupomId')->nullable();
            $table->foreign('cupomId')->references('id')->on('cupoms');
            $table->timestamps();
            $table->string('motivo_cancelamento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
