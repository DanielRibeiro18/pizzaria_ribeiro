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
                                    @if($produto->ativo)
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $produto->img) }}" alt="" style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>{{ $produto->nome }}</span>
                                                    <span>
                        <input type="checkbox" id="salgmmeioameio{{ $produto->id }}" style="font-size: 12px;"> Meio a meio
                    </span>
                                                    <span class="text-primary">R$ {{ $produto->preco }}</span>
                                                </h5>
                                                <small class="fst-italic">{{ $produto->descricao }}</small>
                                                <!-- Botão para abrir o modal -->
                                                <button type="button" class="btn btn-primary" onclick="openModalsalgmedia('{{ $produto->id }}')">
                                                    Comprar
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="salgmediaModal{{ $produto->id }}" tabindex="-1" role="dialog" aria-labelledby="salgmediaModalLabel{{ $produto->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content" style="background-color: #1d1b2c;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-white" id="salgmediaModalLabel{{ $produto->id }}">Adicionais</h5>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                    <div class="container">
                                                        <div class="row">
                                                            @foreach($adicional as $item)
                                                                <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                    <div class="card w-100">
                                                                        <div class="card-body d-flex flex-column text-center">
                                                                            <h6 class="card-title" style="font-size: 0.875rem;">{{ $item->nome }}</h6>
                                                                            <p class="card-text" style="color: #000000;">R$ {{ number_format($item->valor, 2, ',', '.') }}</p>
                                                                            <button class="btn btn-custom" data-adicional-id="{{ $item->id }}" data-action="add">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @auth
                                                        <form action="{{ route('pedido.adiciona', $produto->id) }}" method="POST" class="d-inline">
                                                            {{ csrf_field() }}
                                                            <div class="form-group mt-3">
                                                                <label for="salgmediaObservacao" class="text-white">Observação:</label>
                                                                <input type="text" class="form-control" id="salgmediaObservacao{{ $produto->id }}" name="observacao">
                                                            </div>
                                                            <input id="salgmediaMetadeId{{ $produto->id }}" name="metadeId" value="" hidden>
                                                            <input id="salgmediaAdicional1Id{{ $produto->id }}" name="adicional1Id" value="" hidden>
                                                            <input id="salgmediaAdicional2Id{{ $produto->id }}" name="adicional2Id" value="" hidden>
                                                            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Adicionar ao carrinho</button>
                                                        </form>
                                                    @endauth
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="location.reload()" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Meio a Meio -->
                                    <div class="modal fade" id="salgmediaMeioModal{{ $produto->id }}" tabindex="-1" role="dialog" aria-labelledby="salgmediaMeioModalLabel{{ $produto->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content" style="background-color: #1d1b2c;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-white" id="salgmediaMeioModalLabel{{ $produto->id }}">Escolha a outra metade!</h5>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                    <div class="container">
                                                        <div class="row">
                                                            <h5 class="modal-title text-white" style="margin-bottom: 20px;">SABORES SALGADOS</h5>
                                                            @foreach($salgmedia as $salg)
                                                                @if($salg->id !== $produto->id and $salg->ativo)
                                                                    <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                        <div class="card w-100">
                                                                            <div class="card-body d-flex flex-column text-center">
                                                                                <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $salg->img) }}" alt="" style="width: 80px; margin: 0 auto;">
                                                                                <h6 class="card-title" style="font-size: 0.875rem;">{{ $salg->nome }}</h6>
                                                                                <p class="card-text" style="color: #000000;">R$ {{ number_format($salg->preco, 2, ',', '.') }}</p>
                                                                                <button class="btn btn-custom mt-auto" data-metade-id="{{ $salg->id }}" onclick="adicionarPizzaMetadesalgmedia({{ $salg->id }})">+</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="container">
                                                        <div class="row">
                                                            <h5 class="modal-title text-white" style="margin-bottom: 20px;">SABORES DOCES</h5>
                                                            @foreach($docemedia as $docem)
                                                                @if($docem->ativo)
                                                                <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                    <div class="card w-100">
                                                                        <div class="card-body d-flex flex-column text-center">
                                                                            <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $docem->img) }}" alt="" style="width: 80px; margin: 0 auto;">
                                                                            <h6 class="card-title" style="font-size: 0.875rem;">{{ $docem->nome }}</h6>
                                                                            <p class="card-text" style="color: #000000;">R$ {{ number_format($docem->preco, 2, ',', '.') }}</p>
                                                                            <button class="btn btn-custom mt-auto" data-metade-id="{{ $docem->id }}" onclick="adicionarPizzaMetadesalgmedia({{ $docem->id }})">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="location.reload()" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        // Função para abrir o modal de acordo com a seleção
                                        function openModalsalgmedia(produtoId) {
                                            pizzaIdSelecionada = produtoId; // Atualiza a variável com o ID do produto
                                            const meioAMeioCheckbox = document.getElementById('salgmmeioameio' + produtoId);
                                            if (meioAMeioCheckbox.checked) {
                                                $('#salgmediaMeioModal' + produtoId).modal('show');
                                            } else {
                                                $('#salgmediaModal' + produtoId).modal('show');
                                            }
                                        }

                                        function adicionarPizzaMetadesalgmedia(metadeId) {
                                            const campoMetadeId = document.getElementById('salgmediaMetadeId' + pizzaIdSelecionada);
                                            campoMetadeId.value = metadeId;

                                            // Fecha o modal "Meio a Meio"
                                            $('#salgmediaMeioModal' + pizzaIdSelecionada).modal('hide');

                                            // Abre o modal de adicionais
                                            $('#salgmediaModal' + pizzaIdSelecionada).modal('show');
                                        }

                                        document.addEventListener('DOMContentLoaded', function () {
                                            // Atualiza o estado dos botões de adicionar/remover
                                            function updateButtonsState(modalId) {
                                                const buttons = document.querySelectorAll(`#salgmediaModal${modalId} [data-action]`);
                                                const campoOculto1 = document.getElementById(`salgmediaAdicional1Id${modalId}`);
                                                const campoOculto2 = document.getElementById(`salgmediaAdicional2Id${modalId}`);

                                                // Desabilita botões se ambos os campos ocultos estão preenchidos
                                                if (campoOculto1.value && campoOculto2.value) {
                                                    buttons.forEach(button => {
                                                        if (button.getAttribute('data-action') === 'add') {
                                                            button.disabled = true;
                                                        }
                                                    });
                                                } else {
                                                    buttons.forEach(button => {
                                                        button.disabled = false; // Habilita botões novamente se houver espaço
                                                    });
                                                }
                                            }

                                            // Resetar o modal quando ele for fechado
                                            $(`.modal#salgmediaModal{{$produto->id}}`).on('hidden.bs.modal', function () {
                                                const modalId = this.id.replace('salgmediaModal', '');
                                                document.getElementById(`salgmediaAdicional1Id${modalId}`).value = '';
                                                document.getElementById(`salgmediaAdicional2Id${modalId}`).value = '';
                                                updateButtonsState(modalId); // Atualiza estado dos botões
                                            });

                                            // Evento para adicionar/remover adicionais
                                            document.querySelectorAll(`.modal#salgmediaModal{{$produto->id}}`).forEach(modal => {
                                                modal.addEventListener('click', function (event) {
                                                    const button = event.target.closest('[data-action]');
                                                    if (button) {
                                                        const adicionalId = button.getAttribute('data-adicional-id');
                                                        const modalId = this.id.replace('salgmediaModal', '');

                                                        const campoOculto1 = document.getElementById(`salgmediaAdicional1Id${modalId}`);
                                                        const campoOculto2 = document.getElementById(`salgmediaAdicional2Id${modalId}`);

                                                        if (button.getAttribute('data-action') === 'add') {
                                                            // Adiciona adicional na primeira ou segunda textbox oculta
                                                            if (!campoOculto1.value) {
                                                                campoOculto1.value = adicionalId; // Adiciona no primeiro campo
                                                                button.setAttribute('data-action', 'remove'); // Muda para remover
                                                                button.innerText = 'Remover'; // Troca texto
                                                            } else if (!campoOculto2.value && campoOculto1.value !== adicionalId) {
                                                                campoOculto2.value = adicionalId; // Adiciona no segundo campo
                                                                button.setAttribute('data-action', 'remove'); // Muda para remover
                                                                button.innerText = 'Remover'; // Troca texto
                                                            }
                                                        } else { // Caso contrário, removendo o adicional
                                                            // Remove o adicional correspondente ao botão clicado
                                                            if (campoOculto1.value === adicionalId) {
                                                                campoOculto1.value = ''; // Limpa campo se o primeiro adicional for removido
                                                            } else if (campoOculto2.value === adicionalId) {
                                                                campoOculto2.value = ''; // Limpa campo se o segundo adicional for removido
                                                            }

                                                            // Troca o botão de 'Remover' de volta para '+'
                                                            button.setAttribute('data-action', 'add'); // Muda para adicionar
                                                            button.innerText = '+'; // Troca texto
                                                        }

                                                        updateButtonsState(modalId); // Atualiza estado dos botões
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane fade show p-0">
                            <div class="row g-4">

                                @foreach($salggrande as $produto)
                                    @if($produto->ativo)
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $produto->img) }}" alt="" style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>{{ $produto->nome }}</span>
                                                    <span>
                        <input type="checkbox" id="salgmmeioameio{{ $produto->id }}" style="font-size: 12px;"> Meio a meio
                    </span>
                                                    <span class="text-primary">R$ {{ $produto->preco }}</span>
                                                </h5>
                                                <small class="fst-italic">{{ $produto->descricao }}</small>
                                                <!-- Botão para abrir o modal -->
                                                <button type="button" class="btn btn-primary" onclick="openModalsalggrande('{{ $produto->id }}')">
                                                    Comprar
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="salggrandeModal{{ $produto->id }}" tabindex="-1" role="dialog" aria-labelledby="salggrandeModalLabel{{ $produto->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content" style="background-color: #1d1b2c;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-white" id="salggrandeModalLabel{{ $produto->id }}">Adicionais</h5>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                    <div class="container">
                                                        <div class="row">
                                                            @foreach($adicional as $item)
                                                                <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                    <div class="card w-100">
                                                                        <div class="card-body d-flex flex-column text-center">
                                                                            <h6 class="card-title" style="font-size: 0.875rem;">{{ $item->nome }}</h6>
                                                                            <p class="card-text" style="color: #000000;">R$ {{ number_format($item->valor, 2, ',', '.') }}</p>
                                                                            <button class="btn btn-custom" data-adicional-id="{{ $item->id }}" data-action="add">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @auth
                                                        <form action="{{ route('pedido.adiciona', $produto->id) }}" method="POST" class="d-inline">
                                                            {{ csrf_field() }}
                                                            <div class="form-group mt-3">
                                                                <label for="salggrandeObservacao" class="text-white">Observação:</label>
                                                                <input type="text" class="form-control" id="salggrandeObservacao{{ $produto->id }}" name="observacao">
                                                            </div>
                                                            <input id="salggrandeMetadeId{{ $produto->id }}" name="metadeId" value="" hidden>
                                                            <input id="salggrandeAdicional1Id{{ $produto->id }}" name="adicional1Id" value="" hidden>
                                                            <input id="salggrandeAdicional2Id{{ $produto->id }}" name="adicional2Id" value="" hidden>
                                                            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Adicionar ao carrinho</button>
                                                        </form>
                                                    @endauth
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="location.reload()" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Meio a Meio -->
                                    <div class="modal fade" id="salggrandeMeioModal{{ $produto->id }}" tabindex="-1" role="dialog" aria-labelledby="salggrandeMeioModalLabel{{ $produto->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content" style="background-color: #1d1b2c;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-white" id="salggrandeMeioModalLabel{{ $produto->id }}">Escolha a outra metade!</h5>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                    <div class="container">
                                                        <div class="row">
                                                            <h5 class="modal-title text-white" style="margin-bottom: 20px;">SABORES SALGADOS</h5>
                                                            @foreach($salggrande as $salg)
                                                                @if($salg->id !== $produto->id and $salg->ativo)
                                                                    <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                        <div class="card w-100">
                                                                            <div class="card-body d-flex flex-column text-center">
                                                                                <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $salg->img) }}" alt="" style="width: 80px; margin: 0 auto;">
                                                                                <h6 class="card-title" style="font-size: 0.875rem;">{{ $salg->nome }}</h6>
                                                                                <p class="card-text" style="color: #000000;">R$ {{ number_format($salg->preco, 2, ',', '.') }}</p>
                                                                                <button class="btn btn-custom mt-auto" data-metade-id="{{ $salg->id }}" onclick="adicionarPizzaMetadesalggrande({{ $salg->id }})">+</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="container">
                                                        <div class="row">
                                                            <h5 class="modal-title text-white" style="margin-bottom: 20px;">SABORES DOCES</h5>
                                                            @foreach($docegrande as $doce)
                                                                @if($doce->ativo)
                                                                <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                    <div class="card w-100">
                                                                        <div class="card-body d-flex flex-column text-center">
                                                                            <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $doce->img) }}" alt="" style="width: 80px; margin: 0 auto;">
                                                                            <h6 class="card-title" style="font-size: 0.875rem;">{{ $doce->nome }}</h6>
                                                                            <p class="card-text" style="color: #000000;">R$ {{ number_format($doce->preco, 2, ',', '.') }}</p>
                                                                            <button class="btn btn-custom mt-auto" data-metade-id="{{ $doce->id }}" onclick="adicionarPizzaMetadesalggrande({{ $doce->id }})">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="location.reload()" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <script>
                                        // Função para abrir o modal de acordo com a seleção
                                        function openModalsalggrande(produtoId) {
                                            pizzaIdSelecionada = produtoId; // Atualiza a variável com o ID do produto
                                            const meioAMeioCheckbox = document.getElementById('salgmmeioameio' + produtoId);
                                            if (meioAMeioCheckbox.checked) {
                                                $('#salggrandeMeioModal' + produtoId).modal('show');
                                            } else {
                                                $('#salggrandeModal' + produtoId).modal('show');
                                            }
                                        }

                                        function adicionarPizzaMetadesalggrande(metadeId) {
                                            const campoMetadeId = document.getElementById('salggrandeMetadeId' + pizzaIdSelecionada);
                                            campoMetadeId.value = metadeId;

                                            // Fecha o modal "Meio a Meio"
                                            $('#salggrandeMeioModal' + pizzaIdSelecionada).modal('hide');

                                            // Abre o modal de adicionais
                                            $('#salggrandeModal' + pizzaIdSelecionada).modal('show');
                                        }

                                        document.addEventListener('DOMContentLoaded', function () {
                                            // Atualiza o estado dos botões de adicionar/remover
                                            function updateButtonsState(modalId) {
                                                const buttons = document.querySelectorAll(`#salggrandeModal${modalId} [data-action]`);
                                                const campoOculto1 = document.getElementById(`salggrandeAdicional1Id${modalId}`);
                                                const campoOculto2 = document.getElementById(`salggrandeAdicional2Id${modalId}`);

                                                // Desabilita botões se ambos os campos ocultos estão preenchidos
                                                if (campoOculto1.value && campoOculto2.value) {
                                                    buttons.forEach(button => {
                                                        if (button.getAttribute('data-action') === 'add') {
                                                            button.disabled = true;
                                                        }
                                                    });
                                                } else {
                                                    buttons.forEach(button => {
                                                        button.disabled = false; // Habilita botões novamente se houver espaço
                                                    });
                                                }
                                            }

                                            // Resetar o modal quando ele for fechado
                                            $(`.modal#salggrandeModal{{$produto->id}}`).on('hidden.bs.modal', function () {
                                                const modalId = this.id.replace('salggrandeModal', '');
                                                document.getElementById(`salggrandeAdicional1Id${modalId}`).value = '';
                                                document.getElementById(`salggrandeAdicional2Id${modalId}`).value = '';
                                                updateButtonsState(modalId); // Atualiza estado dos botões
                                            });

                                            // Evento para adicionar/remover adicionais
                                            document.querySelectorAll(`.modal#salggrandeModal{{$produto->id}}`).forEach(modal => {
                                                modal.addEventListener('click', function (event) {
                                                    const button = event.target.closest('[data-action]');
                                                    if (button) {
                                                        const adicionalId = button.getAttribute('data-adicional-id');
                                                        const modalId = this.id.replace('salggrandeModal', '');

                                                        const campoOculto1 = document.getElementById(`salggrandeAdicional1Id${modalId}`);
                                                        const campoOculto2 = document.getElementById(`salggrandeAdicional2Id${modalId}`);

                                                        if (button.getAttribute('data-action') === 'add') {
                                                            // Adiciona adicional na primeira ou segunda textbox oculta
                                                            if (!campoOculto1.value) {
                                                                campoOculto1.value = adicionalId; // Adiciona no primeiro campo
                                                                button.setAttribute('data-action', 'remove'); // Muda para remover
                                                                button.innerText = 'Remover'; // Troca texto
                                                            } else if (!campoOculto2.value && campoOculto1.value !== adicionalId) {
                                                                campoOculto2.value = adicionalId; // Adiciona no segundo campo
                                                                button.setAttribute('data-action', 'remove'); // Muda para remover
                                                                button.innerText = 'Remover'; // Troca texto
                                                            }
                                                        } else { // Caso contrário, removendo o adicional
                                                            // Remove o adicional correspondente ao botão clicado
                                                            if (campoOculto1.value === adicionalId) {
                                                                campoOculto1.value = ''; // Limpa campo se o primeiro adicional for removido
                                                            } else if (campoOculto2.value === adicionalId) {
                                                                campoOculto2.value = ''; // Limpa campo se o segundo adicional for removido
                                                            }

                                                            // Troca o botão de 'Remover' de volta para '+'
                                                            button.setAttribute('data-action', 'add'); // Muda para adicionar
                                                            button.innerText = '+'; // Troca texto
                                                        }

                                                        updateButtonsState(modalId); // Atualiza estado dos botões
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                    @endif
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
                                    @if($produto->ativo)
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $produto->img) }}" alt="" style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>{{ $produto->nome }}</span>
                                                    <span>
                        <input type="checkbox" id="salgmmeioameio{{ $produto->id }}" style="font-size: 12px;"> Meio a meio
                    </span>
                                                    <span class="text-primary">R$ {{ $produto->preco }}</span>
                                                </h5>
                                                <small class="fst-italic">{{ $produto->descricao }}</small>
                                                <!-- Botão para abrir o modal -->
                                                <button type="button" class="btn btn-primary" onclick="openModaldocemedia('{{ $produto->id }}')">
                                                    Comprar
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="docemediaModal{{ $produto->id }}" tabindex="-1" role="dialog" aria-labelledby="docemediaModalLabel{{ $produto->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content" style="background-color: #1d1b2c;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-white" id="docemediaModalLabel{{ $produto->id }}">Adicionais</h5>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                    <div class="container">
                                                        <div class="row">
                                                            @foreach($adicional as $item)
                                                                <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                    <div class="card w-100">
                                                                        <div class="card-body d-flex flex-column text-center">
                                                                            <h6 class="card-title" style="font-size: 0.875rem;">{{ $item->nome }}</h6>
                                                                            <p class="card-text" style="color: #000000;">R$ {{ number_format($item->valor, 2, ',', '.') }}</p>
                                                                            <button class="btn btn-custom" data-adicional-id="{{ $item->id }}" data-action="add">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @auth
                                                        <form action="{{ route('pedido.adiciona', $produto->id) }}" method="POST" class="d-inline">
                                                            {{ csrf_field() }}
                                                            <div class="form-group mt-3">
                                                                <label for="docemediaObservacao" class="text-white">Observação:</label>
                                                                <input type="text" class="form-control" id="docemediaObservacao{{ $produto->id }}" name="observacao">
                                                            </div>
                                                            <input id="docemediaMetadeId{{ $produto->id }}" name="metadeId" value="" hidden>
                                                            <input id="docemediaAdicional1Id{{ $produto->id }}" name="adicional1Id" value="" hidden>
                                                            <input id="docemediaAdicional2Id{{ $produto->id }}" name="adicional2Id" value="" hidden>
                                                            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Adicionar ao carrinho</button>
                                                        </form>
                                                    @endauth
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="location.reload()" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Meio a Meio -->
                                    <div class="modal fade" id="docemediaMeioModal{{ $produto->id }}" tabindex="-1" role="dialog" aria-labelledby="docemediaMeioModalLabel{{ $produto->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content" style="background-color: #1d1b2c;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-white" id="docemediaMeioModalLabel{{ $produto->id }}">Escolha a outra metade!</h5>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                    <div class="container">
                                                        <div class="row">
                                                            <h5 class="modal-title text-white" style="margin-bottom: 20px;">SABORES SALGADOS</h5>
                                                            @foreach($salgmedia as $salg)
                                                                @if($salg->ativo)
                                                                    <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                        <div class="card w-100">
                                                                            <div class="card-body d-flex flex-column text-center">
                                                                                <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $salg->img) }}" alt="" style="width: 80px; margin: 0 auto;">
                                                                                <h6 class="card-title" style="font-size: 0.875rem;">{{ $salg->nome }}</h6>
                                                                                <p class="card-text" style="color: #000000;">R$ {{ number_format($salg->preco, 2, ',', '.') }}</p>
                                                                                <button class="btn btn-custom mt-auto" data-metade-id="{{ $salg->id }}" onclick="adicionarPizzaMetadedocemedia({{ $salg->id }})">+</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="container">
                                                        <div class="row">
                                                            <h5 class="modal-title text-white" style="margin-bottom: 20px;">SABORES DOCES</h5>
                                                            @foreach($docemedia as $doce)
                                                                @if($doce->id !== $produto->id and $doce->ativo)
                                                                <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                    <div class="card w-100">
                                                                        <div class="card-body d-flex flex-column text-center">
                                                                            <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $doce->img) }}" alt="" style="width: 80px; margin: 0 auto;">
                                                                            <h6 class="card-title" style="font-size: 0.875rem;">{{ $doce->nome }}</h6>
                                                                            <p class="card-text" style="color: #000000;">R$ {{ number_format($doce->preco, 2, ',', '.') }}</p>
                                                                            <button class="btn btn-custom mt-auto" data-metade-id="{{ $doce->id }}" onclick="adicionarPizzaMetadedocemedia({{ $doce->id }})">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="location.reload()" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <script>
                                        // Função para abrir o modal de acordo com a seleção
                                        function openModaldocemedia(produtoId) {
                                            pizzaIdSelecionada = produtoId; // Atualiza a variável com o ID do produto
                                            const meioAMeioCheckbox = document.getElementById('salgmmeioameio' + produtoId);
                                            if (meioAMeioCheckbox.checked) {
                                                $('#docemediaMeioModal' + produtoId).modal('show');
                                            } else {
                                                $('#docemediaModal' + produtoId).modal('show');
                                            }
                                        }

                                        function adicionarPizzaMetadedocemedia(metadeId) {
                                            const campoMetadeId = document.getElementById('docemediaMetadeId' + pizzaIdSelecionada);
                                            campoMetadeId.value = metadeId;

                                            // Fecha o modal "Meio a Meio"
                                            $('#docemediaMeioModal' + pizzaIdSelecionada).modal('hide');

                                            // Abre o modal de adicionais
                                            $('#docemediaModal' + pizzaIdSelecionada).modal('show');
                                        }

                                        document.addEventListener('DOMContentLoaded', function () {
                                            // Atualiza o estado dos botões de adicionar/remover
                                            function updateButtonsState(modalId) {
                                                const buttons = document.querySelectorAll(`#docemediaModal${modalId} [data-action]`);
                                                const campoOculto1 = document.getElementById(`docemediaAdicional1Id${modalId}`);
                                                const campoOculto2 = document.getElementById(`docemediaAdicional2Id${modalId}`);

                                                // Desabilita botões se ambos os campos ocultos estão preenchidos
                                                if (campoOculto1.value && campoOculto2.value) {
                                                    buttons.forEach(button => {
                                                        if (button.getAttribute('data-action') === 'add') {
                                                            button.disabled = true;
                                                        }
                                                    });
                                                } else {
                                                    buttons.forEach(button => {
                                                        button.disabled = false; // Habilita botões novamente se houver espaço
                                                    });
                                                }
                                            }

                                            // Resetar o modal quando ele for fechado
                                            $(`.modal#docemediaModal{{$produto->id}}`).on('hidden.bs.modal', function () {
                                                const modalId = this.id.replace('docemediaModal', '');
                                                document.getElementById(`docemediaAdicional1Id${modalId}`).value = '';
                                                document.getElementById(`docemediaAdicional2Id${modalId}`).value = '';
                                                updateButtonsState(modalId); // Atualiza estado dos botões
                                            });

                                            // Evento para adicionar/remover adicionais
                                            document.querySelectorAll(`.modal#docemediaModal{{$produto->id}}`).forEach(modal => {
                                                modal.addEventListener('click', function (event) {
                                                    const button = event.target.closest('[data-action]');
                                                    if (button) {
                                                        const adicionalId = button.getAttribute('data-adicional-id');
                                                        const modalId = this.id.replace('docemediaModal', '');

                                                        const campoOculto1 = document.getElementById(`docemediaAdicional1Id${modalId}`);
                                                        const campoOculto2 = document.getElementById(`docemediaAdicional2Id${modalId}`);

                                                        if (button.getAttribute('data-action') === 'add') {
                                                            // Adiciona adicional na primeira ou segunda textbox oculta
                                                            if (!campoOculto1.value) {
                                                                campoOculto1.value = adicionalId; // Adiciona no primeiro campo
                                                                button.setAttribute('data-action', 'remove'); // Muda para remover
                                                                button.innerText = 'Remover'; // Troca texto
                                                            } else if (!campoOculto2.value && campoOculto1.value !== adicionalId) {
                                                                campoOculto2.value = adicionalId; // Adiciona no segundo campo
                                                                button.setAttribute('data-action', 'remove'); // Muda para remover
                                                                button.innerText = 'Remover'; // Troca texto
                                                            }
                                                        } else { // Caso contrário, removendo o adicional
                                                            // Remove o adicional correspondente ao botão clicado
                                                            if (campoOculto1.value === adicionalId) {
                                                                campoOculto1.value = ''; // Limpa campo se o primeiro adicional for removido
                                                            } else if (campoOculto2.value === adicionalId) {
                                                                campoOculto2.value = ''; // Limpa campo se o segundo adicional for removido
                                                            }

                                                            // Troca o botão de 'Remover' de volta para '+'
                                                            button.setAttribute('data-action', 'add'); // Muda para adicionar
                                                            button.innerText = '+'; // Troca texto
                                                        }

                                                        updateButtonsState(modalId); // Atualiza estado dos botões
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                        <div id="tab-4" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                @foreach($docegrande as $produto)
                                    @if($produto->ativo)
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $produto->img) }}" alt="" style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>{{ $produto->nome }}</span>
                                                    <span>
                        <input type="checkbox" id="salgmmeioameio{{ $produto->id }}" style="font-size: 12px;"> Meio a meio
                    </span>
                                                    <span class="text-primary">R$ {{ $produto->preco }}</span>
                                                </h5>
                                                <small class="fst-italic">{{ $produto->descricao }}</small>
                                                <!-- Botão para abrir o modal -->
                                                <button type="button" class="btn btn-primary" onclick="openModaldocegrande('{{ $produto->id }}')">
                                                    Comprar
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="docegrandeModal{{ $produto->id }}" tabindex="-1" role="dialog" aria-labelledby="docegrandeModalLabel{{ $produto->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content" style="background-color: #1d1b2c;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-white" id="docegrandeModalLabel{{ $produto->id }}">Adicionais</h5>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                    <div class="container">
                                                        <div class="row">
                                                            @foreach($adicional as $item)
                                                                <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                    <div class="card w-100">
                                                                        <div class="card-body d-flex flex-column text-center">
                                                                            <h6 class="card-title" style="font-size: 0.875rem;">{{ $item->nome }}</h6>
                                                                            <p class="card-text" style="color: #000000;">R$ {{ number_format($item->valor, 2, ',', '.') }}</p>
                                                                            <button class="btn btn-custom" data-adicional-id="{{ $item->id }}" data-action="add">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @auth
                                                        <form action="{{ route('pedido.adiciona', $produto->id) }}" method="POST" class="d-inline">
                                                            {{ csrf_field() }}
                                                            <div class="form-group mt-3">
                                                                <label for="docegrandeObservacao" class="text-white">Observação:</label>
                                                                <input type="text" class="form-control" id="docegrandeObservacao{{ $produto->id }}" name="observacao">
                                                            </div>
                                                            <input id="docegrandeMetadeId{{ $produto->id }}" name="metadeId" value="" hidden>
                                                            <input id="docegrandeAdicional1Id{{ $produto->id }}" name="adicional1Id" value="" hidden>
                                                            <input id="docegrandeAdicional2Id{{ $produto->id }}" name="adicional2Id" value="" hidden>
                                                            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Adicionar ao carrinho</button>
                                                        </form>
                                                    @endauth
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="location.reload()" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Meio a Meio -->
                                    <div class="modal fade" id="docegrandeMeioModal{{ $produto->id }}" tabindex="-1" role="dialog" aria-labelledby="docegrandeMeioModalLabel{{ $produto->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content" style="background-color: #1d1b2c;">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-white" id="docegrandeMeioModalLabel{{ $produto->id }}">Escolha a outra metade!</h5>
                                                </div>
                                                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                                    <div class="container">
                                                        <div class="row">
                                                            <h5 class="modal-title text-white" style="margin-bottom: 20px;">SABORES SALGADOS</h5>
                                                            @foreach($salgmedia as $salg)
                                                                @if($salg->ativo)
                                                                <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                    <div class="card w-100">
                                                                        <div class="card-body d-flex flex-column text-center">
                                                                            <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $salg->img) }}" alt="" style="width: 80px; margin: 0 auto;">
                                                                            <h6 class="card-title" style="font-size: 0.875rem;">{{ $salg->nome }}</h6>
                                                                            <p class="card-text" style="color: #000000;">R$ {{ number_format($salg->preco, 2, ',', '.') }}</p>
                                                                            <button class="btn btn-custom mt-auto" data-metade-id="{{ $salg->id }}" onclick="adicionarPizzaMetadedocegrande({{ $salg->id }})">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="container">
                                                        <div class="row">
                                                            <h5 class="modal-title text-white" style="margin-bottom: 20px;">SABORES DOCES</h5>
                                                            @foreach($docegrande as $doce)
                                                                @if($doce->id !== $produto->id and $doce->ativo)
                                                                    <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch">
                                                                        <div class="card w-100">
                                                                            <div class="card-body d-flex flex-column text-center">
                                                                                <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('site/img/produto/' . $doce->img) }}" alt="" style="width: 80px; margin: 0 auto;">
                                                                                <h6 class="card-title" style="font-size: 0.875rem;">{{ $doce->nome }}</h6>
                                                                                <p class="card-text" style="color: #000000;">R$ {{ number_format($doce->preco, 2, ',', '.') }}</p>
                                                                                <button class="btn btn-custom mt-auto" data-metade-id="{{ $doce->id }}" onclick="adicionarPizzaMetadedocegrande({{ $doce->id }})">+</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="location.reload()" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <script>
                                        // Função para abrir o modal de acordo com a seleção
                                        function openModaldocegrande(produtoId) {
                                            pizzaIdSelecionada = produtoId; // Atualiza a variável com o ID do produto
                                            const meioAMeioCheckbox = document.getElementById('salgmmeioameio' + produtoId);
                                            if (meioAMeioCheckbox.checked) {
                                                $('#docegrandeMeioModal' + produtoId).modal('show');
                                            } else {
                                                $('#docegrandeModal' + produtoId).modal('show');
                                            }
                                        }

                                        function adicionarPizzaMetadedocegrande(metadeId) {
                                            const campoMetadeId = document.getElementById('docegrandeMetadeId' + pizzaIdSelecionada);
                                            campoMetadeId.value = metadeId;

                                            // Fecha o modal "Meio a Meio"
                                            $('#docegrandeMeioModal' + pizzaIdSelecionada).modal('hide');

                                            // Abre o modal de adicionais
                                            $('#docegrandeModal' + pizzaIdSelecionada).modal('show');
                                        }

                                        document.addEventListener('DOMContentLoaded', function () {
                                            // Atualiza o estado dos botões de adicionar/remover
                                            function updateButtonsState(modalId) {
                                                const buttons = document.querySelectorAll(`#docegrandeModal${modalId} [data-action]`);
                                                const campoOculto1 = document.getElementById(`docegrandeAdicional1Id${modalId}`);
                                                const campoOculto2 = document.getElementById(`docegrandeAdicional2Id${modalId}`);

                                                // Desabilita botões se ambos os campos ocultos estão preenchidos
                                                if (campoOculto1.value && campoOculto2.value) {
                                                    buttons.forEach(button => {
                                                        if (button.getAttribute('data-action') === 'add') {
                                                            button.disabled = true;
                                                        }
                                                    });
                                                } else {
                                                    buttons.forEach(button => {
                                                        button.disabled = false; // Habilita botões novamente se houver espaço
                                                    });
                                                }
                                            }

                                            // Resetar o modal quando ele for fechado
                                            $(`.modal#docegrandeModal{{$produto->id}}`).on('hidden.bs.modal', function () {
                                                const modalId = this.id.replace('docegrandeModal', '');
                                                document.getElementById(`docegrandeAdicional1Id${modalId}`).value = '';
                                                document.getElementById(`docegrandeAdicional2Id${modalId}`).value = '';
                                                updateButtonsState(modalId); // Atualiza estado dos botões
                                            });

                                            // Evento para adicionar/remover adicionais
                                            document.querySelectorAll(`.modal#docegrandeModal{{$produto->id}}`).forEach(modal => {
                                                modal.addEventListener('click', function (event) {
                                                    const button = event.target.closest('[data-action]');
                                                    if (button) {
                                                        const adicionalId = button.getAttribute('data-adicional-id');
                                                        const modalId = this.id.replace('docegrandeModal', '');

                                                        const campoOculto1 = document.getElementById(`docegrandeAdicional1Id${modalId}`);
                                                        const campoOculto2 = document.getElementById(`docegrandeAdicional2Id${modalId}`);

                                                        if (button.getAttribute('data-action') === 'add') {
                                                            // Adiciona adicional na primeira ou segunda textbox oculta
                                                            if (!campoOculto1.value) {
                                                                campoOculto1.value = adicionalId; // Adiciona no primeiro campo
                                                                button.setAttribute('data-action', 'remove'); // Muda para remover
                                                                button.innerText = 'Remover'; // Troca texto
                                                            } else if (!campoOculto2.value && campoOculto1.value !== adicionalId) {
                                                                campoOculto2.value = adicionalId; // Adiciona no segundo campo
                                                                button.setAttribute('data-action', 'remove'); // Muda para remover
                                                                button.innerText = 'Remover'; // Troca texto
                                                            }
                                                        } else { // Caso contrário, removendo o adicional
                                                            // Remove o adicional correspondente ao botão clicado
                                                            if (campoOculto1.value === adicionalId) {
                                                                campoOculto1.value = ''; // Limpa campo se o primeiro adicional for removido
                                                            } else if (campoOculto2.value === adicionalId) {
                                                                campoOculto2.value = ''; // Limpa campo se o segundo adicional for removido
                                                            }

                                                            // Troca o botão de 'Remover' de volta para '+'
                                                            button.setAttribute('data-action', 'add'); // Muda para adicionar
                                                            button.innerText = '+'; // Troca texto
                                                        }

                                                        updateButtonsState(modalId); // Atualiza estado dos botões
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                    @endif
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
                                                        <button type="submit" class="btn btn-primary" value="adicionar" style="width: 100%;">
                                                            Comprar
                                                        </button>
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
