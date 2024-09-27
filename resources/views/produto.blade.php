<!doctype html>
<html lang="pt-br">

@include('components.head', ['title'=>'Produto'])

<body>
@include('components.navbar', ['theme'=>'Faça seu login']);

<div class="login-container">
    <form enctype="multipart/form-data" action="{{ route('produto.cadastro') }}" method="POST">
        {{ csrf_field() }}

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <input type="hidden" id="precomedia" name="precomedia" >
        <input type="hidden" id="precogrande" name="precogrande" >
        <input type="hidden" id="precobebida" name="precobebida" >

        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" required>

        <label for="img">Imagem:</label>
        <input type="file" id="img" name="img" required>

        <label for="categoria">Categoria:</label>
        <select name="categoria" id="categoria" onchange="exibirCamposPreco()">
            <option value="" selected>Selecione uma categoria</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
            @endforeach
        </select>

        <div id="precoMediaContainer" style="display: none;">
            <label for="precomedia">Preço Média:</label>
            <input type="text" id="precomediaText" name="precomedia">
        </div>

        <div id="precoGrandeContainer" style="display: none;">
            <label for="precogrande">Preço Grande:</label>
            <input type="text" id="precograndeText" name="precogrande">
        </div>

        <div id="precoBebidaContainer" style="display: none;">
            <label for="precobebida">Preço Bebida:</label>
            <input type="text" id="precobebidaText" name="precobebida">
        </div>

        <button type="submit">Criar Produto</button>
    </form>

    <script>
        function exibirCamposPreco() {
            var categoriaId = document.getElementById('categoria').value;

            // IDs das categorias correspondentes
            var salgadaId = 1; // Substitua pelo ID real da categoria 'Salgada'
            var doceId = 2;    // Substitua pelo ID real da categoria 'Doce'
            var bebidaId = 3;  // Substitua pelo ID real da categoria 'Bebida'

            var precoMedia = document.getElementById('precoMediaContainer');
            var precoGrande = document.getElementById('precoGrandeContainer');
            var precoBebida = document.getElementById('precoBebidaContainer');

            // Resetando todos os campos de preço
            precoMedia.style.display = 'none';
            precoGrande.style.display = 'none';
            precoBebida.style.display = 'none';

            // Verificar o ID da categoria e mostrar os campos adequados
            if (categoriaId == salgadaId || categoriaId == doceId) {
                precoMedia.style.display = 'block';
                precoGrande.style.display = 'block';
            } else if (categoriaId == bebidaId) {
                precoBebida.style.display = 'block';
            }
        }
    </script>

    {{--    <form enctype="multipart/form-data" action="{{ route('produto.cadastro') }}" method="POST">--}}
{{--        {{ csrf_field() }}--}}

{{--        <label for="nome">Nome:</label>--}}
{{--        <input type="text" id="nome" name="nome" required>--}}

{{--        <label for="preco">Preço:</label>--}}
{{--        <input type="text" id="preco" name="preco" >--}}

{{--        <label for="tamanho">Tamanho:</label>--}}
{{--        <select name="tamanho">--}}
{{--            <option value="" selected></option>--}}
{{--            <option value="media">Média</option>--}}
{{--            <option value="grande">Grande</option>--}}
{{--        </select>--}}

{{--        <label for="descricao">Descrição:</label>--}}
{{--        <input type="text" id="descricao" name="descricao" required>--}}

{{--        <label for="img">Imagem:</label>--}}
{{--        <input type="file" id="img" name="img" required>--}}

{{--        <label for="categoria">Categoria:</label>--}}
{{--        <select name="categoria">--}}
{{--            @foreach($categorias as $categoria)--}}
{{--                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>--}}
{{--            @endforeach--}}
{{--        </select>--}}

{{--        <button type="submit">Criar Produto</button>--}}
{{--    </form>--}}
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
