<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkAdicionalIdOnItensPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itens_pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('adicional1Id')->nullable();
            $table->foreign('adicional1Id')->references('id')->on('adicionais')->cascadeOnDelete();
            $table->unsignedBigInteger('adicional2Id')->nullable();
            $table->foreign('adicional2Id')->references('id')->on('adicionais')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itens_pedidos', function (Blueprint $table) {
            $table->dropColumn('adicionalId');
        });
    }
}
