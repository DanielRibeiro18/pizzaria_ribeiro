<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public function cupom(){
        return $this->belongsToMany(Cupom::class, 'categorias_cupom', 'categoriaId', 'cupomId')
            ->using(CategoriaCupom::class);
    }

}
