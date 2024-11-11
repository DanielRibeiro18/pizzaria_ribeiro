<!DOCTYPE html>
<html lang="pt-br">

@include('admin.components.headadmin', ['title'=>'Atualizar cupom'])

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

        <form action="{{ route('cupom.update', $cupom->id) }}" method="POST" class="cupom-form">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="{{ $cupom->nome }}" required>

            <label for="valor">Valor (em %):</label>
            <input type="text" id="valor" name="valor" value="{{ $cupom->valor }}" required>

            <label for="quant_usos">Quantidade de usos:</label>
            <input type="text" id="quant_usos" name="quant_usos" value="{{ $cupom->quant_usos }}" required>
            <label for="categoriacupom">Categoria:</label>
            <select name="categoriacupom" id="categoriacupom">
                @foreach($categorias as $categoria)
                    @if($categoria->nome != 'Bebida')
                        <option value="{{ $categoria->id }}"
                                @if(in_array($categoria->id, old('categoriacupom', [])))
                                    selected
                                @elseif($cupom->categorias->contains($categoria->id))
                                    selected
                            @endif>
                            {{ $categoria->nome }}
                        </option>
                    @endif
                @endforeach
            </select>

            <label for="ativo">Ativo?</label>
            <input type="checkbox" id="ativo" name="ativo"
                {{ $cupom->ativo ? 'checked' : '' }}>

            <label for="data_valida">Data válida:</label>
            <select name="data_valida">
                <option value="Sun" @if($cupom->data_valida == 'Sun') selected @endif>Domingo</option>
                <option value="Mon" @if($cupom->data_valida == 'Mon') selected @endif>Segunda-feira</option>
                <option value="Tue" @if($cupom->data_valida == 'Tue') selected @endif>Terça-feira</option>
                <option value="Wed" @if($cupom->data_valida == 'Wed') selected @endif>Quarta-feira</option>
                <option value="Thu" @if($cupom->data_valida == 'Thu') selected @endif>Quinta-feira</option>
                <option value="Fri" @if($cupom->data_valida == 'Fri') selected @endif>Sexta-feira</option>
                <option value="Sat" @if($cupom->data_valida == 'Sat') selected @endif>Sábado</option>
            </select>

            <button type="submit">Editar cupom</button>


        </form>

    </div>
</div>

<style>

    .cupom-form {
        display: flex;
        flex-direction: column;
        align-items: center; /* Centraliza o conteúdo horizontalmente */
        margin: 20px; /* Margem ao redor do formulário */
        padding: 20px; /* Adiciona padding interno */
        border: 1px solid white; /* Borda branca ao redor do formulário */
        border-radius: 10px; /* Bordas arredondadas */
        background-color: transparent; /* Fundo transparente */
    }

    .cupom-form label {
        margin-top: 10px; /* Espaço acima dos rótulos */
    }

    .cupom-form input, .cupom-form select {
        width: 100%; /* Largura total */
        max-width: 300px; /* Limita a largura máxima dos inputs */
        padding: 10px; /* Padding interno */
        margin-top: 5px; /* Espaço acima do input */
        border: 1px solid white; /* Borda branca */
        border-radius: 5px; /* Bordas arredondadas */
        background-color: white; /* Fundo branco */
    }

    .cupom-form select {
        appearance: none; /* Remove o estilo padrão de alguns navegadores */
        -webkit-appearance: none; /* Remove o estilo padrão no Safari */
        -moz-appearance: none; /* Remove o estilo padrão no Firefox */
        cursor: pointer; /* Cursor de mão ao passar o mouse */
    }

    .cupom-form button {
        margin-top: 20px; /* Espaço acima do botão */
        padding: 10px 15px; /* Padding do botão */
        background-color: #FA8032; /* Cor do botão */
        color: white; /* Cor do texto do botão */
        border: none; /* Sem borda */
        border-radius: 5px; /* Bordas arredondadas */
        cursor: pointer; /* Cursor de mão ao passar o mouse */
    }

    .cupom-form button:hover {
        background-color: #e07e30; /* Cor do botão ao passar o mouse */
    }



</style>

</body>
</html>
