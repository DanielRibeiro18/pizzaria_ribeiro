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
    <h1>Pedido finalizado com sucesso!</h1>

    <span>Subtotal: {{ $pedido->subtotal }}</span> <br>
    <span>Taxa de entrega: {{ $pedido->taxa_entrega }}</span> <br>
    <span>{{ $pedido->valor_produtos }}</span> <br>
    <span>{{ $pedido->endereco }}</span> <br>

    <a href="{{ route('index') }}">Retornar a home</a>
</body>
</html>
