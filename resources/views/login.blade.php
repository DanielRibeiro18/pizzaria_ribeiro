<!doctype html>
<html lang="pt-br">

@include('components.head', ['title'=>'Entrar'])

<body>
    @include('components.navbar', ['theme'=>'Faça seu login']);

    <div class="login-container">
        <form action="{{ route('usuario.login') }}" method="POST">
            {{ csrf_field() }}
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Entrar</button>
        </form>
    </div>

    <style>
        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .login-container form label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .login-container form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-container button:hover {
            background-color: #4cae4c;
        }
    </style>

    @include('components.footer');
</body>
</html>
