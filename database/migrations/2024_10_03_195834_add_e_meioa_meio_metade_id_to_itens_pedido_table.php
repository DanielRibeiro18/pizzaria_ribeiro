<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEMeioaMeioMetadeIdToItensPedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itens_pedidos', function (Blueprint $table) {
            $table->boolean('eMeioaMeio')->default(false);
            $table->unsignedBigInteger('metadeId')->nullable();
            $table->foreign('metadeId')->references('id')->on('produtos')->cascadeOnDelete();
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
            $table->dropColumn('eMeioaMeio');
            $table->dropColumn('metadeId');
        });
    }
}
