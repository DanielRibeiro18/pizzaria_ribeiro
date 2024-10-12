<?php

namespace App\Http\Controllers;

use App\ItemPedido;
use App\Pedido;
use App\Produto;
use App\Usuario;
use Carbon\Carbon;
use http\Env\Request;

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
        $pedidos = Pedido::with('produtos')->whereDate('created_at', $hoje)->where('situacao', 'pendente')->get();

        // Processar dados para o gráfico
        $graficoDados = [];
        foreach ($pedidos as $pedido) {
            foreach ($pedido->produtos as $produto) {
                if (isset($graficoDados[$produto->id])) {
                    $graficoDados[$produto->id]['quantidade'] += 1;

                    if($produto->pivot->eMeioaMeio){
                        if(isset($graficoDados[$produto->pivot->metade->id])){
                            $graficoDados[$produto->pivot->metade->id]['quantidade'] += 1;
                        }
                        else{
                            $graficoDados[$produto->pivot->metade->id] = [
                                'produto' => $produto->pivot->metade->nome,
                                'quantidade' => 1,
                            ];
                        }
                    }

                } else {
                    $graficoDados[$produto->id] = [
                        'produto' => $produto->nome,
                        'quantidade' => 1,
                    ];
                }
            }
        }

        return response()->json(['graficoDados' => array_values($graficoDados)]);
    }

    public function gerarGraficoSemanal()
    {

        $dataInicio = Carbon::today()->copy()->subDays(6); // 7 dias a partir de hoje (inclui hoje)

        // Busca pedidos dos últimos 7 dias com status 'pendente' e os produtos relacionados
        $pedidos = Pedido::with('produtos')
            ->whereBetween('created_at', [$dataInicio, Carbon::tomorrow()->copy()]) // Use copy() para não modificar $hoje
            ->where('situacao', 'pendente')
            ->get();

        // Debug: verifique os pedidos
        // dd($pedidos);

        // Processar dados para o gráfico
        $graficoDados = [];
        foreach ($pedidos as $pedido) {
            foreach ($pedido->produtos as $produto) {
                if (isset($graficoDados[$produto->id])) {
                    $graficoDados[$produto->id]['quantidade'] += 1;

                    if($produto->pivot->eMeioaMeio){
                        if(isset($graficoDados[$produto->pivot->metade->id])){
                            $graficoDados[$produto->pivot->metade->id]['quantidade'] += 1;
                        }
                        else{
                            $graficoDados[$produto->pivot->metade->id] = [
                                'produto' => $produto->pivot->metade->nome,
                                'quantidade' => 1,
                            ];
                        }
                    }

                } else {
                    $graficoDados[$produto->id] = [
                        'produto' => $produto->nome,
                        'quantidade' => 1,
                    ];

                }
            }
        }

        return response()->json(['graficoDados' => array_values($graficoDados)]);
    }

    public function gerarGraficoMensal()
    {

        $dataInicio = Carbon::today()->copy()->subDays(29); // 30 dias a partir de hoje (inclui hoje)

        // Busca pedidos dos últimos 30 dias com status 'pendente' e os produtos relacionados
        $pedidos = Pedido::with('produtos')
            ->whereBetween('created_at', [$dataInicio, Carbon::tomorrow()->copy()]) // Use copy() para não modificar $hoje
            ->where('situacao', 'pendente')
            ->get();

        // Debug: verifique os pedidos
        // dd($pedidos);

        // Processar dados para o gráfico
        $graficoDados = [];
        foreach ($pedidos as $pedido) {
            foreach ($pedido->produtos as $produto) {
                if (isset($graficoDados[$produto->id])) {
                    $graficoDados[$produto->id]['quantidade'] += 1;

                    if($produto->pivot->eMeioaMeio){
                        if(isset($graficoDados[$produto->pivot->metade->id])){
                            $graficoDados[$produto->pivot->metade->id]['quantidade'] += 1;
                        }
                        else{
                            $graficoDados[$produto->pivot->metade->id] = [
                                'produto' => $produto->pivot->metade->nome,
                                'quantidade' => 1,
                            ];
                        }
                    }

                } else {
                    $graficoDados[$produto->id] = [
                        'produto' => $produto->nome,
                        'quantidade' => 1,
                    ];


                }
            }
        }

        return response()->json(['graficoDados' => array_values($graficoDados)]);
    }



}
