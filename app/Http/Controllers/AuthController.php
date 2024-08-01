<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = Usuario::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->senha, $user->senha)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais estão incorretas!'],
            ]);
        }

        auth()->login($user);

        return redirect(route('index'));

    }

    public function logout()
    {
        auth()->logout();

        return redirect(route('index'));
    }
}
