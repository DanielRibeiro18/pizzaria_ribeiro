<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public function produtos(){
         return $this->belongsToMany(Produto::class, 'itens_pedidos', 'pedidoId', 'produtoId')->withPivot('adicional1Id', 'adicional2Id', 'observacao')->using(ItemPedido::class);
    }

    public function cupom()
    {
        return $this->hasOne(Cupom::class, 'id', 'cupomId');
    }

}
