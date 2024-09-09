<?php

use Illuminate\Database\Seeder;
use App\CategoriaCupom;

class CategoriasCupomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $catcupom = new CategoriaCupom();
        $catcupom->categoriaId = '1';
        $catcupom->cupomId = '1';
        $catcupom->save();

        $catcupom = new CategoriaCupom();
        $catcupom->categoriaId = '2';
        $catcupom->cupomId = '2';
        $catcupom->save();

        $catcupom = new CategoriaCupom();
        $catcupom->categoriaId = '2';
        $catcupom->cupomId = '3';
        $catcupom->save();

        $catcupom = new CategoriaCupom();
        $catcupom->categoriaId = '1';
        $catcupom->cupomId = '4';
        $catcupom->save();
    }
}
