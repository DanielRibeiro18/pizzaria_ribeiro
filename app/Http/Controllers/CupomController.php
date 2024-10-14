<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use App\Cupom;
use App\Produto;
use App\Pedido;
use Mpdf\Mpdf;

class CupomController extends Controller
{
    public function aplicaCupom(Request $request){

        $usuario = auth()->user();
        $pedido = Pedido::where('situacao', null)
            ->where('usuarioId', $usuario->id)
            ->firstOrCreate(['usuarioId' => $usuario->id]);

        $cupom = Cupom::where('nome', $request->cupom)->first();

        if ($cupom == null){
            return redirect(route('checkout'))->with(['Fail', 'Cupom não encontrado!']);
        }

        $pedido->cupomId = $cupom->id;

        $pedido->save();

        return redirect(route('checkout'))->with(['Success', 'Cupom aplicado com sucesso!']);

    }

    public function registro(Request $request)
    {
        // Cria um novo cupom
        $cupom = new Cupom();
        $cupom->nome = $request->nome;
        $cupom->valor = $request->valor;
        $cupom->ativo = true;
        $cupom->data_valida = $request->data_valida;
        $cupom->save(); // Salva o cupom primeiro

        // Associa a categoria ao cupom na tabela pivô
        $cupom->categorias()->attach($request->categoriacupom);

        // Redireciona para a lista de cupons
        return redirect(route('cupom.list'));
    }


    public function list(Request $request)
    {
        // Recupera todos os cupons com suas categorias associadas
        $cupom = Cupom::with('categorias')->get();

        // Recupera todas as categorias, excluindo aquelas com nome 'Bebida'
        $categorias = Categoria::where('nome', '!=', 'Bebida')->get();

        // Mapear os dias válidos
        $dias = [
            'Sun' => 'Domingo',
            'Mon' => 'Segunda-feira',
            'Tue' => 'Terça-feira',
            'Wed' => 'Quarta-feira',
            'Thu' => 'Quinta-feira',
            'Fri' => 'Sexta-feira',
            'Sat' => 'Sábado'
        ];

        // Converter os dias válidos para todos os cupons
        foreach ($cupom as $c) {
            $c->data_valida = $dias[$c->data_valida] ?? $c->data_valida;
        }

        // Passa a coleção de cupons e categorias para a view
        return view('admin.cupons.index', ['cupom' => $cupom, 'categorias' => $categorias]);
    }




    public function remover(Request $request, Cupom $cupom)
    {
        $cupom->delete();

        return redirect(route('cupom.list'));
    }

    public function edit(Request $request, Cupom $cupom)
    {
        // Carregar as categorias associadas ao cupom
        $cupom->load('categorias');

        // Carregar todas as categorias disponíveis
        $categorias = Categoria::all();

        return view('admin.cupons.edit', [
            'cupom' => $cupom,
            'categorias' => $categorias
        ]);
    }


    public function update(Request $request, Cupom $cupom)
    {
        // Atualiza os dados do cupom
        $cupom->nome = $request->nome;
        $cupom->valor = $request->valor;

        // Verifica se o checkbox 'ativo' foi marcado e atribui o valor booleano
        $cupom->ativo = $request->has('ativo') ? true : false;

        // Atualiza a data válida
        $cupom->data_valida = $request->data_valida;

        // Salva as alterações
        $cupom->save();

        // Atualiza a associação de categorias, removendo as existentes e adicionando as novas
        $cupom->categorias()->sync($request->categoriacupom);

        // Redireciona para a lista de cupons
        return redirect(route('cupom.list'));
    }

    public function gerarPdf()
    {
        // Busca todos os cupons com suas categorias associadas
        $cupons = Cupom::with('categorias')->get();

        // Verifica se há cupons para incluir no relatório
        if ($cupons->isEmpty()) {
            return redirect()->back()->with('error', 'Nenhum cupom encontrado para gerar o relatório.');
        }

        // Caminho da logo (ajuste conforme necessário)
        $logoPath = 'C:/Users/Dan/Documents/Projeto/pizzaria_ribeiro/public/site/img/logo.png';

        // Gera o conteúdo HTML do relatório
        $html = '
    <div style="text-align: center;">
        <img src="' . $logoPath . '" alt="Logo" style="width: 150px; height: auto; margin-bottom: 20px;">
        <h1>Relatório de Cupons</h1>
    </div>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left; margin: 0 auto;">
        <thead>
            <tr>
                <th style="text-align: center;">Nome</th>
                <th style="text-align: center;">Valor (%)</th>
                <th style="text-align: center;">Categoria</th>
                <th style="text-align: center;">Data Válida</th>
                <th style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>';

        // Preenche a tabela com os dados dos cupons
        foreach ($cupons as $cupom) {
            $html .= '<tr>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($cupom->nome) . '</td>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($cupom->valor) . '%</td>';

            // Exibe as categorias associadas
            $categoriasDescricao = $cupom->categorias->pluck('descricao')->implode(', ');
            $html .= '<td style="text-align: center;">' . $categoriasDescricao . '</td>';

            // Exibe a data válida (convertida para o formato de dia da semana)
            $dataValida = $this->getDiaDaSemana($cupom->data_valida);
            $html .= '<td style="text-align: center;">' . $dataValida . '</td>';

            // Exibe o status (Ativo ou Inativo)
            $status = $cupom->ativo ? 'Ativo' : 'Inativo';
            $html .= '<td style="text-align: center;">' . $status . '</td>';

            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        // Gera o PDF usando mPDF
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);

        // Output do PDF para download
        return $mpdf->Output('relatorio_cupons.pdf', 'D'); // 'D' para forçar download
    }

// Função para converter o código de data para o nome do dia
    private function getDiaDaSemana($codigo)
    {
        switch ($codigo) {
            case 'Sun': return 'Domingo';
            case 'Mon': return 'Segunda-feira';
            case 'Tue': return 'Terça-feira';
            case 'Wed': return 'Quarta-feira';
            case 'Thu': return 'Quinta-feira';
            case 'Fri': return 'Sexta-feira';
            case 'Sat': return 'Sábado';
            default: return $codigo;
        }
    }



}
