<!DOCTYPE html>
<html lang="pt-br">

@include('components.head', ['title'=>'Cardápio'])

<body>
@include('components.navbar', ['theme'=>'Faça seu pedido!']);

    <!-- Menu Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Food Menu</h5>
                <h1 class="mb-5">Most Popular Items</h1>
            </div>
            <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1-up">
                            <i class="fa fa-cheese fa-2x text-primary"></i>
                            <div class="ps-3">
                                <small class="text-body">Pizzas</small>
                                <h6 class="mt-n1 mb-0">Salgadas</h6>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-2-up">
                            <i class="fa fa-candy-cane fa-2x text-primary"></i>
                            <div class="ps-3">
                                <small class="text-body">Pizzas</small>
                                <h6 class="mt-n1 mb-0">Doces</h6>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 me-0 pb-3" data-bs-toggle="pill" href="#tab-3-up">
                            <i class="fa fa-cocktail fa-2x text-primary"></i>
                            <div class="ps-3">
                                <small class="text-body">Bebidas</small>
                                <h6 class="mt-n1 mb-0">Diversas</h6>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1-up" class="tab-pane fade show p-0 active">
                        <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                            <li class="nav-item">
                                <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1">
                                    <i class="fa fa-pizza-slice fa-2x text-primary"></i>
                                    <div class="ps-3">
                                        <small class="text-body">Média</small>
                                        <h6 class="mt-n1 mb-0">6 pedaços</h6>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-2">
                                    <i class="fa fa-pizza-slice fa-2x text-primary"></i>
                                    <div class="ps-3">
                                        <small class="text-body">Grande</small>
                                        <h6 class="mt-n1 mb-0">8 pedaços</h6>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane fade show p-0 active">
                                <div class="row g-4">
                                    @foreach($salgmedia as $produto)
                                        <div class="col-lg-6">
                                            <div class="d-flex align-items-center">
                                                <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $produto->img) }}" alt="" style="width: 80px;">
                                                <div class="w-100 d-flex flex-column text-start ps-4">
                                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                        <span>{{ $produto->nome }}</span>
                                                        <span class="text-primary">R${{ $produto->preco }}</span>
                                                    </h5>
                                                    <small class="fst-italic">{{ $produto->descricao }}</small>
                                                    <!-- Botão para abrir o modal -->
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#salgmediaModal">
                                                        Comprar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="salgmediaModal" tabindex="-1" role="dialog" aria-labelledby="salgmediaModalLabel" aria-hidden="true"><div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content" style="background-color: #1d1b2c;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-white" id="salgmediaModalLabel">Adicionais</h5>
                                                    </div>
                                                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                        <!-- Textbox Hidden -->
                                                        <input id="salgmediaAdicional1Id" name="adicional1Id" value="" hidden>
                                                        <input id="salgmediaAdicional2Id" name="adicional2Id" value="" hidden>
                                                        <div class="container">
                                                            <div class="row">
                                                                @foreach($adicional as $item)
                                                                    <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                        <div class="card w-100">
                                                                            <div class="card-body d-flex flex-column text-center">
                                                                                <h6 class="card-title" style="font-size: 0.875rem;">{{ $item->nome }}</h6>
                                                                                <p class="card-text" style="color: #000000;">R$ {{ number_format($item->valor, 2, ',', '.') }}</p>
                                                                                <button class="btn btn-custom mt-auto" data-adicional-id="{{ $item->id }}" data-action="add">+</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <!-- Caixa de Texto para Observação -->
                                                        <div class="form-group mt-3">
                                                            <label for="salgmediaObservacao" class="text-white">Observação:</label>
                                                            <input type="text" class="form-control" id="salgmediaObservacao" name="observacao">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <!-- Botão Adicionar ao Carrinho -->
                                                        @auth
                                                            <form action="{{ route('pedido.adiciona', $produto->id) }}" method="POST" class="d-inline">
                                                                {{ csrf_field() }}
                                                                <button type="submit" class="btn btn-success">Adicionar ao carrinho</button>
                                                            </form>
                                                        @endauth
                                                        <!-- Botão Fechar -->
                                                        <button type="button" onclick="location.reload()" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    @foreach($salggrande as $produto)
                                        <div class="col-lg-6">
                                            <div class="d-flex align-items-center">
                                                <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $produto->img) }}" alt="" style="width: 80px;">
                                                <div class="w-100 d-flex flex-column text-start ps-4">
                                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                        <span>{{ $produto->nome }}</span>
                                                        <span class="text-primary">R${{ $produto->preco }}</span>
                                                    </h5>
                                                    <small class="fst-italic">{{ $produto->descricao }}</small>
                                                    <!-- Botão para abrir o modal -->
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#salggrandeModal">
                                                        Comprar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="salggrandeModal" tabindex="-1" role="dialog" aria-labelledby="salggrandeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content" style="background-color: #1d1b2c;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-white" id="salggrandeModalLabel">Adicionais</h5>
                                                    </div>
                                                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                        <!-- Textbox Hidden -->
                                                        <input id="salggrandeAdicional1Id" name="adicional1Id" value="" hidden>
                                                        <input id="salggrandeAdicional2Id" name="adicional2Id" value="" hidden>
                                                        <div class="container">
                                                            <div class="row">
                                                                @foreach($adicional as $item)
                                                                    <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                        <div class="card w-100">
                                                                            <div class="card-body d-flex flex-column text-center">
                                                                                <h6 class="card-title" style="font-size: 0.875rem;">{{ $item->nome }}</h6>
                                                                                <p class="card-text" style="color: #000000;">R$ {{ number_format($item->valor, 2, ',', '.') }}</p>
                                                                                <button class="btn btn-custom mt-auto" data-adicional-id="{{ $item->id }}" data-action="add">+</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <!-- Caixa de Texto para Observação -->
                                                        <div class="form-group mt-3">
                                                            <label for="salggrandeObservacao" class="text-white">Observação:</label>
                                                            <input type="text" class="form-control" id="salggrandeObservacao" name="observacao">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <!-- Botão Adicionar ao Carrinho -->
                                                        @auth
                                                            <form action="{{ route('pedido.adiciona', $produto->id) }}" method="POST" class="d-inline">
                                                                {{ csrf_field() }}
                                                                <button type="submit" class="btn btn-success">Adicionar ao carrinho</button>
                                                            </form>
                                                        @endauth
                                                        <!-- Botão Fechar -->
                                                        <button type="button" onclick="location.reload()" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab-2-up" class="tab-pane fade show p-0">
                        <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                            <li class="nav-item">
                                <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-3">
                                    <i class="fa fa-pizza-slice fa-2x text-primary"></i>
                                    <div class="ps-3">
                                        <small class="text-body">Média</small>
                                        <h6 class="mt-n1 mb-0">6 pedaços</h6>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-4">
                                    <i class="fa fa-pizza-slice fa-2x text-primary"></i>
                                    <div class="ps-3">
                                        <small class="text-body">Grande</small>
                                        <h6 class="mt-n1 mb-0">8 pedaços</h6>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-3" class="tab-pane fade show p-0 active">
                                <div class="row g-4">
                                    @foreach($docemedia as $produto)
                                        <div class="col-lg-6">
                                            <div class="d-flex align-items-center">
                                                <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $produto->img) }}" alt="" style="width: 80px;">
                                                <div class="w-100 d-flex flex-column text-start ps-4">
                                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                        <span>{{ $produto->nome }}</span>
                                                        <span class="text-primary">R${{ $produto->preco }}</span>
                                                    </h5>
                                                    <small class="fst-italic">{{ $produto->descricao }}</small>
                                                    <!-- Botão para abrir o modal -->
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#docemediaModal">
                                                        Comprar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="docemediaModal" tabindex="-1" role="dialog" aria-labelledby="docemediaModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content" style="background-color: #1d1b2c;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-white" id="docemediaModalLabel">Adicionais</h5>
                                                    </div>
                                                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                        <!-- Textbox Hidden -->
                                                        <input id="docemediaAdicional1Id" name="adicional1Id" value="" hidden>
                                                        <input id="docemediaAdicional2Id" name="adicional2Id" value="" hidden>
                                                        <div class="container">
                                                            <div class="row">
                                                                @foreach($adicional as $item)
                                                                    <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                        <div class="card w-100">
                                                                            <div class="card-body d-flex flex-column text-center">
                                                                                <h6 class="card-title" style="font-size: 0.875rem;">{{ $item->nome }}</h6>
                                                                                <p class="card-text" style="color: #000000;">R$ {{ number_format($item->valor, 2, ',', '.') }}</p>
                                                                                <button class="btn btn-custom mt-auto" data-adicional-id="{{ $item->id }}" data-action="add">+</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <!-- Caixa de Texto para Observação -->
                                                        <div class="form-group mt-3">
                                                            <label for="docemediaObservacao" class="text-white">Observação:</label>
                                                            <input type="text" class="form-control" id="docemediaObservacao" name="observacao">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <!-- Botão Adicionar ao Carrinho -->
                                                        @auth
                                                            <form action="{{ route('pedido.adiciona', $produto->id) }}" method="POST" class="d-inline">
                                                                {{ csrf_field() }}
                                                                <button type="submit" class="btn btn-success">Adicionar ao carrinho</button>
                                                            </form>
                                                        @endauth
                                                        <!-- Botão Fechar -->
                                                        <button type="button" onclick="location.reload()" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div id="tab-4" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    @foreach($docegrande as $produto)
                                        <div class="col-lg-6">
                                            <div class="d-flex align-items-center">
                                                <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $produto->img) }}" alt="" style="width: 80px;">
                                                <div class="w-100 d-flex flex-column text-start ps-4">
                                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                        <span>{{ $produto->nome }}</span>
                                                        <span class="text-primary">R${{ $produto->preco }}</span>
                                                    </h5>
                                                    <small class="fst-italic">{{ $produto->descricao }}</small>
                                                    <!-- Botão para abrir o modal -->
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#docegrandeModal">
                                                        Comprar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="docegrandeModal" tabindex="-1" role="dialog" aria-labelledby="docegrandeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content" style="background-color: #1d1b2c;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-white" id="docegrandeModalLabel">Adicionais</h5>
                                                    </div>
                                                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                        <!-- Textbox Hidden -->
                                                        <input id="docegrandeAdicional1Id" name="adicional1Id" value="" hidden>
                                                        <input id="docegrandeAdicional2Id" name="adicional2Id" value="" hidden>
                                                        <div class="container">
                                                            <div class="row">
                                                                @foreach($adicional as $item)
                                                                    <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                        <div class="card w-100">
                                                                            <div class="card-body d-flex flex-column text-center">
                                                                                <h6 class="card-title" style="font-size: 0.875rem;">{{ $item->nome }}</h6>
                                                                                <p class="card-text" style="color: #000000;">R$ {{ number_format($item->valor, 2, ',', '.') }}</p>
                                                                                <button class="btn btn-custom mt-auto" data-adicional-id="{{ $item->id }}" data-action="add">+</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <!-- Caixa de Texto para Observação -->
                                                        <div class="form-group mt-3">
                                                            <label for="docegrandeObservacao" class="text-white">Observação:</label>
                                                            <input type="text" class="form-control" id="docegrandeObservacao" name="observacao">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <!-- Botão Adicionar ao Carrinho -->
                                                        @auth
                                                            <form action="{{ route('pedido.adiciona', $produto->id) }}" method="POST" class="d-inline">
                                                                {{ csrf_field() }}
                                                                <button type="submit" class="btn btn-success">Adicionar ao carrinho</button>
                                                            </form>
                                                        @endauth
                                                        <!-- Botão Fechar -->
                                                        <button type="button" onclick="location.reload()" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab-3-up" class="tab-pane fade show p-0">
                        <div class="tab-content">
                            <div id="tab-bebidas" class="tab-pane fade show p-0 active">
                                <div class="row g-4">
                                    @foreach($bebidas as $produto)
                                        <div class="col-lg-6">
                                            <div class="d-flex align-items-center">
                                                <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $produto->img) }}" alt="" style="width: 80px;">
                                                <div class="w-100 d-flex flex-column text-start ps-4">
                                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                        <span>{{ $produto->nome }}</span>
                                                        <span class="text-primary">R${{ $produto->preco  }}</span>
                                                    </h5>
                                                    <small class="fst-italic">{{ $produto->descricao }}</small>
                                                    @auth
                                                        <form action="{{ route('pedido.adiciona', $produto->id) }}" method="POST">
                                                            {{ csrf_field() }}
                                                            <button type="submit" value="adicionar">Adicionar ao carrinho</button>
                                                        </form>
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu End -->

