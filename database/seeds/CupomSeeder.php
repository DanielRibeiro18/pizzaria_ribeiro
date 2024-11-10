<?php

use Illuminate\Database\Seeder;
use App\Cupom;

class CupomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cupom = new Cupom();
        $cupom->nome = 'salgribeiro';
        $cupom->valor = '10';
        $cupom->ativo = true;
        $cupom->data_valida = 'Mon';
        $cupom->quant_usos = 10;
        $cupom->save();

        $cupom = new Cupom();
        $cupom->nome = 'doceribeiro';
        $cupom->valor = '10';
        $cupom->ativo = true;
        $cupom->data_valida = 'Tue';
        $cupom->quant_usos = 10;
        $cupom->save();

        $cupom = new Cupom();
        $cupom->nome = 'doce5';
        $cupom->valor = '5';
        $cupom->ativo = true;
        $cupom->data_valida = 'Mon';
        $cupom->quant_usos = 10;
        $cupom->save();

        $cupom = new Cupom();
        $cupom->nome = 'salg5';
        $cupom->valor = '5';
        $cupom->ativo = true;
        $cupom->data_valida = 'Sat';
        $cupom->quant_usos = 10;
        $cupom->save();

    }
}
