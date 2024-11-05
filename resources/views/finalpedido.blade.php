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

        <span>{{ number_format($produto->preco, 2, ',', '.') }}</span>

        @if($produto->pivot->eMeioaMeio)
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
        <span>{{ $produto->tamanho }}</span>
        <br>
    @endforeach


    <span>Total: {{ number_format($pedido->subtotal, 2, ',', '.') }}</span> <br>
    <span>Taxa de entrega: {{ number_format($pedido->taxa_entrega, 2, ',', '.') }}</span> <br>
    <span>Valor dos produtos: {{ number_format($pedido->subtotal - $pedido->taxa_entrega, 2, ',', '.') }}</span> <br>
    @if($pedido->retirada == true)
        <span>Pagamento somente na retirada!</span>
    @else
        <span>{{ $pedido->endereco }} - {{ $pedido->bairro->nome }}</span> <br>
        <span>Pagamento somente no momento da entrega!</span>
    @endif
    <br>

    @if($pedido->cupomId != null)
        <span>Cupom utilizado: {{ $pedido->cupom->nome }} - {{ $pedido->cupom->valor }}%</span> <br>
    @endif

    <a href="{{ route('index') }}">Retornar a home</a>
</div>
<!-- Menu End -->

@include('components.footer')

</body>
</html>
