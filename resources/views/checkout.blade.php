<!DOCTYPE html>
<html lang="pt-br">

@include('components.head', ['title'=>'Checkout'])

<body>
@include('components.navbar', ['theme'=>'Finalize seu pedido!'])

@foreach($produtos as $produto)
    <span>{{ $produto->nome }}</span>
    <span>R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
    @if($produto->pivot->eMeioaMeio)
        <span>{{ $produto->pivot->metade->nome }}</span>
        <span>R$ {{ number_format($produto->pivot->metade->preco, 2, ',', '.') }}</span>
    @endif
    @if($produto->pivot->adicional1 != null)
        <span>{{ $produto->pivot->adicional1->nome }}</span>
        <span>{{ number_format($produto->pivot->adicional1->valor, 2, ',', '.') }} </span>
    @endif
    @if($produto->pivot->adicional2 != null)
        <span>{{ $produto->pivot->adicional2->nome }}</span>
        <span>{{ number_format($produto->pivot->adicional2->valor, 2, ',', '.') }}</span>
    @endif
    <span>{{ $produto->tamanho }}</span>
    <span>{{ $produto->pivot->observacao }}</span>
    <br>
    <form action="{{ route('pedido.remove', $produto->pivot->id) }}" method="POST">
        {{ csrf_field() }}
        <button type="submit" value="remover">Remover do carrinho</button>
    </form>
@endforeach

<form action="{{ route('pedido.finaliza') }}" method="POST">
    {{ csrf_field() }}

    <!-- Forma de Pagamento -->
    <div class="form-group">

        <h3 hidden>Total: R$ <span id="totalPreco" hidden>{{ number_format($totalPreco, 2, ',', '.') }}</span></h3>
        <h3>Total: R$ <span id="totalCupom">{{ number_format($totalCupom, 2, ',', '.') }}</span></h3>
        <h3>Cupom aplicado: <span id="nomeCupom">{{ $nomeCupom}}</span><span id="valorCupom"> - {{ $valorCupom}}% de desconto </span> <span id="descCategoria"> em: {{ $descCategoria}}</span></h3>
        <label for="forma_pagamento">Forma de Pagamento</label>
        <select id="forma_pagamento" name="forma_pagamento" class="form-control" onchange="checkFormaPagamento()">
            <option value="cartao">Cartão</option>
            <option value="dinheiro">Dinheiro</option>
        </select>
    </div>

    <!-- Troco -->
    <div id="troco_section" class="form-group" style="display: none;">
        <label for="precisa_troco">Precisa de troco?</label>
        <select id="precisa_troco" name="precisa_troco" class="form-control" onchange="checkTroco()">
            <option value="nao">Não</option>
            <option value="sim">Sim</option>
        </select>
    </div>

    <div id="troco_valor_section" class="form-group" style="display: none;">
        <label for="troco">Valor para troco:</label>
        <input type="text" id="troco" name="troco" class="form-control" oninput="calculateTroco()">
        <small id="troco_result" class="form-text text-muted"></small>
    </div>

    <!-- Valor dos Produtos -->
    <div class="form-group">
        <label for="valor_produtos">Valor dos Produtos:</label>
        <input type="text" id="valor_produtos" name="valor_produtos" class="form-control" value="{{ number_format($totalCupom, 2, ',', '.') }}" readonly>
    </div>

    <!-- Subtotal -->
    <div class="form-group">
        <label for="subtotal">Subtotal</label>
        <input type="text" id="subtotal" name="subtotal" class="form-control" value="" readonly>
    </div>

    <div class="form-group">
        <label for="retirada">Retirar no local?</label>
        <input type="checkbox" id="retirada" name="retirada" value="on"  onclick="toggleFields()">
    </div>

    <!-- Taxa de Entrega -->
    <div class="form-group">
        <label for="taxa_entrega">Taxa de Entrega</label>
        <input type="text" id="taxa_entrega" name="taxa_entrega" class="form-control" value="" readonly>
    </div>

    <!-- CEP -->
    <div class="form-group">
        <label for="cep">CEP</label>
        <input type="text" id="cep" name="cep" class="form-control" oninput="mascaraCEP(this)">
    </div>

    <!-- Logradouro -->
    <div class="form-group">
        <label for="logradouro">Logradouro</label>
        <input type="text" id="logradouro" name="logradouro" class="form-control">
    </div>

    <!-- Bairro -->
    <div class="form-group">
        <label for="bairro">Bairro</label>
        <input type="text" id="bairro" name="bairro" class="form-control">
    </div>

    <!-- Número -->
    <div class="form-group">
        <label for="numero">Número</label>
        <input type="text" id="numero" name="numero" class="form-control">
    </div>

    <!-- Complemento -->
    <div class="form-group">
        <label for="complemento">Complemento</label>
        <input type="text" id="complemento" name="complemento" class="form-control">
    </div>

    <!-- Referência -->
    <div class="form-group">
        <label for="referencia">Referência</label>
        <input type="text" id="referencia" name="referencia" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Finalizar Pedido</button>
</form>

@if(session('Cupom_invalido'))
    <div class="alert-erro-cupom alert-danger" style="text-align: center;">
        {{ session('Cupom_invalido') }}
    </div>
@endif

@if(session('Sucesso_cupom'))
    <div class="alert-sucesso-cupom" style="text-align: center;">
        {{ session('Sucesso_cupom') }}
    </div>
@endif

<form action="{{ route('cupom.aplica') }}" method="POST">
    {{ csrf_field() }}
    <label for="cupom">Cupom:</label>
    <input type="text" id="cupom" name="cupom" class="form-control">
    <button type="submit" value="aplicar">Aplicar cupom</button>
</form>

