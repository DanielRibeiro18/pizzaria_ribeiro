<?php

namespace App\Http\Controllers;

use App\ItemPedido;
use App\Pedido;
use App\Produto;
use App\Usuario;
use App\Bairro;
use App\Cupom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PedidoController extends Controller
{
    public function adicionaProduto(Request $request, Produto $produto)
    {
        // Obtenha o dia da semana em formato abreviado (ex: 'Tue', 'Wed')
        $dia = now()->format('D');
        $horaAtual = now()->hour;

        // Verifique se o dia está entre terça ('Tue') e domingo ('Sun') e se a hora está entre 18 e 23
        if (!in_array($dia, ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']) || $horaAtual < 18 || $horaAtual >= 23) {
            return redirect(route('cardapio'))->withErrors(['message' => 'O carrinho está disponível apenas de terça-feira a domingo, das 18h às 23h.']);
        }

        $usuario = auth()->user();
        $pedido = Pedido::where('situacao', null)->where('usuarioId', $usuario->id)->firstOrCreate(['usuarioId' => $usuario->id]);

        $pedido->produtos()->save($produto, [
            'adicional1Id' => $request->adicional1Id,
            'adicional2Id' => $request->adicional2Id,
            'observacao' => $request->observacao
        ]);

        session(['itens_carrinho' => $pedido->produtos()->count()]);

        return redirect(route('cardapio'));
    }

    public function removeProduto(Request $request, ItemPedido $produto)
    {
        $usuario = auth()->user();

        $pedido = Pedido::where('situacao', null)->where('usuarioId', $usuario->id)->firstOrCreate(['usuarioId' => $usuario->id]);

//        $pedido->produtos()->detach($produto);
        $produto->delete();

        session(['itens_carrinho' => $totalProdutos = $pedido->produtos->count()]);

        if($totalProdutos == 0){
            return redirect(route('cardapio'));
        }

        return redirect(route('checkout'));
    }

    public function checkout()
    {
        $totalProdutos = session()->get('itens_carrinho');

        if(intval($totalProdutos) == 0){
            return redirect(route('cardapio'));
        }

        $usuario = auth()->user();
        $pedido = Pedido::where('situacao', null)
            ->where('usuarioId', $usuario->id)
            ->firstOrCreate(['usuarioId' => $usuario->id]);

        $produtos = $pedido->produtos;

        $subtotal = $produtos->sum->preco;

        $totalAdicionais = 0;

        foreach($produtos as $produto){
            if($produto->pivot->adicional1 != null){
                $totalAdicionais += $produto->pivot->adicional1->valor;
            }
            if($produto->pivot->adicional2 != null){
                $totalAdicionais += $produto->pivot->adicional2->valor;
            }
        }

        $totalProdutos = 0;

        $dia = now()->format('D');

        if ($pedido->cupom != null && $pedido->cupom->data_valida == $dia) {

            $categorias = $pedido->cupom->categorias->pluck('id')->toArray();

            foreach($produtos as $produto){
                if(in_array($produto->categoria->id, $categorias)){

                    $totalProdutos += $produto->preco - ($produto->preco * ($pedido->cupom->valor / 100));

                } else {
                    $totalProdutos += $produto->preco;
                }

            }

        } else {
            $totalProdutos += $subtotal;
        }

        $totalPreco = $totalProdutos + $totalAdicionais;


        if($pedido->cupom != null){
            $nomeCupom = $pedido->cupom->nome;
            $valorCupom = $pedido->cupom->valor;
            $descCategoria = $pedido->cupom->categorias->first()->descricao;
        } else {
            $nomeCupom = null;
            $valorCupom = null;
            $descCategoria = null;
        }

        // Obtenha todos os bairros
        $bairros = Bairro::all();

        return view('checkout', [
            'produtos' => $produtos,
            'totalPreco' => $subtotal + $totalAdicionais,
            'totalCupom' => $totalPreco,
            'nomeCupom' => $nomeCupom,
            'valorCupom' => $valorCupom,
            'descCategoria' => $descCategoria,
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
