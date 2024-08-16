<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemPedido extends Pivot
{
    public function adicional1(){
        return $this->hasOne(Adicional::class, 'adicional1Id');
    }

    public function adicional2(){
        return $this->hasOne(Adicional::class, 'adicional2Id');
    }

}
