<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    public function categorias(){
        return $this->belongsToMany(Categoria::class, 'categorias_cupom', 'cupomId', 'categoriaId')
            ->using(CategoriaCupom::class);
    }
}
