<?php

use Illuminate\Database\Seeder;
use App\Categoria;


class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = new Categoria();
        $categorias->nome = 'Salgada';
        $categorias->descricao = 'Pizzas de sabores salgados';
        $categorias->save();

        $categorias = new Categoria();
        $categorias->nome = 'Doce';
        $categorias->descricao = 'Pizzas de sabores doces';
        $categorias->save();

        $categorias = new Categoria();
        $categorias->nome = 'Bebida';
        $categorias->descricao = 'Bebidas diversas';
        $categorias->save();



    }
}
