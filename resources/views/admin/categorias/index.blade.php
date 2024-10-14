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

        <form action="{{ route('categoria.registro') }}" method="POST" class="form-registro" style="margin-bottom: 20px;">
            {{ csrf_field() }}
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao" required>

            <button type="submit" class="btn-registrar">Registrar</button>
        </form>

        <div class="text-center mt-4">
            <form action="{{ route('categoria.gerarPdf') }}" method="GET">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-relatorio">Relatório de Categorias</button>
            </form>
        </div>

        <div class="grid-categorias">
            @foreach($categoria as $cat)
                <div class="categoria-item">
                    <div class="categoria-info">
                        <span class="categoria-nome">{{ $cat->nome }}<br></span>
                        <span class="categoria-descricao">{{ $cat->descricao }}</span>

                    </div>
                    <div class="categoria-actions">
                        <form action="{{ route('categoria.remove', $cat->id) }}" method="POST" class="remover-form">
                            {{ csrf_field() }}
                            <button type="submit" class="btn-remover">Remover</button>
                        </form>
                        <form action="{{ route('categoria.edit', $cat->id) }}" method="GET" class="editar-form">
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
    .grid-categorias {
        display: grid; /* Define o contêiner como uma grid */
        grid-template-columns: repeat(3, 1fr); /* Cria 3 colunas de largura igual */
        gap: 20px; /* Espaço entre os itens */
        margin: 0 auto; /* Centraliza o grid */
        width: 100%; /* Ajuste a largura conforme necessário */
    }

    .categoria-item {
        padding: 15px; /* Espaçamento interno */
        border: 1px solid #ced4da; /* Borda leve */
        border-radius: 8px; /* Bordas arredondadas */
        text-align: center; /* Centraliza o texto */
        display: flex; /* Usa flexbox para organizar elementos internamente */
        flex-direction: column; /* Disposição vertical dos itens */
        align-items: center; /* Centraliza os itens no eixo horizontal */
    }

    .categoria-actions {
        display: flex; /* Alinha os botões horizontalmente */
        justify-content: center; /* Centraliza os botões */
    }

    .categoria-info {
        margin-bottom: 10px; /* Espaço abaixo das informações do usuário */
    }

    .btn-remover, .btn-editar {
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

    .btn-remover:hover{
        background-color: #c82333;
    }

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

    .btn-relatorio {
        background-color: #FA8032; /* Cor de fundo */
        color: white; /* Cor do texto */
        border: none; /* Sem borda */
        padding: 10px 20px; /* Espaçamento interno */
        border-radius: 8px; /* Bordas arredondadas */
        cursor: pointer; /* Cursor de mão ao passar o mouse */
        transition: background-color 0.3s; /* Transição suave ao passar o mouse */
        text-align: center; /* Centraliza o texto */
        margin-bottom: 10px;
    }

    .btn-relatorio:hover {
        background-color: #e88c2f; /* Cor do botão ao passar o mouse */
    }

</style>

</body>
</html>
