<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adicionais</title>
</head>
<body>
<form action="{{ route('adicional.store') }}" method="POST">
    {{ csrf_field() }}

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="valor">Preço:</label>
    <input type="text" id="valor" name="valor" >

    <button type="submit">Inserir adicional</button>
</form>

@foreach($adicionais as $adicional)
    {{ $adicional->nome }}
    {{ $adicional->valor }}
    <form action=" {{ route('adicional.delete', $adicional->id) }} " method="POST">
        {{ @csrf_field() }}
        <button type="submit">Remover</button>
    </form>
@endforeach
</body>
</html>
