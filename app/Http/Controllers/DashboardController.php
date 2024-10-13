<?php

namespace App\Http\Controllers;

use App\ItemPedido;
use App\Pedido;
use App\Produto;
use App\Usuario;
use Carbon\Carbon;
use http\Env\Request;
use Mpdf\Mpdf;

class DashboardController extends Controller
{

    public function showDashboard()
    {
        // Obtém a data atual
        $hoje = Carbon::today();

        // Calcula o lucro diário
        $lucroDiario = Pedido::whereDate('created_at', $hoje)
            ->where('situacao', 'pendente') // Usando 'pendente' para o lucro
            ->sum('subtotal');

        // Busca pedidos do dia atual com status 'pendente' e os produtos relacionados
        $pedidos = Pedido::with('produtos')->whereDate('created_at', $hoje)->where('situacao', 'pendente')->get();

        // Buscar todos os produtos e outros dados necessários
        $produtos = Produto::all();
        $itensPedido = ItemPedido::all();
        $usuarios = Usuario::all();

        return view('admin.index', compact('itensPedido', 'pedidos', 'produtos', 'usuarios', 'lucroDiario'));
    }

    public function gerarGraficoDiario()
    {
        $hoje = Carbon::today();

        // Busca pedidos do dia atual com status 'pendente' e os produtos relacionados
        $pedidos = Pedido::with('produtos')
            ->whereDate('created_at', $hoje)
            ->where('situacao', 'pendente')
            ->get();

        // Processar dados para o gráfico
        $graficoDados = [];
        foreach ($pedidos as $pedido) {
            foreach ($pedido->produtos as $produto) {
                $nomeProduto = $produto->nome . ' (' . $produto->tamanho . ')'; // Nome + Tamanho

                // Verifica se o produto é 'meio a meio' e se a outra metade foi fornecida
                if ($produto->pivot->eMeioaMeio) {
                    $metade = $produto->pivot->metade;
                    $nomeMetade = $metade->nome . ' (' . $metade->tamanho . ')';

                    // Verifica se a metade do produto já foi registrada no gráfico
                    if (isset($graficoDados[$metade->id])) {
                        $graficoDados[$metade->id]['quantidade'] += 1;
                    } else {
                        $graficoDados[$metade->id] = [
                            'produto' => $nomeMetade,
                            'quantidade' => 1,
                        ];
                    }
                }

                // Lógica para o produto principal
                if (isset($graficoDados[$produto->id])) {
                    $graficoDados[$produto->id]['quantidade'] += 1;
                } else {
                    $graficoDados[$produto->id] = [
                        'produto' => $nomeProduto,
                        'quantidade' => 1,
                    ];
                }
            }
        }

        // Ordena os produtos pela quantidade vendida (maior para menor)
        usort($graficoDados, function ($a, $b) {
            return $b['quantidade'] <=> $a['quantidade'];
        });

        // Retorna os dados do gráfico em formato JSON
        return response()->json(['graficoDados' => array_values($graficoDados)]);
    }



    public function gerarGraficoSemanal()
    {
        $dataInicio = Carbon::today()->copy()->subDays(6); // Últimos 7 dias (incluindo hoje)

        // Busca pedidos dos últimos 7 dias com status 'pendente'
        $pedidos = Pedido::with('produtos')
            ->whereBetween('created_at', [$dataInicio, Carbon::tomorrow()->copy()])
            ->where('situacao', 'pendente')
            ->get();

        // Processar dados para o gráfico
        $graficoDados = [];
        foreach ($pedidos as $pedido) {
            foreach ($pedido->produtos as $produto) {
                $nomeProduto = $produto->nome . ' (' . $produto->tamanho . ')'; // Nome + Tamanho

                // Verifica se o produto é 'meio a meio' e se a outra metade foi fornecida
                if ($produto->pivot->eMeioaMeio) {
                    $metade = $produto->pivot->metade;
                    $nomeMetade = $metade->nome . ' (' . $metade->tamanho . ')';

                    // Verifica se a metade já foi registrada
                    if (isset($graficoDados[$metade->id])) {
                        $graficoDados[$metade->id]['quantidade'] += 1;
                    } else {
                        $graficoDados[$metade->id] = [
                            'produto' => $nomeMetade,
                            'quantidade' => 1,
                        ];
                    }
                }

                // Lógica para o produto principal
                if (isset($graficoDados[$produto->id])) {
                    $graficoDados[$produto->id]['quantidade'] += 1;
                } else {
                    $graficoDados[$produto->id] = [
                        'produto' => $nomeProduto,
                        'quantidade' => 1,
                    ];
                }
            }
        }

        // Ordena os produtos pela quantidade vendida (maior para menor)
        usort($graficoDados, function ($a, $b) {
            return $b['quantidade'] <=> $a['quantidade'];
        });

        // Retorna os dados do gráfico em formato JSON
        return response()->json(['graficoDados' => array_values($graficoDados)]);
    }

