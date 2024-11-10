<!DOCTYPE html>
<html lang="pt-br">

@include('admin.components.headadmin', ['title'=>'Pedidos'])

<div>
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

        @if(auth()->user()->admin)
        <div class="text-center mt-4">
            <form action="{{ route('pedido.gerarPdf') }}" method="GET">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-relatorio">Relatório de Pedidos</button>
            </form>
        </div>
        @endif

        <div class="grid-pedidos">
            @foreach($pedidos as $p)
                <div class="pedido-item">
                    <div class="pedido-info">
                        <span>Pedido: #{{ $p->id }}<br></span>
                        <!-- Mostrando o usuário que fez o pedido -->
                        <span>Usuário: {{ $p->usuario->nome }}</span> <br>

                        <div class="produto-div">
                        @foreach($p->produtos as $produto)
                            <span>{{ $produto->nome }} </span>
                            <span>{{ number_format($produto->preco, 2, ',', '.') }}<br></span>

                            @if($produto->pivot->eMeioaMeio)
                                <span>{{ $produto->pivot->metade->nome }} </span>
                                <span>{{ number_format($produto->pivot->metade->preco, 2, ',', '.') }}<br></span>
                            @endif

                            @if($produto->pivot->adicional1 != null)
                                <span>Adicional 1:</span>
                                <span>{{ $produto->pivot->adicional1->nome }}</span>
                                <span>{{ number_format($produto->pivot->adicional1->valor, 2, ',', '.') }}<br></span>
                            @endif

                            @if($produto->pivot->adicional2 != null)
                                <span>Adicional 2:</span>
                                <span>{{ $produto->pivot->adicional2->nome }}</span>
                                <span>{{ number_format($produto->pivot->adicional2->valor, 2, ',', '.') }}<br></span>
                            @endif

                            <span>{{ $produto->pivot->observacao }}</span>
                            <span>{{ $produto->tamanho }}</span>
                            <br>
                        @endforeach
                        </div>


                        <span>Status: {{ $p->situacao }}</span> <br>
                        <span>Total dos produtos: R$ {{ number_format($p->subtotal - $p->taxa_entrega, 2, ',', '.') }}</span> <br>
                        <span>Total: R$ {{ number_format($p->subtotal, 2, ',', '.') }}</span> <br>
                        @if($p->retirada == true)
                            <span>Retirada no local</span>
                        @else
                            <span>Taxa de entrega: R$ {{ number_format($p->taxa_entrega, 2, ',', '.') }}</span> <br>
                            <span>{{ $p->bairro->cidade }} - {{ $p->endereco }}</span> <br>
                        @endif

                        @if($p->cupomId != null)
                            <span>Cupom aplicado: </span>
                            <span>{{ $p->cupom->nome }} - </span>
                            <span>{{ $p->cupom->valor }}% nas {{ $p->cupom->categorias->first()->descricao }}</span>
                        @endif
                    </div>

                    <!-- Verifica se a situação é diferente de 'finalizado' para exibir os botões de ação -->
                    @if(in_array($p->situacao, ['pendente', 'em preparo', 'saiu para entrega', 'pronto para retirada']))

                        <div class="pedido-actions">
                            @if($p->situacao === 'pendente')
                                <button type="button" class="btn-remover" onclick="showCancelPendenteModal({{ $p->id }})">Cancelar</button>
                            @else
                                <!-- Botão para cancelar o pedido -->
                                <button type="button" class="btn-remover" onclick="showCancelModal({{ $p->id }})">Cancelar</button>
                            @endif


                            <!-- Botão para voltar situação -->
                            <form action="{{ route('pedido.voltarSituacao', $p->id) }}" method="POST" class="editar-form">
                                {{ csrf_field() }}
                                <button type="submit" class="btn-editar"
                                        @if($p->situacao === 'pendente') disabled @endif>Voltar status</button>
                            </form>

                            <!-- Botão para avançar situação -->
                            <form action="{{ route('pedido.avancarSituacao', $p->id) }}" method="POST" class="editar-form">
                                {{ csrf_field() }}
                                <button type="submit" class="btn-editar"
                                        @if($p->situacao === 'finalizado') disabled @endif>Avançar status</button>
                            </form>
                        </div>
                    @else
                        <div class="pedido-actions">
                    <span style="border: #ffffff 1px solid; border-radius: 8px; padding: 10px; background-color: white; color: black">
                        Este pedido foi finalizado ou cancelado e não pode mais ser editado.
                    </span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Modal para o motivo do cancelamento -->
        <div id="cancelPendenteModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close" onclick="location.reload()">&times;</span>
                <h2>Motivo do Cancelamento</h2>
                <form id="cancelPendenteForm" action="" method="POST">
                    {{ csrf_field() }}
                    <textarea name="motivo" rows="4" placeholder="Escreva o motivo do cancelamento" required></textarea><br>
                    <button type="submit" class="btn-cancelar">Cancelar Pedido</button>
                </form>
            </div>
        </div>

        <!-- Modal para o motivo do cancelamento -->
        <div id="cancelModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span>Despesa de cancelamento: 90% do total do pedido</span>
                <span class="close" onclick="location.reload()">&times;</span>
                <h2>Motivo do Cancelamento</h2>
                <form id="cancelForm" action="" method="POST">
                    {{ csrf_field() }}
                    <textarea name="motivo" rows="4" placeholder="Escreva o motivo do cancelamento" required></textarea><br>
                    <button type="submit" class="btn-cancelar">Cancelar Pedido</button>
                </form>
            </div>
        </div>

        <!-- JavaScript para controlar o modal -->
        <script>
            function showCancelModal(pedidoId) {
                // Definir a ação do formulário com a rota do pedido correspondente
                document.getElementById('cancelForm').action = '/pedido/cancelar/' + pedidoId;
                // Exibir o modal
                document.getElementById('cancelModal').style.display = 'block';
            }

            // Fechar o modal ao clicar fora da janela do modal
            window.onclick = function(event) {
                if (event.target == document.getElementById('cancelModal')) {
                    document.getElementById('cancelModal').style.display = 'none';
                }
            }

            function showCancelPendenteModal(pedidoId) {
                // Definir a ação do formulário com a rota do pedido correspondente
                document.getElementById('cancelPendenteForm').action = '/pedido/cancelarpendente/' + pedidoId;
                // Exibir o modal
                document.getElementById('cancelPendenteModal').style.display = 'block';
            }

            // Fechar o modal ao clicar fora da janela do modal
            window.onclick = function(event) {
                if (event.target == document.getElementById('cancelPendenteModal')) {
                    document.getElementById('cancelPendenteModal').style.display = 'none';
                }
            }
        </script>

        <!-- CSS básico para o modal -->
        <style>
            /* Estilos para o modal */
            .modal {
                display: none; /* Inicialmente escondido */
                position: fixed; /* Posicionamento fixo na tela */
                z-index: 1; /* Ficar em cima de outros elementos */
                left: 0;
                top: 0;
                width: 100%; /* Ocupa a largura inteira da tela */
                height: 100%; /* Ocupa a altura inteira da tela */
                background-color: rgba(0, 0, 0, 0.5); /* Fundo escuro com transparência */
            }

            .modal-content {
                background-color: #1e293b; /* Fundo branco para o conteúdo */
                margin: 10% auto; /* Margem automática para centralizar verticalmente */
                padding: 20px; /* Padding interno */
                border: 1px solid #ced4da; /* Borda leve e cinza */
                border-radius: 8px; /* Bordas arredondadas */
                width: 40%; /* Largura do modal */
                text-align: center; /* Centraliza o texto */
            }

            .close {
                color: #aaa; /* Cor cinza para o botão fechar */
                float: right; /* Alinha o botão fechar à direita */
                font-size: 28px; /* Tamanho da fonte */
                font-weight: bold; /* Negrito */
                cursor: pointer; /* Cursor de mão ao passar o mouse */
            }

            .close:hover,
            .close:focus {
                color: black; /* Cor preta ao passar o mouse ou focar */
                text-decoration: none; /* Remove sublinhado */
            }

            .btn-cancelar {
                background-color: #FA8032; /* Cor de fundo semelhante ao botão principal */
                color: white; /* Cor do texto branca */
                border: none; /* Sem borda */
                padding: 10px 15px; /* Padding maior para o botão */
                border-radius: 8px; /* Bordas arredondadas */
                cursor: pointer; /* Cursor de mão ao passar o mouse */
                transition: background-color 0.3s; /* Transição suave para hover */
                margin-top: 10px; /* Margem no topo do botão */
            }

            .btn-cancelar:hover {
                background-color: #e88c2f; /* Cor ao passar o mouse */
            }

            textarea {
                width: 100%; /* Largura total */
                padding: 10px; /* Padding interno */
                border: 1px solid #ced4da; /* Borda leve */
                border-radius: 8px; /* Bordas arredondadas */
                margin-top: 10px; /* Margem superior */
                font-size: 14px; /* Tamanho da fonte */
                box-sizing: border-box; /* Para incluir o padding na largura total */
            }

            .modal-content h2 {
                color: #FA8032; /* Título com a mesma cor dos botões */
            }

        </style>

    </div>
</div>
    <style>
        .grid-pedidos {
            display: grid; /* Define o contêiner como uma grid */
            grid-template-columns: repeat(3, 1fr); /* Cria 3 colunas de largura igual */
            gap: 20px; /* Espaço entre os itens */
            margin: 0 auto; /* Centraliza o grid */
            width: 100%; /* Ajuste a largura conforme necessário */
        }

        .pedido-item {
            padding: 15px; /* Espaçamento interno */
            border: 1px solid #ced4da; /* Borda leve */
            border-radius: 8px; /* Bordas arredondadas */
            text-align: center; /* Centraliza o texto */
            display: flex; /* Usa flexbox para organizar elementos internamente */
            flex-direction: column; /* Disposição vertical dos itens */
            align-items: center; /* Centraliza os itens no eixo horizontal */
        }

        .pedido-info {
            margin-bottom: 10px; /* Espaço abaixo das informações do usuário */
        }

        .pedido-actions {
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

        .produto-div{
            border-radius: 8px;
            border: white 1px solid;
        }
    </style>
</body>
</html>
