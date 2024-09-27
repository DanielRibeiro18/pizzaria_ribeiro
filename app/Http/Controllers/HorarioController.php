<?php

namespace App\Http\Controllers;

use App\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function list(Request $request)
    {
        $horarios = Horario::all();

        return view('admin.horarios.index', ['horarios' => $horarios]);
    }

    public function edit(Request $request, Horario $horario)
    {
        return view('admin.horarios.edit', ['horario' => $horario]);
    }

    public function update(Request $request, Horario $horario)
    {
        $horario->hora_abertura = $request->hora_abertura;
        $horario->hora_fechamento = $request->hora_fechamento;

        $horario->save();

        return redirect(route('horario.list'));
    }
}
