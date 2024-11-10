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

        <form action="{{ route('usuario.registroadmin') }}" method="POST" class="form-registro">
            {{ csrf_field() }}
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required>

            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" oninput="mascaraTelefone(this)" required>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" oninput="mascaraCpf(this)" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>


            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <label for="confirma_senha">Confirme a senha:</label>
            <input type="password" id="confirma_senha" name="confirma_senha" required>

            <button type="submit" class="btn-registrar">Registrar</button>
        </form>

        <div class="text-center mt-4">
            <form action="{{ route('usuario.gerarPdf') }}" method="GET">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-relatorio">Relatório de Usuários</button>
            </form>
        </div>

        <div class="grid-usuarios">
            @foreach($usuarios as $usuario)
                <div class="usuario-item">
                    <div class="usuario-info">
                        <span class="usuario-nome">{{ $usuario->nome }}</span>
                        <span class="usuario-email">{{ $usuario->email }}</span>
                        <span class="usuario-cpf" id="cpf-{{ $usuario->id }}">{{ $usuario->cpf }}</span>
                        @if($usuario->admin)
                            <span class="usuario-admin">É admin</span>
                        @else
                            <span class="usuario-admin">Não é admin</span>
                        @endif

                    </div>
                    <div class="usuario-actions">
                        <form action="{{ route('usuario.remove', $usuario->id) }}" method="POST" class="remover-form">
                            {{ csrf_field() }}
                            <button type="submit" class="btn-remover">Remover</button>
                        </form>
                        <form action="{{ route('usuario.edit', $usuario->id) }}" method="GET" class="editar-form">
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
    .alert {
        background-color: #f8d7da; /* Fundo vermelho claro */
        color: #721c24; /* Texto vermelho escuro */
        border: 1px solid #f5c6cb; /* Borda vermelha */
        padding: 10px; /* Espaçamento interno */
        border-radius: 5px; /* Bordas arredondadas */
        margin-bottom: 20px; /* Espaçamento abaixo do alerta */
        text-align: center; /* Centraliza o texto */
    }

    .grid-usuarios {
        display: grid; /* Define o contêiner como uma grid */
        grid-template-columns: repeat(3, 1fr); /* Cria 3 colunas iguais */
        gap: 20px; /* Espaço entre os itens */
        margin: 20px 0; /* Margem superior e inferior */
    }

    .usuario-item {
        padding: 15px; /* Espaçamento interno */
        border: 1px solid #ced4da; /* Borda leve */
        border-radius: 8px; /* Bordas arredondadas */
        text-align: center; /* Centraliza o texto */
    }

    .usuario-info {
        margin-bottom: 10px; /* Espaço abaixo das informações do usuário */
    }

    .usuario-nome {
        font-weight: bold; /* Nome em negrito */
        color: white; /* Cor do texto */
    }

    .usuario-email, .usuario-cpf {
        color: white; /* Cor do texto */
        display: block; /* Cada informação ocupa uma linha */
        margin: 5px 0; /* Margem em cima e embaixo */
    }

    .usuario-actions {
        display: flex; /* Alinha os botões horizontalmente */
        justify-content: center; /* Centraliza os botões */
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

    .form-registro input {
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

    .form-registro .btn-registrar:hover {
        background-color: #e88c2f; /* Cor do botão ao passar o mouse */
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cpfElements = document.querySelectorAll('.usuario-cpf');

        cpfElements.forEach(cpfElement => {
            const cpf = cpfElement.textContent;
            const formattedCpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            cpfElement.textContent = formattedCpf;
        });
    });


        function mascaraCpf(cpfField) {
        // Remove caracteres que não sejam dígitos
        let valor = cpfField.value.replace(/\D/g, '');

        // Limitar a 11 dígitos
        if (valor.length > 11) {
        valor = valor.slice(0, 11); // Limita a 11 caracteres
    }

        // Adiciona a máscara
        if (valor.length <= 11) {
        valor = valor.replace(/^(\d{3})(\d)/, '$1.$2'); // Adiciona o primeiro ponto
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o segundo ponto
        valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona o traço
    }

        cpfField.value = valor; // Atualiza o valor do campo
    }

    function mascaraTelefone(telefone) {
        // Remove tudo que não for número
        telefone.value = telefone.value.replace(/\D/g, '');

        // Limitar a 11 caracteres numéricos (2 do DDD + 9 do telefone)
        telefone.value = telefone.value.substring(0, 11);

        // Se o telefone tiver 11 dígitos (formato com 9 no telefone)
        if (telefone.value.length === 11) {
            telefone.value = telefone.value.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
        }
        // Se o telefone tiver 10 dígitos (formato com 8 no telefone)
        else if (telefone.value.length === 10) {
            telefone.value = telefone.value.replace(/(\d{2})(\d{4})(\d{4})/, "($1) $2-$3");
        }
    }

</script>
</body>
</html>
