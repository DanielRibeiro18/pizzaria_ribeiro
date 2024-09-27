<?php

namespace App\Http\Controllers;

use App\Adicional;
use App\Categoria;
use App\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function cadastro(Request $request)
    {

        // Verificar se a categoria selecionada é bebida (ID 3)
        if ($request->categoria == 3) {
            // Inserção única para bebida
            $produtobebida = new Produto();

            $produtobebida->nome = $request->nome;
            $produtobebida->preco = $request->precobebida; // Preço da bebida
            $produtobebida->tamanho = null; // Tamanho vazio para bebida
            $produtobebida->descricao = $request->descricao;
            $produtobebida->ativo = true;

            // Processamento da imagem, se houver
            if ($request->hasFile('img') && $request->file('img')->isValid()) {
                $requestImage = $request->img;
                $extension = $requestImage->extension();
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
                $requestImage->move(public_path('site/img/produto'), $imageName);
                $produtobebida->img = $imageName;
            }

            $produtobebida->categoriaId = $request->categoria;
            $produtobebida->save(); // Salvar o produto de bebida

        } else {
            // Primeira inserção com tamanho "Média"
            $produtom = new Produto();

            $produtom->nome = $request->nome;
            $produtom->preco = $request->precomedia; // Preço da média
            $produtom->tamanho = 'Média'; // Tamanho definido como "Média"
            $produtom->descricao = $request->descricao;
            $produtom->ativo = true;

            // Processamento da imagem, se houver
            if ($request->hasFile('img') && $request->file('img')->isValid()) {
                $requestImage = $request->img;
                $extension = $requestImage->extension();
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
                $requestImage->move(public_path('site/img/produto'), $imageName);
                $produtom->img = $imageName;
            }

            $produtom->categoriaId = $request->categoria;
            $produtom->save(); // Salvar o produto com tamanho "Média"

            // Segunda inserção com tamanho "Grande"
            $produtog = new Produto();

            $produtog->nome = $request->nome;
            $produtog->preco = $request->precogrande; // Preço da grande
            $produtog->tamanho = 'Grande'; // Tamanho definido como "Grande"
            $produtog->descricao = $request->descricao;
            $produtog->ativo = true;

            // Usar a mesma imagem da primeira inserção, se houver
            if (isset($imageName)) {
                $produtog->img = $imageName;
            }

            $produtog->categoriaId = $request->categoria;
            $produtog->save(); // Salvar o produto com tamanho "Grande"
        }

        return redirect(route('produto'))->with('success', 'Produto criado com sucesso!');

    }

    public function create(Request $request)
    {

        $categorias = Categoria::all();
        return view('produto', ['categorias' => $categorias]);

    }

    public function index()
    {
        $salgmedia = Produto::where('tamanho', 'media')->where('categoriaId', 1)->get();
        $salggrande = Produto::where('tamanho', 'grande')->where('categoriaId', 1)->get();
        $docemedia = Produto::where('tamanho', 'media')->where('categoriaId', 2)->get();
        $docegrande = Produto::where('tamanho', 'grande')->where('categoriaId', 2)->get();
        $bebidas = Produto::where('tamanho', null)->where('categoriaId', 3)->get();
        $adicional = Adicional::all();

        return view('cardapio', compact('salgmedia', 'salggrande', 'docemedia', 'docegrande', 'bebidas', 'adicional'));
    }

}
