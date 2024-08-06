<?php

use Illuminate\Database\Seeder;
use App\Adicionais;

class AdicionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adicional = new Adicionais();
        $adicional->nome = 'Mussarela extra';
        $adicional->valor = 3.50;
        $adicional->save();

        $adicional = new Adicionais();
        $adicional->nome = 'Pepperoni';
        $adicional->valor = 4.50;
        $adicional->save();

        $adicional = new Adicionais();
        $adicional->nome = 'Bacon';
        $adicional->valor = 4.00;
        $adicional->save();

        $adicional = new Adicionais();
        $adicional->nome = 'Calabresa';
        $adicional->valor = 3.50;
        $adicional->save();

        $adicional = new Adicionais();
        $adicional->nome = 'Champignon';
        $adicional->valor = 4.00;
        $adicional->save();

        $adicional = new Adicionais();
        $adicional->nome = 'Tomate seco';
        $adicional->valor = 4.50;
        $adicional->save();

        $adicional = new Adicionais();
        $adicional->nome = 'Azeitona';
        $adicional->valor = 3.00;
        $adicional->save();

        $adicional = new Adicionais();
        $adicional->nome = 'Milho';
        $adicional->valor = 2.50;
        $adicional->save();

        $adicional = new Adicionais();
        $adicional->nome = 'Cebola roxa';
        $adicional->valor = 2.50;
        $adicional->save();

        $adicional = new Adicionais();
        $adicional->nome = 'Catupiry';
        $adicional->valor = 4.00;
        $adicional->save();
    }
}
