<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItensPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedidoId')->nullable();
            $table->foreign('pedidoId')->references('id')->on('pedidos')->cascadeOnDelete();
            $table->unsignedBigInteger('produtoId')->nullable();
            $table->foreign('produtoId')->references('id')->on('produtos')->cascadeOnDelete();
            $table->integer('quantidade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itens_pedidos');
    }
}
