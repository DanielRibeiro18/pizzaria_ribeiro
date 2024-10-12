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
        $lucroDiario = Pedido::whereDate('created_at', $hoje) // Filtra pedidos do dia atual
        ->where('situacao', 'pendente') // Filtra pedidos pendentes
        ->sum('subtotal'); // Soma os subtotais

        // Buscar os dados necessários
        $pedidos = Pedido::with('produtos')->get(); // Carrega os produtos relacionados a cada pedido
        $itensPedido = ItemPedido::all();
        $produtos = Produto::all();
        $usuarios = Usuario::all();

        // Retornar a view com os dados
        return view('admin.index', compact('itensPedido', 'pedidos', 'produtos', 'usuarios', 'lucroDiario'));
    }


}
