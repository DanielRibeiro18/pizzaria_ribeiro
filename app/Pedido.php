<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public function produtos(){
        return $this->belongsToMany(Produto::class, 'itens_pedidos', 'pedidoId', 'produtoId');
    }

}
