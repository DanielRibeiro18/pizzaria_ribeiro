<?php

use Illuminate\Database\Seeder;
use App\Logica;

class LogicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logica = new Logica();
        $logica->nome = 'Média';
        $logica->save();

    }
}
