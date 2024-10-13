<!DOCTYPE html>
<html lang="pt-br">

@include('admin.components.headadmin', ['title'=>'Adicionais'])
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



    <form action="{{ route('adicional.store') }}" method="POST" class="form-adicional">
        {{ csrf_field() }}

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="valor">Preço:</label>
        <input type="text" id="valor" name="valor">

        <button type="submit" class="btn btn-primary btn-custom">Inserir Adicional</button>
    </form>

    <div class="text-center mt-4">
        <form action="{{ route('adicional.gerarPdf') }}" method="GET">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-relatorio">Relatório de Adicionais</button>
        </form>
    </div>

    <div class="grid-adicionais">
        @foreach($adicionais as $adicional)
            <div class="adicional-item">
                <span class="adicional-nome">{{ $adicional->nome }}</span>
                <span class="adicional-valor">{{ $adicional->valor }}</span>
                <form action="{{ route('adicional.delete', $adicional->id) }}" method="POST" class="remover-form">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger">Remover</button>
                </form>
            </div>
        @endforeach
    </div>

</div>
</div>

<style>
    .form-adicional {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ced4da; /* Borda leve */
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
        font-family: 'Arial', sans-serif;
    }

    .form-adicional label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #FFFFFF;
    }

    .form-adicional input[type="text"] {
        width: 80%;  /* Menor largura */
        padding: 8px 10px;  /* Redução do padding */
        margin-bottom: 12px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        font-size: 14px;  /* Tamanho de fonte reduzido */
        transition: border-color 0.3s;
    }

    .form-adicional input[type="text"]:focus {
        border-color: #007bff;
        outline: none;
    }

    .btn-custom {
        width: 80%;  /* Botão menor para centralizar */
        padding: 10px;  /* Padding reduzido para o botão */
        font-size: 14px;  /* Tamanho de fonte do botão ajustado */
        border-radius: 8px;
        transition: background-color 0.3s ease;
        margin: 0 auto;  /* Centraliza o botão */
        display: block;  /* Faz o botão se comportar como um bloco */
    }

    .btn-primary{
        background-color: #FA8032;
        color: white;
    }

    /* Efeito hover para o botão */
    .btn-primary:hover {
        background-color: #e88c2f;
    }

    .grid-adicionais {
        display: grid; /* Define o contêiner como uma grid */
        grid-template-columns: repeat(3, 1fr); /* Cria 3 colunas iguais */
        gap: 20px; /* Espaço entre os itens */
        margin: 20px 0; /* Margem superior e inferior */
    }

    .adicional-item {
        padding: 15px; /* Espaçamento interno */
        background-color: transparent; /* Fundo transparente */
        border: 1px solid #ced4da; /* Borda leve */
        border-radius: 8px; /* Bordas arredondadas */
        text-align: center; /* Centraliza o texto */
        margin-bottom: 10px;
    }

    .adicional-nome {
        font-weight: bold; /* Nome em negrito */
        color: white; /* Cor do texto para branco */
    }

    .adicional-valor {
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
