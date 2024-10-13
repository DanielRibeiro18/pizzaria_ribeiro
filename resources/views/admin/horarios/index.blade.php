<!DOCTYPE html>
<html lang="pt-br">

@include('admin.components.headadmin', ['title'=>'Horários'])

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

        <div class="text-center mt-4">
            <form action="{{ route('horario.gerarPdf') }}" method="GET">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-relatorio">Relatório de Horários de Funcionamento</button>
            </form>
        </div>

        <div class="grid-horarios">
@foreach($horarios as $horario)
                <div class="horario-item">
                    <div class="horario-info">
    {{ $horario->dia_semana }}

    <div>
        {{ $horario->hora_abertura }} - {{ $horario->hora_fechamento }}
    </div>
                    </div>

                    <div class="horario-actions">
                <form action="{{ route('horario.edit', $horario->id) }}" method="GET" class="editar-form">
                    {{ csrf_field() }}
                    <button type="submit" class="btn-editar">Editar</button>
                </form>
                    </div>
                </div>
@endforeach
        </div>


    </div>

</div>

<style>
    .grid-horarios {
        display: grid; /* Define o contêiner como uma grid */
        grid-template-columns: repeat(3, 1fr); /* Cria 3 colunas iguais */
        gap: 20px; /* Espaço entre os itens */
        margin: 20px 0; /* Margem superior e inferior */
    }

    .horario-item {
        padding: 15px; /* Espaçamento interno */
        border: 1px solid #ced4da; /* Borda leve */
        border-radius: 8px; /* Bordas arredondadas */
        text-align: center; /* Centraliza o texto */
    }

    .horario-actions {
        display: flex; /* Alinha os botões horizontalmente */
        justify-content: center; /* Centraliza os botões */
    }

    .horario-info {
        margin-bottom: 10px; /* Espaço abaixo das informações do usuário */
    }

    .btn-editar {
        background-color: #FA8032; /* Cor de fundo */
        color: white; /* Cor do texto */
        border: none; /* Sem borda */
        padding: 8px 12px; /* Padding do botão */
        border-radius: 8px; /* Bordas arredondadas */
        cursor: pointer; /* Cursor de mão ao passar o mouse */
        transition: background-color 0.3s; /* Transição suave ao passar o mouse */
        margin: 0 5px; /* Margem entre os botões */
    }

    .btn-editar:hover {
        background-color: #e88c2f; /* Cor dos botões ao passar o mouse */
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
