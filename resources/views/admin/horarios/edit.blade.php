<!DOCTYPE html>
<html lang="pt-br">

@include('admin.components.headadmin', ['title'=>'Editar horário'])

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

        <form action="{{ route('horario.update', $horario->id) }}" method="POST" class="horario-form">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <label for="nome">Dia: {{ $horario->dia_semana }}</label>

            <label for="fechado">Fechado?</label>
            <input type="checkbox" id="fechado" name="fechado" value="1" {{ $horario->fechado ? 'checked' : '' }}>

            <label for="hora_abertura">Horário de abertura:</label>
            <input type="text" id="hora_abertura" name="hora_abertura" value="{{ $horario->hora_abertura }}" required>

            <label for="hora_fechamento">Horário de fechamento:</label>
            <input type="text" id="hora_fechamento" name="hora_fechamento" value="{{ $horario->hora_fechamento }}" required>

            <button type="submit">Editar horário</button>
        </form>

    </div>

    </div>

<style>
    .horario-form {
        display: flex;
        flex-direction: column;
        align-items: center; /* Centraliza o conteúdo horizontalmente */
        margin: 20px; /* Margem ao redor do formulário */
        padding: 20px; /* Adiciona padding interno */
        border: 1px solid white; /* Borda branca ao redor do formulário */
        border-radius: 10px; /* Bordas arredondadas */
        background-color: transparent; /* Fundo transparente */
    }

    .horario-form label {
        margin-top: 10px; /* Espaço acima dos rótulos */
    }

    .horario-form input {
        width: 100%; /* Largura total */
        max-width: 300px; /* Limita a largura máxima dos inputs */
        padding: 10px; /* Padding interno */
        margin-top: 5px; /* Espaço acima do input */
        border: 1px solid white; /* Borda branca */
        border-radius: 5px; /* Bordas arredondadas */
        background-color: white; /* Fundo branco */
    }

    .horario-form button {
        margin-top: 20px; /* Espaço acima do botão */
        padding: 10px 15px; /* Padding do botão */
        background-color: #FA8032; /* Cor do botão */
        color: white; /* Cor do texto do botão */
        border: none; /* Sem borda */
        border-radius: 5px; /* Bordas arredondadas */
        cursor: pointer; /* Cursor de mão ao passar o mouse */
    }

    .horario-form button:hover {
        background-color: #e07e30; /* Cor do botão ao passar o mouse */
    }
</style>

</body>
</html>
