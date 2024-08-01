<?php

use Illuminate\Database\Seeder;
use App\Bairro;

class BairroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bairros = new Bairro();
        $bairros->nome = 'Centro';
        $bairros->slug = 'centro';
        $bairros->cidade = 'Tremembé';
        $bairros->valor_entrega = '1000';
        $bairros->save();

        $bairros = new Bairro();
        $bairros->nome = 'Jardim Santana';
        $bairros->slug = 'jardim-santana';
        $bairros->cidade = 'Tremembé';
        $bairros->valor_entrega = '2000';
        $bairros->save();

        $bairros = new Bairro();
        $bairros->nome = 'Jardim dos Eucaliptos';
        $bairros->slug = 'jardim-dos-eucaliptos';
        $bairros->cidade = 'Tremembé';
        $bairros->valor_entrega = '2000';
        $bairros->save();
    }
}
