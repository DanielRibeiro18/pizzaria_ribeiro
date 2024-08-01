<?php

use Illuminate\Database\Seeder;
use App\FormaPagamento;

class FormaPagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $forma = new FormaPagamento();
        $forma->nome = 'Dinheiro';
        $forma->save();

        $forma = new FormaPagamento();
        $forma->nome = 'Cartão';
        $forma->save();

    }
}
