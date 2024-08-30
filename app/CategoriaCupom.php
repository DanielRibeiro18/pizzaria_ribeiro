<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoriaCupom extends Pivot
{
    protected $table = 'categorias_cupom';
}
