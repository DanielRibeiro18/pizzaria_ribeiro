<!DOCTYPE html>
<html lang="pt-br">

@include('components.head', ['title'=>'Pedido finalizado'])

<body>

@include('components.navbar', ['theme'=>'Pedido finalizado!'])

<!-- Menu Start -->
<div class="container-xxl py-5">
    <div class="finalizacao-pedido">
        <h1 class="numero-pedido">Pedido #{{ $pedido->id }}</h1>

        <table class="tabela-produtos">
            <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Metade</th>
                <th>Adicional 1</th>
                <th>Adicional 2</th>
                <th>Observação</th>
                <th>Tamanho</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pedido->produtos as $produto)
                <tr>
                    <td>{{ $produto->nome }}</td>
                    <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                    <td>
                        @if($produto->pivot->eMeioaMeio)
                            {{ $produto->pivot->metade->nome }} - R$ {{ number_format($produto->pivot->metade->preco, 2, ',', '.') }}
                        @endif
                    </td>
                    <td>
                        @if($produto->pivot->adicional1 != null)
                            {{ $produto->pivot->adicional1->nome }} - R$ {{ number_format($produto->pivot->adicional1->valor, 2, ',', '.') }}
                        @endif
                    </td>
                    <td>
                        @if($produto->pivot->adicional2 != null)
                            {{ $produto->pivot->adicional2->nome }} - R$ {{ number_format($produto->pivot->adicional2->valor, 2, ',', '.') }}
                        @endif
                    </td>
                    <td>{{ $produto->pivot->observacao }}</td>
                    <td>{{ $produto->tamanho }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="resumo-pedido">
            <p><strong>Total:</strong> R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}</p>
            <p hidden><strong>Valor dos produtos:</strong> R$ {{ number_format($pedido->subtotal - $pedido->taxa_entrega, 2, ',', '.') }}</p>

            @if($pedido->forma_pagamento == 'dinheiro')
                <p><strong>Método de pagamento: </strong>Dinheiro</strong></p>
                <p><strong>Troco: R$ {{ number_format($pedido->troco, 2, ',', '.') }}</strong></p>
            @elseif($pedido->forma_pagamento == 'cartao')
                <p><strong>Método de pagamento: </strong>Cartão</p>
            @else
                <p><strong>Método de pagamento: </strong>Pix</p>
            @endif

            @if($pedido->retirada)
                <p><strong>Retirar no local</strong></p>
                <p><strong>Pagamento somente na retirada!</strong></p>
            @else
                <p><strong>Taxa de entrega:</strong> R$ {{ number_format($pedido->taxa_entrega, 2, ',', '.') }}</p>
                <p>{{ $pedido->endereco }} - {{ $pedido->bairro->nome }}</p>
                <p><strong>Pagamento somente no momento da entrega!</strong></p>
            @endif

            @if($pedido->cupomId != null)
                <p><strong>Cupom utilizado:</strong> {{ $pedido->cupom->nome }} - {{ $pedido->cupom->valor }}% de desconto</p>
            @endif
        </div>

        <a href="{{ route('index') }}" class="botao-retornar">Retornar à Home</a>
    </div>


</div>

<style>
    .finalizacao-pedido {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .numero-pedido {
        font-size: 2.5em;
        color: #333;
        margin-bottom: 20px;
    }

    .tabela-produtos {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        text-align: left;
    }

    .tabela-produtos th {
        background-color: #FA8032;
        color: #ffffff;
        padding: 12px;
        font-size: 1em;
        text-align: center;
    }

    .tabela-produtos td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        font-size: 1em;
        color: #333;
        text-align: center;
    }

    .resumo-pedido {
        text-align: left;
        font-size: 1.1em;
        margin-bottom: 20px;
    }

    .resumo-pedido p {
        margin: 8px 0;
    }

    .botao-retornar {
        display: inline-block;
        background-color: #FA8032;
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 1.2em;
        transition: background-color 0.3s;
        margin-top: 20px;
    }

    .botao-retornar:hover {
        background-color: #e6761f;
    }


</style>


@include('components.footer')

</body>
</html>
