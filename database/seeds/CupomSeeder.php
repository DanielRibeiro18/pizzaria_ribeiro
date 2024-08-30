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
        $cupom->data_valida = 'Tue';
        $cupom->save();

        $cupom = new Cupom();
        $cupom->nome = 'doceribeiro';
        $cupom->valor = '10';
        $cupom->ativo = true;
        $cupom->data_valida = 'Thu';
        $cupom->save();

    }
}
