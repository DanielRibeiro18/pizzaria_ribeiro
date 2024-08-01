<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function registro(Request $request)
    {
//        $usuario = Usuario::create($request->all());
        $emailexiste = Usuario::where('email', $request->email)->count();
        if ($emailexiste >= 1){
            return redirect(route('registro'))->with('Erro', 'Email já existente!');
        }
        $usuario = new Usuario();
        $usuario->nome = $request->nome;
        $usuario->telefone = $request->telefone;
        $usuario->cpf = $request->cpf;
        $usuario->email = $request->email;
        $usuario->senha = Hash::make($request->senha);
        $usuario->save();

        auth()->login($usuario);
        return redirect(route('index'));
    }

}
