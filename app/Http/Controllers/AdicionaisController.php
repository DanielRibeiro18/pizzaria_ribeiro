<?php

namespace App\Http\Controllers;

use App\Adicional;
use App\Usuario;
use Mpdf\Mpdf;
use Illuminate\Http\Request;

class AdicionaisController extends Controller
{
    public function store(Request $request, Adicional $adicional){

        $adicional->nome = $request->nome;
        $adicional->valor = $request->valor;

        $adicional->save();

        return redirect(route('adicional.list'))->with('Success', 'Adicional criado com sucesso!');
    }

    public function list(Request $request){
        $adicionais = Adicional::all();

        return view('admin.produtos.adicionais.index', ['adicionais' => $adicionais]);
    }

    public function delete(Request $request, Adicional $adicional)
    {
        $adicional->delete();

        return redirect(route('adicional.list'));
    }

    public function gerarPdf()
    {
        // Busca todos os adicionais
        $adicionais = Adicional::all(); // Ajuste o modelo conforme o que você está usando

        // Verifica se há adicionais para incluir no relatório
        if ($adicionais->isEmpty()) {
            return redirect()->back()->with('error', 'Nenhum adicional encontrado para gerar o relatório.');
        }

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
                <th style="text-align: center;">Preço</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($adicionais as $adicional) {
            $html .= '<tr>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($adicional->nome) . '</td>'; // Centraliza o texto
            $html .= '<td style="text-align: center;">' . htmlspecialchars($adicional->valor) . '</td>'; // Centraliza o texto
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        // Gera o PDF usando mPDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        // Output do PDF para download
        return $mpdf->Output('relatorio_adicionais.pdf', 'D'); // 'D' para forçar download
    }
}
