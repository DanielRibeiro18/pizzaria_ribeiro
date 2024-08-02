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
        $produto->tamanho = $request->tamanho;
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

    public function index()
    {
        $salgadas = Produto::where('categoriaId', 1)->get();
        $doces = Produto::where('categoriaId', 2)->get();
        $bebidas = Produto::where('categoriaId', 3)->get();

        return view('cardapio', compact('salgadas', 'doces', 'bebidas'));
    }

}
