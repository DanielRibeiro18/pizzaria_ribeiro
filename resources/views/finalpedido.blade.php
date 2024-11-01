<!DOCTYPE html>
<html lang="pt-br">

@include('components.head', ['title'=>'Pedido finalizado'])

<body>

@include('components.navbar', ['theme'=>'Pedido finalizado!'])

<!-- Menu Start -->
<div class="container-xxl py-5">
    <span>Pedido #{{ $pedido->id }}<br></span>

    @foreach($pedido->produtos as $produto)


        <span>{{ $produto->nome }}</span>
        <span>{{ $produto->categoria->nome }}</span>
        <span>{{ $produto->tamanho }}</span>
        <span>{{ number_format($produto->preco, 2, ',', '.') }}</span>

        @if($produto->pivot->eMeioaMeio)
            <span>{{ $produto->pivot->metade->nome }}</span>
            <span>{{ $produto->pivot->metade->tamanho }}</span>
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
</div>
<!-- Menu End -->

@include('components.footer')

</body>
</html>