<a href="{{ route('cardapio') }}">Voltar ao cardápio</a>

<style>
    .alert-erro-cupom {
        background-color: #f8d7da; /* Fundo vermelho claro */
        color: #721c24; /* Texto vermelho escuro */
        border: 1px solid #f5c6cb; /* Borda vermelha */
        padding: 10px; /* Espaçamento interno */
        border-radius: 5px; /* Bordas arredondadas */
        margin-bottom: 20px; /* Espaçamento abaixo do alerta */
        text-align: center; /* Centraliza o texto */
    }

    .alert-sucesso-cupom {
        background-color: green; /* Fundo vermelho claro */
        color: white; /* Texto vermelho escuro */
        border: 1px solid #f5c6cb; /* Borda vermelha */
        padding: 10px; /* Espaçamento interno */
        border-radius: 5px; /* Bordas arredondadas */
        margin-bottom: 20px; /* Espaçamento abaixo do alerta */
        text-align: center; /* Centraliza o texto */
    }
</style>

<script>

    function mascaraCEP(input) {
        // Remove todos os caracteres que não são dígitos
        let cep = input.value.replace(/\D/g, '');

        // Aplica a máscara de CEP (00000-000)
        if (cep.length > 5) {
            cep = cep.slice(0, 5) + '-' + cep.slice(5, 8);
        }

        // Atualiza o campo com o valor formatado
        input.value = cep;
    }

    function toggleFields() {
        const isRetiradaChecked = document.getElementById('retirada').checked;
        const valorProdutos = document.getElementById('valor_produtos').value;
        const subtotalField = document.getElementById('subtotal');
        const fields = [
            document.getElementById('taxa_entrega'),
            document.getElementById('cep'),
            document.getElementById('logradouro'),
            document.getElementById('bairro'),
            document.getElementById('numero'),
            document.getElementById('complemento'),
            document.getElementById('referencia')
        ];

        // Atualiza o subtotal com o valor de "valor_produtos" quando retirada está marcada
        if (isRetiradaChecked) {
            subtotalField.value = valorProdutos;
        } else {
            subtotalField.value = ""; // Limpa o subtotal se "Retirada" estiver desmarcada
        }

        // Desabilita e limpa os campos específicos
        fields.forEach(field => {
            field.disabled = isRetiradaChecked;
            if (isRetiradaChecked) {
                field.value = ""; // Limpa o campo se "Retirada" estiver marcado
            }
        });
    }


    function checkFormaPagamento() {
        var formaPagamento = document.getElementById("forma_pagamento").value;
        var trocoSection = document.getElementById("troco_section");
        var trocoValorSection = document.getElementById("troco_valor_section");

        if (formaPagamento === "dinheiro") {
            trocoSection.style.display = "block";
        } else {
            trocoSection.style.display = "none";
            trocoValorSection.style.display = "none";
        }
    }

    function checkTroco() {
        var precisaTroco = document.getElementById("precisa_troco").value;
        var trocoValorSection = document.getElementById("troco_valor_section");

        if (precisaTroco === "sim") {
            trocoValorSection.style.display = "block";
        } else {
            trocoValorSection.style.display = "none";
        }
    }

    function calculateTroco() {
        var subtotal = parseFloat(document.getElementById("subtotal").value);
        var trocoValor = parseFloat(document.getElementById("troco_valor").value);
        var trocoResult = document.getElementById("troco_result");

        if (!isNaN(trocoValor) && trocoValor >= subtotal) {
            var troco = trocoValor - subtotal;
            trocoResult.textContent = "Troco: R$" + troco;
        } else {
            trocoResult.textContent = "Insira um valor válido para troco.";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const cepInput = document.querySelector('#cep');
        const bairroInput = document.querySelector('#bairro');
        const logradouroInput = document.querySelector('#logradouro');
        const numeroInput = document.querySelector('#numero');
        const taxaEntregaInput = document.querySelector('#taxa_entrega');
        const subtotalInput = document.querySelector('#subtotal');
        const totalPrecoElement = document.querySelector('#totalCupom');
        const bairros = @json($bairros);

        // Função para formatar o número com vírgula e duas casas decimais
        function numberFormat(value) {
            return value.toFixed(2).replace('.', ',');
        }

        cepInput.addEventListener('blur', function() {
            const cep = cepInput.value.replace(/\D/g, '');

            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.erro) {
                            alert('CEP não encontrado.');
                            logradouroInput.value = '';
                            bairroInput.value = '';
                            numeroInput.value = ''; // Mantenha vazio para o usuário preencher
                        } else {
                            logradouroInput.value = data.logradouro;
                            bairroInput.value = data.bairro;
                            // Número deve ser preenchido manualmente pelo usuário
                            numeroInput.value = '';

                            // Atualizar a taxa de entrega com base no bairro
                            const bairroNome = data.bairro.toLowerCase();
                            const bairroEncontrado = bairros.find(bairro => bairro.nome.toLowerCase() === bairroNome);

                            if (bairroEncontrado) {
                                // Formata a taxa de entrega com vírgula
                                const taxaEntrega = parseFloat(bairroEncontrado.valor_entrega);
                                taxaEntregaInput.value = numberFormat(taxaEntrega);

                                // Substituir vírgula por ponto para conversão numérica de totalCupom
                                const totalPreco = parseFloat(totalPrecoElement.textContent.replace(',', '.'));
                                const subtotal = totalPreco + taxaEntrega;

                                // Formata o subtotal com vírgula
                                subtotalInput.value = numberFormat(subtotal);
                            } else {
                                taxaEntregaInput.value = '';
                                subtotalInput.value = totalPrecoElement.textContent;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar o CEP:', error);
                    });
            }
        });
    });

</script>

@include('components.footer')
</body>
</html>
