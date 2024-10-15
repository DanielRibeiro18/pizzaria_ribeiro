<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bairro;

class BairroController extends Controller
{
    public function list(Request $request)
    {
        // Recupera todos os cupons com suas categorias associadas
        $bairro = Bairro::all();

        // Passa a coleção de cupons e categorias para a view
        return view('admin.bairros.index', ['bairro' => $bairro]);
    }

    public function registro(Request $request)
    {
        $bairro = new Bairro();
        $bairro->nome = $request->bairro;
        $bairro->valor_entrega = $request->valor_entrega;
        $bairro->cidade = $request->cidade;

        // Gerando o slug a partir do nome do bairro
        $bairro->slug = $this->gerarSlug($request->bairro);
        $bairro->save();

        return redirect(route('bairro.list'));
    }

    private function gerarSlug($nome)
    {
        // Substituir caracteres especiais manualmente
        $slug = strtr(utf8_decode($nome), utf8_decode('áàãâäéèêëíìîïóòôõöúùûüçñÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÔÕÖÚÙÛÜÇÑ'), 'aaaaaeeeeiiiiooooouuuucnAAAAAEEEEIIIIOOOOOUUUUCN');

        // Converter para minúsculas
        $slug = strtolower($slug);

        // Substituir qualquer espaço ou sequência de caracteres não alfanuméricos por hífen
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);

        // Remover hífens extras no início ou no final
        return trim($slug, '-');
    }

    public function remover(Request $request, Bairro $bairro)
    {
        $bairro->delete();

        return redirect(route('bairro.list'));
    }

    public function gerarPdf()
    {
        $bairros = Bairro::orderBy('nome', 'asc')->get();

        // Caminho da logo (ajuste conforme necessário)
        $logoPath = 'C:/Users/Dan/Documents/Projeto/pizzaria_ribeiro/public/site/img/logo.png';

        // Data atual
        $dataAtual = date('d/m/Y H:i');

        // Gera o conteúdo HTML do relatório
        $html = '
<div style="text-align: center;">
    <img src="' . $logoPath . '" alt="Logo" style="width: 150px; height: auto; margin-bottom: 20px;">
    <h1>Relatório de Bairros</h1>
    <p>Data: ' . $dataAtual . '</p>
</div>
<table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left; margin: 0 auto;">
    <thead>
        <tr>
            <th style="text-align: center;">Nome</th>
            <th style="text-align: center;">Slug</th>
            <th style="text-align: center;">Cidade</th>
            <th style="text-align: center;">Taxa de Entrega</th>
        </tr>
    </thead>
    <tbody>';

        foreach ($bairros as $bairro) {
            $html .= '<tr>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($bairro->nome) . '</td>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($bairro->slug) . '</td>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($bairro->cidade) . '</td>';
            $html .= '<td style="text-align: center;">R$ ' . number_format($bairro->valor_entrega, 2, ',', '.') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('relatorio_bairros.pdf', 'D');
    }




}
