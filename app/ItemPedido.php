<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemPedido extends Pivot
{
    protected $table = 'itens_pedidos';

    public function adicional1(){
        return $this->hasOne(Adicional::class, 'id', 'adicional1Id');
    }

    public function adicional2(){
        return $this->hasOne(Adicional::class, 'id','adicional2Id');
    }

}
