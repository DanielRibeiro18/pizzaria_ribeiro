<?php

namespace App\Http\Controllers;

use App\Despesa;
use App\Pedido;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DespesaController extends Controller
{
    public function list(){

        $despesa = Despesa::all();

        return view('admin.despesas.index', ['despesa' => $despesa]);

    }

    public function registro(Request $request)
    {
        $despesa = new Despesa();
        $despesa->descricao = $request->descricao;
        $despesa->valor = $request->quantidade * $request->valor;
        $despesa->save();

        return redirect(route('despesa.list'));
    }

    public function remover(Request $request, Despesa $despesa)
    {
        $despesa->delete();

        return redirect(route('despesa.list'));
    }

//    public function gerarPdf()
//    {
//        // Busca todas as despesas
//        $despesas = Despesa::all();
//
//        // Verifica se há despesas para incluir no relatório
//        if ($despesas->isEmpty()) {
//            return redirect()->back()->with('error', 'Nenhuma despesa encontrada para gerar o relatório.');
//        }
//
//        // Caminho da logo (ajuste conforme necessário)
//        $logoPath = 'C:/Users/Dan/Documents/Projeto/pizzaria_ribeiro/public/site/img/logo.png';
//
//        // Data e hora de geração do relatório
//        $dataHoraAtual = now()->format('d/m/Y H:i');
//
//        // Gera o conteúdo HTML do relatório
//        $html = '
//    <div style="text-align: center;">
//        <img src="' . $logoPath . '" alt="Logo" style="width: 150px; height: auto; margin-bottom: 20px;">
//        <h1>Relatório de Despesas</h1>
//        <p>Gerado em: ' . $dataHoraAtual . '</p>
//    </div>
//    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left; margin: 0 auto;">
//        <thead>
//            <tr>
//                <th style="text-align: center;">Descrição</th>
//                <th style="text-align: center;">Valor (R$)</th>
//                <th style="text-align: center;">Data</th>
//            </tr>
//        </thead>
//        <tbody>';
//
//        // Preenche a tabela com as despesas
//        foreach ($despesas as $despesa) {
//            $html .= '<tr>';
//            $html .= '<td style="text-align: center;">' . htmlspecialchars($despesa->descricao) . '</td>';
//            $html .= '<td style="text-align: center;">R$ ' . number_format($despesa->valor, 2, ',', '.') . '</td>';
//            $html .= '<td style="text-align: center;">' . $despesa->created_at->format('d/m/Y') . '</td>';
//            $html .= '</tr>';
//        }
//
//        $html .= '</tbody></table>';
//
//        // Gera o PDF usando mPDF
//        $mpdf = new \Mpdf\Mpdf();
//        $mpdf->WriteHTML($html);
//
//        // Output do PDF para download
//        return $mpdf->Output('relatorio_despesas.pdf', 'D');
//    }

    public function gerarPdf(Request $request)
    {
        // Validação dos parâmetros de data
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        // Captura e formata as datas de início e fim
        $dataInicio = Carbon::createFromFormat('Y-m-d', $request->input('data_inicio'))->startOfDay();
        $dataFim = Carbon::createFromFormat('Y-m-d', $request->input('data_fim'))->endOfDay();

        // Busca despesas dentro do intervalo de datas
        $despesas = Despesa::whereBetween('created_at', [$dataInicio, $dataFim])->get();

        // Busca pedidos finalizados dentro do intervalo de datas
        $pedidosFinalizados = Pedido::where('situacao', 'finalizado')
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->get();

        // Verifica se há despesas e pedidos para incluir no relatório
        if ($despesas->isEmpty() && $pedidosFinalizados->isEmpty()) {
            return redirect()->back()->with('error', 'Nenhuma despesa ou pedido finalizado encontrado para o período selecionado.');
        }

        // Caminho da logo (ajuste conforme necessário)
        $logoPath = 'C:/Users/Dan/Documents/Projeto/pizzaria_ribeiro/public/site/img/logo.png';

        // Data e hora de geração do relatório
        $dataHoraAtual = now()->format('d/m/Y H:i');

        // Calcula o total de despesas e o total de pedidos finalizados
        $totalDespesas = $despesas->sum('valor');
        $totalPedidos = $pedidosFinalizados->sum('subtotal');
        $quantidadePedidos = $pedidosFinalizados->count();

        // Calcula o lucro
        $lucro = $totalPedidos - $totalDespesas;

        // Gera o conteúdo HTML do relatório
        $html = '
    <div style="text-align: center;">
        <img src="' . $logoPath . '" alt="Logo" style="width: 150px; height: auto; margin-bottom: 20px;">
        <h1>Relatório de Lucro</h1>
        <p>Período: ' . $dataInicio->format('d/m/Y') . ' a ' . $dataFim->format('d/m/Y') . '</p>
        <p>Gerado em: ' . $dataHoraAtual . '</p>
    </div>
    <h2>Despesas</h2>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left; margin: 0 auto;">
        <thead>
            <tr>
                <th style="text-align: center;">Descrição</th>
                <th style="text-align: center;">Valor (R$)</th>
                <th style="text-align: center;">Data</th>
            </tr>
        </thead>
        <tbody>';

        // Preenche a tabela com as despesas
        foreach ($despesas as $despesa) {
            $html .= '<tr>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($despesa->descricao) . '</td>';
            $html .= '<td style="text-align: center;">R$ ' . number_format($despesa->valor, 2, ',', '.') . '</td>';
            $html .= '<td style="text-align: center;">' . $despesa->created_at->format('d/m/Y') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        // Adiciona a seção de pedidos finalizados
        $html .= '
    <h2>Pedidos Finalizados</h2>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left; margin: 0 auto;">
        <thead>
            <tr>
                <th style="text-align: center;">Quantidade de Pedidos</th>
                <th style="text-align: center;">Total dos Pedidos (R$)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">' . $quantidadePedidos . '</td>
                <td style="text-align: center;">R$ ' . number_format($totalPedidos, 2, ',', '.') . '</td>
            </tr>
        </tbody>
    </table>';

        // Adiciona a seção de lucro em formato de tabela
        $html .= '
    <h2>Lucro</h2>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left; margin: 0 auto;">
        <thead>
            <tr>
                <th style="text-align: center;">Total de Despesas (R$)</th>
                <th style="text-align: center;">Total de Pedidos (R$)</th>
                <th style="text-align: center;">Lucro (R$)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">R$ ' . number_format($totalDespesas, 2, ',', '.') . '</td>
                <td style="text-align: center;">R$ ' . number_format($totalPedidos, 2, ',', '.') . '</td>
                <td style="text-align: center;">R$ ' . number_format($lucro, 2, ',', '.') . '</td>
            </tr>
        </tbody>
    </table>';

        // Gera o PDF usando mPDF
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);

        // Output do PDF para download
        return $mpdf->Output('relatorio_lucro.pdf', 'D');
    }







}
