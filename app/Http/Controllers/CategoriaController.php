<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class CategoriaController extends Controller
{
    public function list(){

        $categorias = Categoria::all();

        return view('admin.categorias.index', ['categoria' => $categorias]);

    }

    public function registro(Request $request)
    {
        $categoria = new Categoria();
        $categoria->nome = $request->nome;
        $categoria->descricao = $request->descricao;
        $categoria->save();

        return redirect(route('categoria.list'));
    }

    public function remover(Request $request, Categoria $categoria)
    {
        $categoria->delete();

        return redirect(route('categoria.list'));
    }

    public function edit(Request $request, Categoria $categoria)
    {
        return view('admin.categorias.edit', ['categoria' => $categoria]);
    }

    public function update(Request $request, Categoria $categoria)
    {

        $categoria->nome = $request->nome;
        $categoria->descricao = $request->descricao;

        $categoria->save();

        return redirect(route('categoria.list'));
    }

    public function gerarPdf()
    {
        // Busca todas as categorias
        $categorias = Categoria::all(); // Ajuste o modelo conforme necessário

        // Verifica se há categorias para incluir no relatório
        if ($categorias->isEmpty()) {
            return redirect()->back()->with('error', 'Nenhuma categoria encontrada para gerar o relatório.');
        }

        // Caminho da logo (ajuste conforme necessário)
        $logoPath = 'C:/Users/Dan/Documents/Projeto/pizzaria_ribeiro/public/site/img/logo.png';

        // Gera o conteúdo HTML do relatório
        $html = '
    <div style="text-align: center;">
        <img src="' . $logoPath . '" alt="Logo" style="width: 150px; height: auto; margin-bottom: 20px;">
        <h1>Relatório de Categorias</h1>
    </div>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left; margin: 0 auto;">
        <thead>
            <tr>
                <th style="text-align: center;">Nome</th>
                <th style="text-align: center;">Descrição</th>
            </tr>
        </thead>
        <tbody>';

        // Preenche a tabela com as categorias
        foreach ($categorias as $categoria) {
            $html .= '<tr>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($categoria->nome) . '</td>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($categoria->descricao) . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        // Gera o PDF usando mPDF
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);

        // Output do PDF para download
        return $mpdf->Output('relatorio_categorias.pdf', 'D'); // 'D' para forçar download
    }


}
