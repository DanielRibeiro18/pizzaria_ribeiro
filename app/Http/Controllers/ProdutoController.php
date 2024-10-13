<?php

namespace App\Http\Controllers;

use App\Adicional;
use App\Categoria;
use App\Produto;
use Mpdf\Mpdf;
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

        return redirect(route('produto.list'))->with('success', 'Produto criado com sucesso!');

    }

    public function create(Request $request)
    {
        $produtos = Produto::all();
        $categorias = Categoria::all();
        return view('admin.produtos.index' , ['categorias' => $categorias], ['produtos' => $produtos]);

    }

    public function edit(Request $request, Produto $produto){
        return view('admin.produtos.edit', ['produto' => $produto]);
    }

    public function remove(Request $request, Produto $produto)
    {
        $produto->delete();

        return redirect(route('produto.list'));
    }

    public function update(Request $request, Produto $produto)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
        ]);

        $produto->nome = $request->nome;
        $produto->preco = $request->preco;

        $produto->ativo = $request->has('ativo') ? true : false;

        $produto->save();

        return redirect(route('produto.list'))->with('success', 'Produto atualizado com sucesso!');
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

    public function gerarPdf()
    {
        $produtos = Produto::with('categoria')->whereIn('categoriaId', [1, 2, 3])
            ->orderBy('categoriaId', 'asc')
            ->get();

        // Caminho da logo (ajuste conforme necessário)
        $logoPath = 'C:/Users/Dan/Documents/Projeto/pizzaria_ribeiro/public/site/img/logo.png';

        // Data atual
        $dataAtual = date('d/m/Y H:i');

        // Gera o conteúdo HTML do relatório
        $html = '
<div style="text-align: center;">
    <img src="' . $logoPath . '" alt="Logo" style="width: 150px; height: auto; margin-bottom: 20px;">
    <h1>Relatório de Pedidos</h1>
    <p>Data: ' . $dataAtual . '</p>
</div>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left; margin: 0 auto;">
        <thead>
            <tr>
                <th style="text-align: center;">Nome</th>
                <th style="text-align: center;">Tamanho</th>
                <th style="text-align: center;">Preço</th>
                <th style="text-align: center;">Categoria</th>
                <th style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($produtos as $produto) {
            $html .= '<tr>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($produto->nome) . '</td>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($produto->tamanho) . '</td>';
            $html .= '<td style="text-align: center;">R$ ' . number_format($produto->preco, 2, ',', '.') . '</td>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($produto->categoria->nome) . '</td>';
            $html .= '<td style="text-align: center;">' . ($produto->ativo ? 'Ativo' : 'Inativo') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('relatorio_produtos.pdf', 'D');
    }



}
