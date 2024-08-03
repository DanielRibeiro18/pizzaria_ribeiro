<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cupom;
use App\Produto;
use App\Pedido;

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
}
