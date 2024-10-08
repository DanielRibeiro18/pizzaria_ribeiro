<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public function categoria(){
        return $this->belongsTo(Categoria::class, 'categoriaId');
    }

    public function pedidos(){
        return $this->belongsToMany(Pedido::class, 'itens_pedidos', 'produtoId', 'pedidoId')
            ->using(ItemPedido::class);
    }

}