    public function gerarGraficoMensal()
    {
        $dataInicio = Carbon::today()->copy()->subDays(29); // Últimos 30 dias (incluindo hoje)

        // Busca pedidos dos últimos 30 dias com status 'pendente'
        $pedidos = Pedido::with('produtos')
            ->whereBetween('created_at', [$dataInicio, Carbon::tomorrow()->copy()])
            ->where('situacao', 'pendente')
            ->get();

        // Processar dados para o gráfico
        $graficoDados = [];
        foreach ($pedidos as $pedido) {
            foreach ($pedido->produtos as $produto) {
                $nomeProduto = $produto->nome . ' (' . $produto->tamanho . ')'; // Nome + Tamanho

                // Verifica se o produto é 'meio a meio' e se a outra metade foi fornecida
                if ($produto->pivot->eMeioaMeio) {
                    $metade = $produto->pivot->metade;
                    $nomeMetade = $metade->nome . ' (' . $metade->tamanho . ')';

                    // Verifica se a metade já foi registrada
                    if (isset($graficoDados[$metade->id])) {
                        $graficoDados[$metade->id]['quantidade'] += 1;
                    } else {
                        $graficoDados[$metade->id] = [
                            'produto' => $nomeMetade,
                            'quantidade' => 1,
                        ];
                    }
                }

                // Lógica para o produto principal
                if (isset($graficoDados[$produto->id])) {
                    $graficoDados[$produto->id]['quantidade'] += 1;
                } else {
                    $graficoDados[$produto->id] = [
                        'produto' => $nomeProduto,
                        'quantidade' => 1,
                    ];
                }
            }
        }

        // Ordena os produtos pela quantidade vendida (maior para menor)
        usort($graficoDados, function ($a, $b) {
            return $b['quantidade'] <=> $a['quantidade'];
        });

        // Retorna os dados do gráfico em formato JSON
        return response()->json(['graficoDados' => array_values($graficoDados)]);
    }


    public function gerarPdf($tipo)
    {
        // Determina o período conforme o tipo de relatório
        $hoje = Carbon::today();
        $dataInicio = null;
        $periodo = '';

        if ($tipo === 'diario') {
            $dataInicio = $hoje;
            $periodo = $hoje->format('d/m/Y');
        } elseif ($tipo === 'semanal') {
            $dataInicio = Carbon::today()->subDays(6);
            $periodo = 'de ' . $dataInicio->format('d/m/Y') . ' até ' . $hoje->format('d/m/Y');
        } elseif ($tipo === 'mensal') {
            $dataInicio = Carbon::today()->subDays(29);
            $periodo = 'de ' . $dataInicio->format('d/m/Y') . ' até ' . $hoje->format('d/m/Y');
        }

        // Busca pedidos com base no tipo de relatório
        $pedidos = Pedido::with('produtos')
            ->whereBetween('created_at', [$dataInicio, $hoje->copy()->addDay()])
            ->where('situacao', 'pendente')
            ->get();

        // Processar dados para o relatório PDF
        $graficoDados = [];
        foreach ($pedidos as $pedido) {
            foreach ($pedido->produtos as $produto) {
                $nomeProduto = $produto->nome . ' (' . $produto->tamanho . ')'; // Nome + Tamanho

                // Verifica se o produto é 'meio a meio' e se a outra metade foi fornecida
                if ($produto->pivot->eMeioaMeio) {
                    $metade = $produto->pivot->metade;
                    $nomeMetade = $metade->nome . ' (' . $metade->tamanho . ')';

                    // Verifica se a metade já foi registrada
                    if (isset($graficoDados[$metade->id])) {
                        $graficoDados[$metade->id]['quantidade'] += 1;
                    } else {
                        $graficoDados[$metade->id] = [
                            'produto' => $nomeMetade,
                            'quantidade' => 1,
                        ];
                    }
                }

                // Lógica para o produto principal
                if (isset($graficoDados[$produto->id])) {
                    $graficoDados[$produto->id]['quantidade'] += 1;
                } else {
                    $graficoDados[$produto->id] = [
                        'produto' => $nomeProduto,
                        'quantidade' => 1,
                    ];
                }
            }
        }

        // Ordena os produtos pela quantidade vendida (maior para menor)
        usort($graficoDados, function ($a, $b) {
            return $b['quantidade'] <=> $a['quantidade'];
        });

        // Caminho da logo (ajustar para o caminho real no sistema)
        $logoPath = 'C:/Users/Dan/Documents/Projeto/pizzaria_ribeiro/public/site/img/logo.png';

        // Gera o conteúdo HTML do PDF com centralização e logo
        $html = '
    <div style="text-align: center;">
        <img src="' . $logoPath . '" alt="Logo" style="width: 150px; height: auto;">
        <h1>Relatório de Vendas</h1>
        <p>Período: ' . $periodo . '</p>
        <table border="1" cellspacing="0" cellpadding="5" align="center" style="width: 80%; margin: 0 auto;">
            <thead>
                <tr>
                    <th style="text-align: center;">Produto</th>
                    <th style="text-align: center;">Quantidade Vendida</th>
                </tr>
            </thead>
            <tbody>';

        // Preencher os dados dos produtos vendidos
        foreach ($graficoDados as $item) {
            $html .= '<tr>
                <td style="text-align: center;">' . $item['produto'] . '</td>
                <td style="text-align: center;">' . $item['quantidade'] . '</td>
              </tr>';
        }

        $html .= '</tbody></table></div>';

        // Usar mPDF para gerar o PDF
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('relatorio_vendas_' . $tipo . '.pdf', 'D'); // 'D' para download direto
    }


}
