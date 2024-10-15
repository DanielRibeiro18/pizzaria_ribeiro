<!DOCTYPE html>
<html lang="pt-br">

@include('admin.components.headadmin', ['title'=>'Bairros'])
<body>

<div class="container">

    @include('admin.components.sidebar')


    <!-- Main Content -->
    <div class="content">

        <div class="header">
            <div class="header-buttons">
                <span class="nav-item nav-link" style="font-size: 20px">Bem-Vindo, {{ auth()->user()->nome }}</span>
                <a href="{{ route('index') }}" class="btn">Retornar à Home</a>
                <a href="{{ route('logout') }}" class="btn">Logout</a>
            </div>
        </div>

        <form action="{{ route('bairro.registro') }}" method="POST" class="form-registro">
            {{ csrf_field() }}

            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" required>

            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" readonly>

            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" readonly>

            <label for="valor_entrega">Taxa de entrega:</label>
            <input type="text" id="valor_entrega" name="valor_entrega">

            <button type="submit" class="btn-registrar">Criar Bairro</button>
        </form>

        <div class="text-center mt-4">
            <form action="{{ route('bairro.gerarPdf') }}" method="GET">
                <button type="submit" class="btn btn-relatorio">Relatório de Bairros</button>
            </form>
        </div>

        <div class="grid-bairros">
            @foreach($bairro as $b)
                <div class="bairro-item">
                    <span class="bairro-nome">{{ $b->nome }}</span>
                    <span class="bairro-cidade">{{ $b->cidade }}</span>
                    <span class="bairro-valor">Taxa de entrega: R$ {{ number_format($b->valor_entrega, 2, ',', '.') }}</span>


                    <form action="{{ route('bairro.remove', $b->id) }}" method="POST" class="remover-form">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger">Remover</button>
                    </form>
                </div>
            @endforeach
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        // Máscara para o campo CEP
        $('#cep').mask('00000-000');

        // Máscara para o campo Taxa de entrega (valor em moeda)
        $('#valor_entrega').mask('000.000,00', {reverse: true});

        // Evento para consultar API ViaCEP quando o campo de CEP perder o foco (blur)
        $('#cep').on('blur', function() {
            var cep = $(this).val().replace(/\D/g, ''); // Remover qualquer caracter que não seja número

            if(cep.length === 8) { // Verifica se o CEP tem 8 dígitos
                // Chamada AJAX para a API do ViaCEP
                $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data) {
                    if (!("erro" in data)) {
                        // Preencher os campos com os dados retornados da API
                        $('#cidade').val(data.localidade);
                        $('#bairro').val(data.bairro);
                    } else {
                        alert('CEP não encontrado.');
                    }
                });
            }
        });
    });
</script>

<style>

    .form-registro {
        max-width: 400px; /* Largura máxima do formulário */
        margin: 0 auto; /* Centraliza o formulário na tela */
        padding: 20px; /* Padding interno */
        border: 1px solid white; /* Borda branca */
        border-radius: 8px; /* Bordas arredondadas */
        background-color: transparent; /* Fundo transparente */
        display: flex; /* Usar flexbox para centralizar os elementos */
        flex-direction: column; /* Alinha os elementos em coluna */
    }

    .form-registro label {
        margin-bottom: 5px; /* Espaço abaixo do rótulo */
        color: white; /* Cor do texto do rótulo */
    }

    .form-registro input, .form-registro select {
        margin-bottom: 15px; /* Espaço abaixo do campo de entrada */
        padding: 10px; /* Padding interno */
        border: 1px solid white; /* Borda branca */
        border-radius: 4px; /* Bordas arredondadas */
        background-color: white;
    }

    .form-registro .btn-registrar {
        background-color: #FA8032; /* Cor de fundo do botão */
        color: white; /* Cor do texto do botão */
        border: none; /* Sem borda */
        padding: 10px 15px; /* Padding do botão */
        border-radius: 8px; /* Bordas arredondadas */
        cursor: pointer; /* Cursor de mão ao passar o mouse */
        transition: background-color 0.3s; /* Transição suave ao passar o mouse */
    }


    .grid-bairros {
        display: grid; /* Define o contêiner como uma grid */
        grid-template-columns: repeat(3, 1fr); /* Cria 3 colunas iguais */
        gap: 20px; /* Espaço entre os itens */
        margin: 20px 0; /* Margem superior e inferior */
    }

    .bairro-item {
        padding: 15px; /* Espaçamento interno */
        background-color: transparent; /* Fundo transparente */
        border: 1px solid #ced4da; /* Borda leve */
        border-radius: 8px; /* Bordas arredondadas */
        text-align: center; /* Centraliza o texto */
        margin-bottom: 10px;
    }

    .bairro-nome {
        font-weight: bold; /* Nome em negrito */
        color: white; /* Cor do texto para branco */
    }

    .bairro-valor, .bairro-cidade {
        color: white; /* Cor do texto para branco */
        font-weight: bold;
        display: block; /* Cada valor ocupa uma linha */
        margin: 10px 0; /* Margem em cima e embaixo */
    }

    .remover-form {
        margin-top: 10px; /* Espaçamento acima do botão */
    }

    .btn-danger {
        background-color: #FA8032; /* Nova cor de fundo do botão de remoção */
        color: white; /* Cor do texto do botão para branco */
        border: none; /* Sem borda */
        padding: 8px 12px; /* Padding do botão */
        border-radius: 8px; /* Bordas arredondadas */
        cursor: pointer; /* Cursor de mão ao passar o mouse */
        transition: background-color 0.3s; /* Transição suave ao passar o mouse */
    }

    .btn-danger:hover {
        background-color: #c82333; /* Cor do botão ao passar o mouse */
    }

    .btn-relatorio {
        background-color: #FA8032; /* Cor de fundo */
        color: white; /* Cor do texto */
        border: none; /* Sem borda */
        padding: 10px 20px; /* Espaçamento interno */
        border-radius: 8px; /* Bordas arredondadas */
        cursor: pointer; /* Cursor de mão ao passar o mouse */
        transition: background-color 0.3s; /* Transição suave ao passar o mouse */
        text-align: center; /* Centraliza o texto */
    }

    .btn-relatorio:hover {
        background-color: #e88c2f; /* Cor do botão ao passar o mouse */
    }

</style>

</body>
</html>
