<!doctype html>
<html lang="pt-br">

@include('components.head', ['title'=>'Registro'])

<body>
@include('components.navbar', ['theme'=>'Registrar']);

<div class="form-container">
    <form action="{{route('usuario.registro')}}" method="POST">
        {{ csrf_field() }}
        <label for="nome">Nome Completo:</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" required>

        <label for="cpf">Cpf:</label>
        <input type="cpf" id="cpf" name="cpf" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit">Registrar</button>
    </form>
</div>

<style>

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
        background-color: #5cb85c;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .form-container button:hover {
        background-color: #4cae4c;
    }

</style>

@include('components.footer');
</body>
</html>
