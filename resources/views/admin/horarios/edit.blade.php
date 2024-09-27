<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<div class="form-container">
    <form action="{{route('horario.update', $horario->id)}}" method="POST">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <label for="nome">Dia: {{ $horario->dia_semana }}</label>

        <label for="hora_abertura">Horário de abertura:</label>
        <input type="text" id="hora_abertura" name="hora_abertura" value="{{ $horario->hora_abertura }}" required>

        <label for="hora_fechamento">Horário de fechamento:</label>
        <input type="text" id="hora_fechamento" name="hora_fechamento" value="{{ $horario->hora_fechamento }}" required>

        <button type="submit">Editar horário</button>
    </form>
</div>
