<!doctype html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
@foreach($horarios as $horario)
    {{ $horario->dia_semana }}

    <div>
        {{ $horario->hora_abertura }} - {{ $horario->hora_fechamento }}
    </div>

@endforeach
</body>
</html>
