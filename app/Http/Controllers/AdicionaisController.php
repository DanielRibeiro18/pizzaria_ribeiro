<?php

namespace App\Http\Controllers;

use App\Adicionais;
use App\Usuario;
use Illuminate\Http\Request;

class AdicionaisController extends Controller
{
    public function store(Request $request, Adicionais $adicional){

        $adicional->nome = $request->nome;
        $adicional->valor = $request->valor;

        $adicional->save();

        return redirect(route('adicional.list'))->with('Success', 'Adicional criado com sucesso!');
    }

    public function list(Request $request){
        $adicionais = Adicionais::all();

        return view('admin.produtos.adicionais.index', ['adicionais' => $adicionais]);
    }

    public function delete(Request $request, Adicionais $adicional)
    {
        $adicional->delete();

        return redirect(route('adicional.list'));
    }
}
