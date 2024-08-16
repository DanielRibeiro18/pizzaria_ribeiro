<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\Produto;
use App\Usuario;
use App\Bairro;
use App\Cupom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function adicionaProduto(Request $request, Produto $produto)
    {
        $usuario = auth()->user();

        $pedido = Pedido::where('situacao', null)->where('usuarioId', $usuario->id)->firstOrCreate(['usuarioId' => $usuario->id]);

        $pedido->produtos()->attach($produto, [
            'adicional1Id' => $request->adicional1Id,
            'adicional2Id' => $request->adicional2Id,
            'observacao' => $request->observacao
        ]);

        session(['itens_carrinho' => $pedido->produtos()->count()]);

        return redirect(route('cardapio'));
    }

    public function removeProduto(Request $request, Produto $produto)
    {
        $usuario = auth()->user();

        $pedido = Pedido::where('situacao', null)->where('usuarioId', $usuario->id)->firstOrCreate(['usuarioId' => $usuario->id]);

        $pedido->produtos()->detach($produto);

        session(['itens_carrinho' => $pedido->produtos->count()]);

        return redirect(route('checkout'));
    }

    public function checkout()
    {
        $usuario = auth()->user();
        $pedido = Pedido::where('situacao', null)
            ->where('usuarioId', $usuario->id)
            ->firstOrCreate(['usuarioId' => $usuario->id]);

        $produtos = $pedido->produtos;
        $totalPreco = $produtos->map(function ($produto) {
            return $produto->preco * $produto->pivot->quantidade;
        })->sum();

        if ($pedido->cupom != null) {
            $totalPreco = $totalPreco - (($totalPreco) * ($pedido->cupom->valor / 100));
        }

        // Obtenha todos os bairros
        $bairros = Bairro::all();

        return view('checkout', [
            'produtos' => $produtos,
            'totalPreco' => $totalPreco,
            'bairros' => $bairros
        ]);
    }

    public function finalizar(Request $request)
    {

        $usuario = auth()->user();
        $pedido = Pedido::where('situacao', null)
            ->where('usuarioId', $usuario->id)
            ->firstOrCreate(['usuarioId' => $usuario->id]);

        $pedido->situacao = 'pendente';
        $pedido->taxa_entrega = $request->taxa_entrega;
        $pedido->valor_produtos = $pedido->produtos->sum('preco');
        $pedido->forma_pagamento = $request->forma_pagamento;
        $pedido->troco = $request->troco;
        $pedido->subtotal = $request->subtotal;
        $pedido->endereco = $request->cep . ' - ' . $request->logradouro . ' - ' . $request->numero . ' - ' . $request->complemento;
        $pedido->referencia = $request->referencia;

        $pedido->save();

        session()->put('itens_carrinho', 0);

        return redirect(route('pedido.finalizado', $pedido->id));
    }

    public function finalizaPedido(Pedido $pedido)
    {
        return view('finalpedido', ['pedido' => $pedido]);
    }
}
