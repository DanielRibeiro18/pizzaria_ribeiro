<div class="container-xxl bg-white p-0">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar & Hero Start -->
    <div class="container-xxl position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
            <a href="" class="navbar-brand p-0">
                <img src="site/img/logo.png" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0 pe-4">
                    <a href="{{route('index')}}" class="nav-item nav-link">Home</a>
                    <a href="{{route('sobre_nos')}}" class="nav-item nav-link">Sobre</a>
                    <a href="{{route('contato')}}" class="nav-item nav-link">Contato</a>
                    @guest
                        <a href="{{route('registro')}}" class="nav-item nav-link">Registro</a>
                        <a href="{{route('login')}}" class="nav-item nav-link">Login</a>
                    @endguest
                    @auth
                        <span class="nav-item nav-link">Bem-Vindo, {{ auth()->user()->nome }}</span>
                        <a href="{{route('logout')}}" class="nav-item nav-link">Logout</a>
                    @endauth
                </div>
                <a href="{{route('cardapio')}}" class="btn btn-primary py-2 px-4">Faça seu pedido!</a>
                <a class="nav-link" href="{{ route('checkout') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge badge-pill badge-primary">{{ session()->get('itens_carrinho')  ?? 0}}</span>
                </a>
            </div>
        </nav>

        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container text-center my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">{{$theme}}</h1>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->

</div>
