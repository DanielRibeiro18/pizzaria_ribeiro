<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTableItensCupomAddCategoriasCupomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias_cupom', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoriaId')->nullable();
            $table->foreign('categoriaId')->references('id')->on('categorias')->cascadeOnDelete();
            $table->unsignedBigInteger('cupomId')->nullable();
            $table->foreign('cupomId')->references('id')->on('cupoms')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::dropIfExists('itens_cupom');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorias_cupom');

        Schema::create('itens_cupom', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produtoId')->nullable();
            $table->foreign('produtoId')->references('id')->on('produtos')->cascadeOnDelete();
            $table->unsignedBigInteger('cupomId')->nullable();
            $table->foreign('cupomId')->references('id')->on('cupoms')->cascadeOnDelete();
        });
    }
}
