<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPrecoOnPedidoAndProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->decimal('troco', 10, 2)->change();
            $table->decimal('valor_produtos', 10, 2)->change();
            $table->decimal('taxa_entrega', 10, 2)->change();
            $table->decimal('subtotal', 10, 2)->change();
        });

        Schema::table('produtos', function (Blueprint $table) {
            $table->decimal('preco', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->integer('troco')->change();
            $table->integer('valor_produtos')->change();
            $table->integer('taxa_entrega')->change();
            $table->integer('subtotal')->change();
        });

        Schema::table('produtos', function (Blueprint $table) {
            $table->integer('preco')->change();
        });
    }
}
