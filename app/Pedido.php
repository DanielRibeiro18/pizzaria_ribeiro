<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public function produtos(){
         return $this->belongsToMany(Produto::class, 'itens_pedidos', 'pedidoId', 'produtoId')
             ->withPivot('id', 'adicional1Id', 'adicional2Id', 'observacao', 'eMeioaMeio', 'metadeId')
             ->using(ItemPedido::class);
    }

    public function cupom()
    {
        return $this->hasOne(Cupom::class, 'id', 'cupomId');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarioId');
    }

    public function bairro()
    {
        return $this->belongsTo(Bairro::class, 'bairroId');
    }
}
