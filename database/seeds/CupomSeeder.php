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
        $cupom->nome = 'ribeiro5';
        $cupom->valor = '5';
        $cupom->ativo = true;
        $cupom->save();

        $cupom = new Cupom();
        $cupom->nome = 'ribeiro10';
        $cupom->valor = '10';
        $cupom->ativo = true;
        $cupom->save();

        $cupom = new Cupom();
        $cupom->nome = 'ribeiro20';
        $cupom->valor = '20';
        $cupom->ativo = true;
        $cupom->save();

    }
}
