<!doctype html>
<html lang="pt-br">

@include('components.head', ['title'=>'Entrar'])

<body>
@include('components.navbar', ['theme'=>'Faça seu login']);

<span>Pedido #{{ $pedido->id }}</span>

@foreach($pedido->produtos as $produto)


    <span>{{ $produto->nome }}</span>
    <span>{{ $produto->categoria->nome }}</span>
    <span>{{ $produto->categoria->id }}</span>
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


<span>Subtotal: {{ number_format($pedido->subtotal, 2, ',', '.') }}</span> <br>
<span>Taxa de entrega: {{ number_format($pedido->taxa_entrega, 2, ',', '.') }}</span> <br>
<span>Valor dos produtos: {{ number_format($pedido->subtotal - $pedido->taxa_entrega, 2, ',', '.') }}</span> <br>
<span>{{ $pedido->endereco }}</span> <br>
@if($pedido->cupomId != null)
    <span>{{ $pedido->cupom->nome }} - {{ $pedido->cupom->valor }}%</span> <br>
@endif

<a href="{{ route('index') }}">Retornar a home</a>

<!-- jQuery e Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@include('components.footer');
</body>
</html>
