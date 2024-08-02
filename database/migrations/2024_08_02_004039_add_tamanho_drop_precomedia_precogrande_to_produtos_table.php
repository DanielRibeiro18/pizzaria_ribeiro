<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTamanhoDropPrecomediaPrecograndeToProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->string('tamanho')->nullable();
            $table->dropColumn('precoMedia');
            $table->dropColumn('precoGrande');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('tamanho');
            $table->string('precoMedia')->nullable();
            $table->string('precoGrande')->nullable();
        });
    }
}
