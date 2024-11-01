<?php

namespace App\Http\Controllers;

use App\Logica;
use Illuminate\Http\Request;

class LogicaController extends Controller
{
    public function update(Request $request){
        $logica = Logica::first();

        $logica->nome = $request->logica;

        $logica->save();

        return redirect(route('produto.list'));
    }
}
