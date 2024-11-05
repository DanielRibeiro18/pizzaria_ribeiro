<!DOCTYPE html>
<html lang="pt-br">

@include('admin.components.headadmin', ['title'=>'Produtos'])

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

    <form enctype="multipart/form-data" action="{{ route('produto.cadastro') }}" method="POST" class="form-registro">
        {{ csrf_field() }}

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <input type="hidden" id="precomedia" name="precomedia" >
        <input type="hidden" id="precogrande" name="precogrande" >
        <input type="hidden" id="precobebida" name="precobebida" >

        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" required>

        <label for="img">Imagem:</label>
        <input type="file" id="img" name="img" id="img_produto" required>

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

        <button type="submit" class="btn-registrar">Criar Produto</button>
    </form>

        <form action="{{ route('logica.update') }}" class="form-registro" style="margin-top: 10px;">
            {{ csrf_field() }}
            <select name="logica">
                @foreach(config('logicas.logicas') as $logica)
                    <option value="{{ $logica }}">{{ $logica }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-registrar">Alterar lógica de Meio a Meio</button>
        </form>

        <div class="text-center mt-4">
            <form action="{{ route('produto.gerarPdf') }}" method="GET">
                <button type="submit" class="btn btn-relatorio">Relatório de Produtos</button>
            </form>
        </div>


        <div class="grid-produtos">
            @foreach($produtos as $produto)
                <div class="produto-item">
                    <div class="produto-info">
                        <span class="produto-imagem"> <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $produto->img) }}" alt="" style="width: 80px;"> <br> </span>
                        <span class="produto-nome">{{ $produto->nome }}</span>
                        <span class="produto-tamanho">{{ $produto->tamanho }}</span>
                        <span class="produto-preco">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>

                        @if($produto->ativo)
                            <span>Ativo</span>
                        @else
                            <span>Inativo</span>
                        @endif

                    </div>
                    <div class="produto-actions">
                        <form action="{{ route('produto.remove', $produto->id) }}" method="POST" class="remover-form">
                            {{ csrf_field() }}
                            <button type="submit" class="btn-remover">Remover</button>
                        </form>
                        <form action="{{ route('produto.edit', $produto->id) }}" method="GET" class="editar-form">
                            {{ csrf_field() }}
                            <button type="submit" class="btn-editar">Editar</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

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


    </div>
</div>

<style>
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

    .grid-produtos {
        display: grid; /* Define o contêiner como uma grid */
        grid-template-columns: repeat(3, 1fr); /* Cria 3 colunas iguais */
        gap: 20px; /* Espaço entre os itens */
        margin: 20px 0; /* Margem superior e inferior */
    }

    .produto-item {
        padding: 15px; /* Espaçamento interno */
        border: 1px solid #ced4da; /* Borda leve */
        border-radius: 8px; /* Bordas arredondadas */
        text-align: center; /* Centraliza o texto */
    }

    .produto-info {
        margin-bottom: 10px; /* Espaço abaixo das informações do usuário */
    }

    .produto-nome {
        font-weight: bold; /* Nome em negrito */
        color: white; /* Cor do texto */
    }

    .produto-actions {
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
