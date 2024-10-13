<!DOCTYPE html>
<html lang="pt-br">

@include('admin.components.headadmin', ['title'=>'Atualizar produto'])

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

        <form action="{{ route('produto.update', $produto->id) }}" method="POST" class="produto-form">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <span class="produto-imagem">
    <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $produto->img) }}" alt="" style="width: 100px; height: 100px; object-fit: cover;">
    <br>
</span>


            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="{{ $produto->nome }}" required>

            <label for="telefone">Preço Média:</label>
            <input type="tel" id="preco" name="preco" value="{{ $produto->preco }}" required>

            <div class="checkbox-container">
                <label for="ativo">Produto ativo?</label>
                <input type="checkbox" id="ativo" name="ativo" value="1" {{ $produto->ativo ? 'checked' : '' }}>
            </div>


            <button type="submit">Editar produto</button>


        </form>

    </div>
</div>

<style>
    .produto-form {
        display: flex;
        flex-direction: column;
        align-items: center; /* Centraliza o conteúdo horizontalmente */
        margin: 20px; /* Margem ao redor do formulário */
        padding: 20px; /* Adiciona padding interno */
        border: 1px solid white; /* Borda branca ao redor do formulário */
        border-radius: 10px; /* Bordas arredondadas */
        background-color: transparent; /* Fundo transparente */
    }

    .produto-form label {
        margin-top: 10px; /* Espaço acima dos rótulos */
    }

    .produto-form input {
        width: 100%; /* Largura total */
        max-width: 300px; /* Limita a largura máxima dos inputs */
        padding: 10px; /* Padding interno */
        margin-top: 5px; /* Espaço acima do input */
        border: 1px solid white; /* Borda branca */
        border-radius: 5px; /* Bordas arredondadas */
        background-color: white; /* Fundo branco */
    }

    .produto-form button {
        margin-top: 20px; /* Espaço acima do botão */
        padding: 10px 15px; /* Padding do botão */
        background-color: #FA8032; /* Cor do botão */
        color: white; /* Cor do texto do botão */
        border: none; /* Sem borda */
        border-radius: 5px; /* Bordas arredondadas */
        cursor: pointer; /* Cursor de mão ao passar o mouse */
    }

    .produto-form button:hover {
        background-color: #e07e30; /* Cor do botão ao passar o mouse */
    }

    .checkbox-container {
        display: flex;
        flex-direction: column; /* Coloca o label em uma linha e a checkbox em outra */
        align-items: flex-start; /* Alinha à esquerda, se necessário */
    }

    input[type="checkbox"] {
        margin-top: 5px; /* Dá um espaço entre o label e a checkbox */
    }

</style>

</body>
</html>