{{--<!-- JavaScript para Gerenciar Adicionais, Atualizar Campos Ocultos e Resetar o Modal -->--}}
{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', function () {--}}
{{--        const maxAdicionais = 2;--}}

{{--        function updateButtonsState() {--}}
{{--            const campoOculto1 = document.getElementById('adicional1Id').value;--}}
{{--            const campoOculto2 = document.getElementById('adicional2Id').value;--}}
{{--            const buttons = document.querySelectorAll('button[data-adicional-id]');--}}

{{--            if (campoOculto1 && campoOculto2) {--}}
{{--                buttons.forEach(button => {--}}
{{--                    if (button.getAttribute('data-action') === 'add') {--}}
{{--                        button.disabled = true;--}}
{{--                    }--}}
{{--                });--}}
{{--            } else {--}}
{{--                buttons.forEach(button => button.disabled = false);--}}
{{--            }--}}
{{--        }--}}

{{--        function resetModal() {--}}
{{--            // Limpa os campos ocultos--}}
{{--            document.getElementById('adicional1Id').value = '';--}}
{{--            document.getElementById('adicional2Id').value = '';--}}

{{--            // Restaura os botões para o estado inicial--}}
{{--            document.querySelectorAll('button[data-adicional-id]').forEach(button => {--}}
{{--                button.textContent = '+';--}}
{{--                button.setAttribute('data-action', 'add');--}}
{{--                button.disabled = false;--}}
{{--            });--}}
{{--        }--}}

{{--        // Evento para quando o modal é mostrado--}}
{{--        $('#adicionaisModal').on('show.bs.modal', function () {--}}
{{--            resetModal();--}}
{{--        });--}}

{{--        document.querySelectorAll('button[data-adicional-id]').forEach(function(button) {--}}
{{--            button.addEventListener('click', function() {--}}
{{--                const adicionalId = this.getAttribute('data-adicional-id'); // Obtém o ID do adicional--}}
{{--                const action = this.getAttribute('data-action'); // Obtém a ação atual do botão--}}
{{--                const campoOculto1 = document.getElementById('adicional1Id');--}}
{{--                const campoOculto2 = document.getElementById('adicional2Id');--}}

{{--                if (action === 'add') {--}}
{{--                    if (!campoOculto1.value) {--}}
{{--                        campoOculto1.value = adicionalId;--}}
{{--                    } else if (!campoOculto2.value) {--}}
{{--                        campoOculto2.value = adicionalId;--}}
{{--                    }--}}
{{--                    this.textContent = 'Remover';--}}
{{--                    this.setAttribute('data-action', 'remove');--}}
{{--                } else {--}}
{{--                    if (campoOculto1.value === adicionalId) {--}}
{{--                        campoOculto1.value = campoOculto2.value;--}}
{{--                        campoOculto2.value = '';--}}
{{--                    } else if (campoOculto2.value === adicionalId) {--}}
{{--                        campoOculto2.value = '';--}}
{{--                    }--}}
{{--                    this.textContent = '+';--}}
{{--                    this.setAttribute('data-action', 'add');--}}
{{--                }--}}

{{--                // Atualiza o estado dos botões após a alteração--}}
{{--                updateButtonsState();--}}
{{--            });--}}
{{--        });--}}

{{--        // Inicializa o estado dos botões ao carregar a página--}}
{{--        updateButtonsState();--}}
{{--    });--}}
{{--</script>--}}

<!-- JavaScript para Gerenciar Adicionais, Atualizar Campos Ocultos e Resetar o Modal salgmediaModal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const maxAdicionais = 2;

        function updateButtonsState() {
            const campoOculto1 = document.getElementById('salgmediaAdicional1Id').value;
            const campoOculto2 = document.getElementById('salgmediaAdicional2Id').value;
            const buttons = document.querySelectorAll('#salgmediaModal button[data-adicional-id]');

            if (campoOculto1 && campoOculto2) {
                buttons.forEach(button => {
                    if (button.getAttribute('data-action') === 'add') {
                        button.disabled = true;
                    }
                });
            } else {
                buttons.forEach(button => button.disabled = false);
            }
        }

        function resetModal() {
            // Limpa os campos ocultos
            document.getElementById('salgmediaAdicional1Id').value = '';
            document.getElementById('salgmediaAdicional2Id').value = '';

            // Restaura os botões para o estado inicial
            document.querySelectorAll('#salgmediaModal button[data-adicional-id]').forEach(button => {
                button.textContent = '+';
                button.setAttribute('data-action', 'add');
                button.disabled = false;
            });
        }

        // Evento para quando o modal é mostrado
        $('#salgmediaModal').on('show.bs.modal', function () {
            resetModal();
        });

        $('#salgmediaModal').on('hide.bs.modal', function (event) {
            // Verifica se o modal foi fechado por um clique fora dele
            if ($(event.target).hasClass('modal') && $(event.target).is('#salgmediaModal')) {
                location.reload();
            }
        });

        document.querySelectorAll('#salgmediaModal button[data-adicional-id]').forEach(function(button) {
            button.addEventListener('click', function() {
                const adicionalId = this.getAttribute('data-adicional-id'); // Obtém o ID do adicional
                const action = this.getAttribute('data-action'); // Obtém a ação atual do botão
                const campoOculto1 = document.getElementById('salgmediaAdicional1Id');
                const campoOculto2 = document.getElementById('salgmediaAdicional2Id');

                if (action === 'add') {
                    if (!campoOculto1.value) {
                        campoOculto1.value = adicionalId;
                    } else if (!campoOculto2.value) {
                        campoOculto2.value = adicionalId;
                    }
                    this.textContent = 'Remover';
                    this.setAttribute('data-action', 'remove');
                } else {
                    if (campoOculto1.value === adicionalId) {
                        campoOculto1.value = campoOculto2.value;
                        campoOculto2.value = '';
                    } else if (campoOculto2.value === adicionalId) {
                        campoOculto2.value = '';
                    }
                    this.textContent = '+';
                    this.setAttribute('data-action', 'add');
                }

                // Atualiza o estado dos botões após a alteração
                updateButtonsState();
            });
        });

        // Inicializa o estado dos botões ao carregar a página
        updateButtonsState();
    });
</script>


<!-- JavaScript para Gerenciar Adicionais, Atualizar Campos Ocultos e Resetar o Modal salggrandeModal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const maxAdicionais = 2;

        function updateButtonsState() {
            const campoOculto1 = document.getElementById('salggrandeAdicional1Id').value;
            const campoOculto2 = document.getElementById('salggrandeAdicional2Id').value;
            const buttons = document.querySelectorAll('#salggrandeModal button[data-adicional-id]');

            if (campoOculto1 && campoOculto2) {
                buttons.forEach(button => {
                    if (button.getAttribute('data-action') === 'add') {
                        button.disabled = true;
                    }
                });
            } else {
                buttons.forEach(button => button.disabled = false);
            }
        }

        function resetModal() {
            // Limpa os campos ocultos
            document.getElementById('salggrandeAdicional1Id').value = '';
            document.getElementById('salggrandeAdicional2Id').value = '';

            // Restaura os botões para o estado inicial
            document.querySelectorAll('#salggrandeModal button[data-adicional-id]').forEach(button => {
                button.textContent = '+';
                button.setAttribute('data-action', 'add');
                button.disabled = false;
            });
        }

        // Evento para quando o modal é mostrado
        $('#salggrandeModal').on('show.bs.modal', function () {
            resetModal();
        });

        document.querySelectorAll('#salggrandeModal button[data-adicional-id]').forEach(function(button) {
            button.addEventListener('click', function() {
                const adicionalId = this.getAttribute('data-adicional-id'); // Obtém o ID do adicional
                const action = this.getAttribute('data-action'); // Obtém a ação atual do botão
                const campoOculto1 = document.getElementById('salggrandeAdicional1Id');
                const campoOculto2 = document.getElementById('salggrandeAdicional2Id');

                if (action === 'add') {
                    if (!campoOculto1.value) {
                        campoOculto1.value = adicionalId;
                    } else if (!campoOculto2.value) {
                        campoOculto2.value = adicionalId;
                    }
                    this.textContent = 'Remover';
                    this.setAttribute('data-action', 'remove');
                } else {
                    if (campoOculto1.value === adicionalId) {
                        campoOculto1.value = campoOculto2.value;
                        campoOculto2.value = '';
                    } else if (campoOculto2.value === adicionalId) {
                        campoOculto2.value = '';
                    }
                    this.textContent = '+';
                    this.setAttribute('data-action', 'add');
                }

                // Atualiza o estado dos botões após a alteração
                updateButtonsState();
            });
        });

        // Inicializa o estado dos botões ao carregar a página
        updateButtonsState();
    });
</script>

<!-- JavaScript para Gerenciar Adicionais, Atualizar Campos Ocultos e Resetar o Modal docemediaModal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const maxAdicionais = 2;

        function updateButtonsState() {
            const campoOculto1 = document.getElementById('docemediaAdicional1Id').value;
            const campoOculto2 = document.getElementById('docemediaAdicional2Id').value;
            const buttons = document.querySelectorAll('#docemediaModal button[data-adicional-id]');

            if (campoOculto1 && campoOculto2) {
                buttons.forEach(button => {
                    if (button.getAttribute('data-action') === 'add') {
                        button.disabled = true;
                    }
                });
            } else {
                buttons.forEach(button => button.disabled = false);
            }
        }

        function resetModal() {
            // Limpa os campos ocultos
            document.getElementById('docemediaAdicional1Id').value = '';
            document.getElementById('docemediaAdicional2Id').value = '';

            // Restaura os botões para o estado inicial
            document.querySelectorAll('#docemediaModal button[data-adicional-id]').forEach(button => {
                button.textContent = '+';
                button.setAttribute('data-action', 'add');
                button.disabled = false;
            });
        }

        // Evento para quando o modal é mostrado
        $('#docemediaModal').on('show.bs.modal', function () {
            resetModal();
        });

        document.querySelectorAll('#docemediaModal button[data-adicional-id]').forEach(function(button) {
            button.addEventListener('click', function() {
                const adicionalId = this.getAttribute('data-adicional-id'); // Obtém o ID do adicional
                const action = this.getAttribute('data-action'); // Obtém a ação atual do botão
                const campoOculto1 = document.getElementById('docemediaAdicional1Id');
                const campoOculto2 = document.getElementById('docemediaAdicional2Id');

                if (action === 'add') {
                    if (!campoOculto1.value) {
                        campoOculto1.value = adicionalId;
                    } else if (!campoOculto2.value) {
                        campoOculto2.value = adicionalId;
                    }
                    this.textContent = 'Remover';
                    this.setAttribute('data-action', 'remove');
                } else {
                    if (campoOculto1.value === adicionalId) {
                        campoOculto1.value = campoOculto2.value;
                        campoOculto2.value = '';
                    } else if (campoOculto2.value === adicionalId) {
                        campoOculto2.value = '';
                    }
                    this.textContent = '+';
                    this.setAttribute('data-action', 'add');
                }

                // Atualiza o estado dos botões após a alteração
                updateButtonsState();
            });
        });

        // Inicializa o estado dos botões ao carregar a página
        updateButtonsState();
    });
</script>

<!-- JavaScript para Gerenciar Adicionais, Atualizar Campos Ocultos e Resetar o Modal docegrandeModal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const maxAdicionais = 2;

        function updateButtonsState() {
            const campoOculto1 = document.getElementById('docegrandeAdicional1Id').value;
            const campoOculto2 = document.getElementById('docegrandeAdicional2Id').value;
            const buttons = document.querySelectorAll('#docegrandeModal button[data-adicional-id]');

            if (campoOculto1 && campoOculto2) {
                buttons.forEach(button => {
                    if (button.getAttribute('data-action') === 'add') {
                        button.disabled = true;
                    }
                });
            } else {
                buttons.forEach(button => button.disabled = false);
            }
        }

        function resetModal() {
            // Limpa os campos ocultos
            document.getElementById('docegrandeAdicional1Id').value = '';
            document.getElementById('docegrandeAdicional2Id').value = '';

            // Restaura os botões para o estado inicial
            document.querySelectorAll('#docegrandeModal button[data-adicional-id]').forEach(button => {
                button.textContent = '+';
                button.setAttribute('data-action', 'add');
                button.disabled = false;
            });
        }

        // Evento para quando o modal é mostrado
        $('#docegrandeModal').on('show.bs.modal', function () {
            resetModal();
        });

        document.querySelectorAll('#docegrandeModal button[data-adicional-id]').forEach(function(button) {
            button.addEventListener('click', function() {
                const adicionalId = this.getAttribute('data-adicional-id'); // Obtém o ID do adicional
                const action = this.getAttribute('data-action'); // Obtém a ação atual do botão
                const campoOculto1 = document.getElementById('docegrandeAdicional1Id');
                const campoOculto2 = document.getElementById('docegrandeAdicional2Id');

                if (action === 'add') {
                    if (!campoOculto1.value) {
                        campoOculto1.value = adicionalId;
                    } else if (!campoOculto2.value) {
                        campoOculto2.value = adicionalId;
                    }
                    this.textContent = 'Remover';
                    this.setAttribute('data-action', 'remove');
                } else {
                    if (campoOculto1.value === adicionalId) {
                        campoOculto1.value = campoOculto2.value;
                        campoOculto2.value = '';
                    } else if (campoOculto2.value === adicionalId) {
                        campoOculto2.value = '';
                    }
                    this.textContent = '+';
                    this.setAttribute('data-action', 'add');
                }

                // Atualiza o estado dos botões após a alteração
                updateButtonsState();
            });
        });

        // Inicializa o estado dos botões ao carregar a página
        updateButtonsState();
    });
</script>

<!-- Custom CSS -->
<style>
    .modal-dialog {
        max-width: 80%; /* Ajusta a largura do modal para 80% da tela */
    }
    .modal-content {
        background-color: #1d1b2c;
        color: #ffffff;
    }
    .btn-custom {
        background-color: #fea116;
        color: #ffffff;
        border: none;
    }
    .btn-custom:hover {
        background-color: #e6950f;
    }
    .modal-body {
        max-height: 70vh; /* Limita a altura máxima do conteúdo do modal */
        overflow-y: auto; /* Adiciona rolagem vertical se necessário */
    }
</style>

<!-- jQuery e Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    @include('components.footer');

</body>

</html>
