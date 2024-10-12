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

    @foreach($pedido->produtos as $produto)
        <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $produto->img) }}" alt="" style="width: 80px;">
        <span>{{ $produto->nome }}</span>
        <span>{{ number_format($produto->preco, 2, ',', '.') }}</span>

        @if($produto->pivot->eMeioaMeio)
            <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $produto->pivot->metade->img) }}" alt="" style="width: 80px;">
            <span>{{ $produto->pivot->metade->nome }}</span>
            <span>{{ number_format($produto->pivot->metade->preco, 2, ',', '.') }}</span>
        @endif

        @if($produto->pivot->adicional1 != null)
            <span>{{ $produto->pivot->adicional1->nome }}</span>
            <span>{{ number_format($produto->pivot->adicional1->valor, 2, ',', '.') }}</span>
        @endif

        @if($produto->pivot->adicional2 != null)
            <span>{{ $produto->pivot->adicional2->nome }}</span>
            <span>{{ number_format($produto->pivot->adicional2->valor, 2, ',', '.') }}</span>
        @endif

        <span>{{ $produto->pivot->observacao }}</span>
        <br>
    @endforeach


    <span>Subtotal: {{ $pedido->subtotal }}</span> <br>
    <span>Taxa de entrega: {{ $pedido->taxa_entrega }}</span> <br>
    <span>Valor dos produtos: {{ $pedido->valor_produtos }}</span> <br>
    <span>{{ $pedido->endereco }}</span> <br>
    @if($pedido->cupomId != null)
        <span>{{ $pedido->cupom->nome }}</span> <br>
    @endif

    <a href="{{ route('index') }}">Retornar a home</a>
</body>
</html>
