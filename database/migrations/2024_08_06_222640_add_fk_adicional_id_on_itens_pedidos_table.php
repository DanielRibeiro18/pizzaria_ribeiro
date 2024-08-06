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
            $table->unsignedBigInteger('adicionalId')->nullable();
            $table->foreign('adicionalId')->references('id')->on('adicionais')->cascadeOnDelete();
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
