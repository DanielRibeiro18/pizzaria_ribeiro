<!DOCTYPE html>
<html lang="pt-br">

@include('admin.components.headadmin', ['title'=>'Usuários'])

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

        @if(session('Erro'))
            <div class="alert alert-danger" style="text-align: center;">
                {{ session('Erro') }}
            </div>
        @endif

        <form action="{{ route('usuario.update', $usuario->id) }}" method="POST" class="usuario-form">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" value="{{ $usuario->nome }}" required>

            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" value="{{ $usuario->telefone }}" required>

            <label for="cpf">Cpf:</label>
            <input type="text" id="cpf" name="cpf" value="{{ $usuario->cpf }}" required maxlength="14">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $usuario->email }}" required>

            <button type="submit">Editar usuário</button>


        </form>

    </div>
</div>
</div>

<style>
    .alert {
        background-color: #f8d7da; /* Fundo vermelho claro */
        color: #721c24; /* Texto vermelho escuro */
        border: 1px solid #f5c6cb; /* Borda vermelha */
        padding: 10px; /* Espaçamento interno */
        border-radius: 5px; /* Bordas arredondadas */
        margin-bottom: 20px; /* Espaçamento abaixo do alerta */
        text-align: center; /* Centraliza o texto */
    }

    .usuario-form {
        display: flex;
        flex-direction: column;
        align-items: center; /* Centraliza o conteúdo horizontalmente */
        margin: 20px; /* Margem ao redor do formulário */
        padding: 20px; /* Adiciona padding interno */
        border: 1px solid white; /* Borda branca ao redor do formulário */
        border-radius: 10px; /* Bordas arredondadas */
        background-color: transparent; /* Fundo transparente */
    }

    .usuario-form label {
        margin-top: 10px; /* Espaço acima dos rótulos */
    }

    .usuario-form input {
        width: 100%; /* Largura total */
        max-width: 300px; /* Limita a largura máxima dos inputs */
        padding: 10px; /* Padding interno */
        margin-top: 5px; /* Espaço acima do input */
        border: 1px solid white; /* Borda branca */
        border-radius: 5px; /* Bordas arredondadas */
        background-color: white; /* Fundo branco */
    }

    .usuario-form button {
        margin-top: 20px; /* Espaço acima do botão */
        padding: 10px 15px; /* Padding do botão */
        background-color: #FA8032; /* Cor do botão */
        color: white; /* Cor do texto do botão */
        border: none; /* Sem borda */
        border-radius: 5px; /* Bordas arredondadas */
        cursor: pointer; /* Cursor de mão ao passar o mouse */
    }

    .usuario-form button:hover {
        background-color: #e07e30; /* Cor do botão ao passar o mouse */
    }


</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cpfInput = document.getElementById('cpf');

        cpfInput.addEventListener('input', function (e) {
            const value = e.target.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
            let formattedValue = '';

            if (value.length <= 11) {
                formattedValue = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona ponto após 3 dígitos
                formattedValue = formattedValue.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona ponto após 6 dígitos
                formattedValue = formattedValue.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona hífen antes dos últimos 2 dígitos
            }

            e.target.value = formattedValue;
        });
    });

</script>

</body>
</html>
