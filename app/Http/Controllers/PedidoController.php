<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\Produto;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function adicionaProduto(Request $request, Produto $produto)
    {
        $usuario = auth()->user();

        $pedido = Pedido::where('situacao', null)->where('usuarioId', $usuario->id)->firstOrCreate(['usuarioId' => $usuario->id]);

        $pedido->produtos()->attach($produto, ['quantidade' => 1]);

        session(['itens_carrinho' => $pedido->produtos->count()]);

        return redirect(route('cardapio'));
    }
}
