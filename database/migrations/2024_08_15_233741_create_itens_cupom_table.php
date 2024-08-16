<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItensCupomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_cupom', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produtoId')->nullable();
            $table->foreign('produtoId')->references('id')->on('produtos')->cascadeOnDelete();
            $table->unsignedBigInteger('cupomId')->nullable();
            $table->foreign('cupomId')->references('id')->on('cupoms')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itens_cupom');
    }
}
