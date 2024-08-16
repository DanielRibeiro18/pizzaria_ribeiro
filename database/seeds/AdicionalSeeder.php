<?php

use Illuminate\Database\Seeder;
use App\Adicional;

class AdicionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adicional = new Adicional();
        $adicional->nome = 'Mussarela extra';
        $adicional->valor = 3.50;
        $adicional->save();

        $adicional = new Adicional();
        $adicional->nome = 'Pepperoni';
        $adicional->valor = 4.50;
        $adicional->save();

        $adicional = new Adicional();
        $adicional->nome = 'Bacon';
        $adicional->valor = 4.00;
        $adicional->save();

        $adicional = new Adicional();
        $adicional->nome = 'Calabresa';
        $adicional->valor = 3.50;
        $adicional->save();

        $adicional = new Adicional();
        $adicional->nome = 'Champignon';
        $adicional->valor = 4.00;
        $adicional->save();

        $adicional = new Adicional();
        $adicional->nome = 'Tomate seco';
        $adicional->valor = 4.50;
        $adicional->save();

        $adicional = new Adicional();
        $adicional->nome = 'Azeitona';
        $adicional->valor = 3.00;
        $adicional->save();

        $adicional = new Adicional();
        $adicional->nome = 'Milho';
        $adicional->valor = 2.50;
        $adicional->save();

        $adicional = new Adicional();
        $adicional->nome = 'Cebola roxa';
        $adicional->valor = 2.50;
        $adicional->save();

        $adicional = new Adicional();
        $adicional->nome = 'Catupiry';
        $adicional->valor = 4.00;
        $adicional->save();
    }
}
