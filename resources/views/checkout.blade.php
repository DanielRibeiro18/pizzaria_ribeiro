<!DOCTYPE html>
<html lang="pt-br">

@include('components.head', ['title'=>'Checkout'])

<body>
@include('components.navbar', ['theme'=>'Finalize seu pedido!'])

<table class="tabela-produtos">
    <thead>
    <tr>
        <th>Produto</th>
        <th>Metade</th>
        <th>Adicional 1</th>
        <th>Adicional 2</th>
        <th>Tamanho</th>
        <th>Observação</th>
    </tr>
    </thead>
    <tbody>
    @foreach($produtos as $produto)
        <tr>
            <td>{{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>

            @if($produto->pivot->eMeioaMeio)
                <td>{{ $produto->pivot->metade->nome }} - R$ {{ number_format($produto->pivot->metade->preco, 2, ',', '.') }}</td>
            @else
                <td>-</td>
            @endif

            @if($produto->pivot->adicional1 != null)
                <td>{{ $produto->pivot->adicional1->nome }} - R$ {{ number_format($produto->pivot->adicional1->valor, 2, ',', '.') }}</td>
            @else
                <td>-</td>
            @endif

            @if($produto->pivot->adicional2 != null)
                <td>{{ $produto->pivot->adicional2->nome }} - R$ {{ number_format($produto->pivot->adicional2->valor, 2, ',', '.') }}</td>
            @else
                <td>-</td>
            @endif

            <td>{{ $produto->tamanho }}</td>
            <td>{{ $produto->pivot->observacao }}</td>
            <td>
                <form action="{{ route('pedido.remove', $produto->pivot->id) }}" method="POST">
                    {{ csrf_field() }}
                    <button type="submit" value="remover" class="btn-lixo">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>



@if(session('Cupom_invalido'))
    <div class="alert-erro-cupom alert-danger" style="text-align: center; margin-top: 10px;">
        {{ session('Cupom_invalido') }}
    </div>
@endif

@if(session('Sucesso_cupom'))
    <div class="alert-sucesso-cupom" style="text-align: center; margin-top: 10px;">
        {{ session('Sucesso_cupom') }}
    </div>
@endif

<form action="{{ route('cupom.aplica') }}" method="POST" class="formCupom">
    {{ csrf_field() }}
    <label for="cupom">Cupom:</label>
    <input type="text" id="cupom" name="cupom">
    <button type="submit" value="aplicar">APLICAR</button>
</form>

<form action="{{ route('pedido.finaliza') }}" method="POST" class="form">
    {{ csrf_field() }}

    <!-- Forma de Pagamento -->
    <div class="form-group">

        <h3 hidden>Subtotal: R$ <span id="totalPreco" hidden>{{ number_format($totalPreco, 2, ',', '.') }}</span></h3>
        <h3>Subtotal: R$ <span id="totalCupom">{{ number_format($totalCupom, 2, ',', '.') }}</span></h3>
        @if(session('Sucesso_cupom'))
            <h3>Cupom aplicado: <span id="nomeCupom">{{ $nomeCupom }}</span><span id="valorCupom"> - {{ $valorCupom }}% de desconto </span> <span id="descCategoria"> em: {{ $descCategoria }}</span></h3>
        @endif
        <label for="forma_pagamento">Forma de Pagamento</label>
        <select id="forma_pagamento" name="forma_pagamento" onchange="checkFormaPagamento()">
            <option value="cartao">Cartão</option>
            <option value="dinheiro">Dinheiro</option>
            <option value="pix">Pix</option>
        </select>
    </div>

    <!-- Troco -->
    <div id="troco_section" class="form-group" style="display: none;">
        <label for="precisa_troco">Precisa de troco?</label>
        <select id="precisa_troco" name="precisa_troco" onchange="checkTroco()">
            <option value="nao">Não</option>
            <option value="sim">Sim</option>
        </select>
    </div>

    <div id="troco_valor_section" class="form-group" style="display: none;">
        <label for="troco">Valor para troco:</label>
        <input type="text" id="troco" name="troco" oninput="calculateTroco()">
        <small id="troco_result" class="form-text text-muted"></small>
    </div>

    <!-- Valor dos Produtos -->
    <div class="form-group">
        <label for="valor_produtos">Valor dos Produtos:</label>
        <input type="text" id="valor_produtos" name="valor_produtos" value="{{ number_format($totalCupom, 2, ',', '.') }}" readonly>
    </div>

    <!-- Subtotal -->
    <div class="form-group">
        <label for="subtotal">Subtotal</label>
        <input type="text" id="subtotal" name="subtotal" value="" readonly>
    </div>

    <div class="form-group">
        <label for="retirada">Retirar no local?</label>
        <input type="checkbox" id="retirada" name="retirada" value="on"  onclick="toggleFields()">
    </div>

    <!-- Taxa de Entrega -->
    <div class="form-group">
        <label for="taxa_entrega">Taxa de Entrega</label>
        <input type="text" id="taxa_entrega" name="taxa_entrega" value="" readonly>
    </div>

    <!-- CEP -->
    <div class="form-group">
        <label for="cep">CEP</label>
        <input type="text" id="cep" name="cep" oninput="mascaraCEP(this)">
    </div>

    <!-- Logradouro -->
    <div class="form-group">
        <label for="logradouro">Logradouro</label>
        <input type="text" id="logradouro" name="logradouro" >
    </div>

    <!-- Bairro -->
    <div class="form-group">
        <label for="bairro">Bairro</label>
        <input type="text" id="bairro" name="bairro" >
    </div>

    <!-- Número -->
    <div class="form-group">
        <label for="numero">Número</label>
        <input type="text" id="numero" name="numero" >
    </div>

    <!-- Complemento -->
    <div class="form-group">
        <label for="complemento">Complemento</label>
        <input type="text" id="complemento" name="complemento" >
    </div>

    <!-- Referência -->
    <div class="form-group">
        <label for="referencia">Referência</label>
        <input type="text" id="referencia" name="referencia" >
    </div>

    <button type="submit" class="btn btn-primary">Finalizar Pedido</button>
</form>

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

    /* Centralizar o contêiner do formulário */
    .form {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 20px auto 0; /* Centraliza o formulário horizontalmente */
    }

    /* Estilos para os títulos */
    .form h3 {
        margin-bottom: 15px;
        color: #333333;
        font-weight: 600;
        font-size: 1.2em;
    }

    /* Estilos para os grupos de formulários */
    .form .form-group {
        margin-bottom: 20px;
    }

    /* Estilos para os labels */
    .form .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #555555;
    }

    /* Estilos para os inputs e selects */
    .form .form-group input[type="text"],
    .form .form-group select {
        width: 100%;
        padding: 10px;
        font-size: 1em;
        color: #333333;
        border: 1px solid #cccccc;
        border-radius: 5px;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }

    .form .form-group input[type="text"]:focus,
    .form .form-group select:focus {
        border-color: #007bff; /* Cor de destaque ao focar */
        outline: none;
    }

    /* Estilo para checkbox */
    .form .form-group input[type="checkbox"] {
        margin-right: 5px;
    }

    /* Estilo para o botão dentro do formulário */
    .form button[type="submit"] {
        width: 100%;
        padding: 12px;
        font-size: 1em;
        font-weight: bold;
        color: #ffffff;
        background-color: #FA8032; /* Cor de fundo atualizada */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .form button[type="submit"]:hover {
        background-color: #e6761f; /* Cor de hover ajustada */
    }

    /* Texto auxiliar abaixo dos inputs */
    .form .form-text {
        font-size: 0.9em;
        color: #888888;
    }

    /* Estilo para mensagens de cupom */
    .form #nomeCupom,
    .form #valorCupom,
    .form #descCategoria {
        color: #28a745;
        font-weight: bold;
    }

    /* Centralizar o contêiner do formulário de cupom */
    .formCupom {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: 20px auto 0; /* Margem superior de 40px, centralizado horizontalmente */
        display: flex;
        align-items: center;
    }


    /* Estilos para o label */
    .formCupom label {
        font-weight: 500;
        color: #555555;
        margin-right: 10px;
    }

    /* Estilo para o campo de entrada de texto */
    .formCupom input[type="text"] {
        flex: 1; /* Faz com que o campo ocupe o máximo de espaço possível */
        padding: 10px;
        font-size: 1em;
        color: #333333;
        border: 1px solid #cccccc;
        border-radius: 5px;
        transition: border-color 0.3s;
        box-sizing: border-box;
    }

    .formCupom input[type="text"]:focus {
        border-color: #007bff;
        outline: none;
    }

    /* Estilo para o botão */
    .formCupom button[type="submit"] {
        padding: 10px 20px;
        font-size: 1em;
        font-weight: bold;
        color: #ffffff;
        background-color: #FA8032;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-left: 5px;
    }

    .formCupom button[type="submit"]:hover {
        background-color: #e6761f;
    }

    /* Estilos para a tabela de produtos */
    .tabela-produtos {
        width: 80%;
        border-collapse: collapse;
        margin: 0 auto;
        font-size: 1em;
        background-color: #f9f9f9;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .tabela-produtos td {
        padding: 10px;
        border: 1px solid #dddddd;
        text-align: left;
        vertical-align: middle;
    }

    /* Estilo para as células de cabeçalho, caso seja necessário adicionar */
    .tabela-produtos th {
        background-color: #FA8032;
        color: #ffffff;
        padding: 12px;
        font-weight: bold;
        border: 1px solid #dddddd;
    }

    /* Estilo alternado para as linhas */
    .tabela-produtos tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* Estilo para o botão de remover */
    .tabela-produtos button[type="submit"] {
        padding: 6px 12px;
        font-size: 0.9em;
        font-weight: bold;
        color: #ffffff;
        background-color: #FA8032;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .tabela-produtos button[type="submit"]:hover {
        background-color: #e6761f;
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
