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
                            <div id="tab-2" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    @foreach($salggrande as $produto)
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
                            <div id="tab-4" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    @foreach($docegrande as $produto)
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



    @include('components.footer');

</body>

</html>
