<!DOCTYPE html>
<html lang="pt-br">

@include('admin.components.headadmin', ['title'=>'Atualizar categoria'])

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

        <form action="{{ route('categoria.update', $categoria->id) }}" method="POST" class="categoria-form">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="{{ $categoria->nome }}" required>

            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao" value="{{ $categoria->descricao }}" required>

            <button type="submit">Atualizar categoria</button>


        </form>

    </div>
</div>

<style>

    .categoria-form {
        display: flex;
        flex-direction: column;
        align-items: center; /* Centraliza o conteúdo horizontalmente */
        margin: 20px; /* Margem ao redor do formulário */
        padding: 20px; /* Adiciona padding interno */
        border: 1px solid white; /* Borda branca ao redor do formulário */
        border-radius: 10px; /* Bordas arredondadas */
        background-color: transparent; /* Fundo transparente */
    }

    .categoria-form label {
        margin-top: 10px; /* Espaço acima dos rótulos */
    }

    .categoria-form input {
        width: 100%; /* Largura total */
        max-width: 300px; /* Limita a largura máxima dos inputs */
        padding: 10px; /* Padding interno */
        margin-top: 5px; /* Espaço acima do input */
        border: 1px solid white; /* Borda branca */
        border-radius: 5px; /* Bordas arredondadas */
        background-color: white; /* Fundo branco */
    }

    .categoria-form button {
        margin-top: 20px; /* Espaço acima do botão */
        padding: 10px 15px; /* Padding do botão */
        background-color: #FA8032; /* Cor do botão */
        color: white; /* Cor do texto do botão */
        border: none; /* Sem borda */
        border-radius: 5px; /* Bordas arredondadas */
        cursor: pointer; /* Cursor de mão ao passar o mouse */
    }

    .categoria-form button:hover {
        background-color: #e07e30; /* Cor do botão ao passar o mouse */
    }


</style>

</body>
</html>
