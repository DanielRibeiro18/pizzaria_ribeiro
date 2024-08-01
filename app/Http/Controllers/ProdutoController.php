<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function cadastro(Request $request){

        $produto = new Produto();

        $produto->nome = $request->nome;
        $produto->preco = $request->preco;
        $produto->precoMedia = $request->precoMedia;
        $produto->precoGrande = $request->precoGrande;
        $produto->descricao = $request->descricao;

        if($request->hasFile('img') && $request->file('img')->isValid()){
            $requestImage = $request->img;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('site\img\produto'), $imageName);

            $produto->img = $imageName;

        }

        $produto->categoriaId = $request->categoria;

        $produto->save();

        return redirect(route('produto'));

    }

    public function create(Request $request){

        $categorias = Categoria::all();
        return view('produto', ['categorias' => $categorias]);

    }

}
