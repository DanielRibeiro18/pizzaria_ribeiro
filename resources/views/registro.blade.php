<!doctype html>
<html lang="pt-br">

@include('components.head', ['title'=>'Registro'])

<body>
@include('components.navbar', ['theme'=>'Registrar']);

<div class="form-container">

    @if(session('Erro'))
        <div class="alert alert-danger" style="text-align: center;">
            {{ session('Erro') }}
        </div>
    @endif

    <form action="{{route('usuario.registro')}}" method="POST">
        {{ csrf_field() }}
        <label for="nome">Nome Completo:</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" oninput="mascaraTelefone(this)" required>

        <label for="cpf">Cpf:</label>
        <input type="cpf" id="cpf" name="cpf" oninput="mascaraCpf(this)" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <label for="confirma_senha">Confirme a senha:</label>
        <input type="password" id="confirma_senha" name="confirma_senha" required>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
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

    .form-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
        margin: 20px auto;
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    .form-container h2 {
        margin-bottom: 20px;
        text-align: center;
        color: #333;
    }

    .form-container form label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    .form-container form input {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-container button {
        width: 100%;
        padding: 10px;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
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

@include('components.footer');
</body>
</html>
