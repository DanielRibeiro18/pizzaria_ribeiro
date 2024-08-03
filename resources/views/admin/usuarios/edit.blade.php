<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<div class="form-container">
    <form action="{{route('usuario.update', $usuario->id)}}" method="POST">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <label for="nome">Nome Completo:</label>
        <input type="text" id="nome" name="nome" value="{{ $usuario->nome }}" required>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" value="{{ $usuario->telefone }}" required>

        <label for="cpf">Cpf:</label>
        <input type="cpf" id="cpf" name="cpf" value="{{ $usuario->cpf }}" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ $usuario->email }}" required>

        <button type="submit">Editar usuário</button>
    </form>
</div>

</body>
</html>
