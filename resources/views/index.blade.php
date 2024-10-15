<!DOCTYPE html>
<html lang="pt-br">


@include('components.head', ['title'=>'Menu Principal'])

<body>
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
                @auth
                    @if(auth()->user()->admin)
                        <a href="{{route('dashboard')}}" class="btn btn-primary py-2 px-4" style="margin-right: 20px;">Área admin</a>
                    @endif
                @endauth
                <a href="{{route('cardapio')}}" class="btn btn-primary py-2 px-4">Faça seu pedido!</a>
                <a class="nav-link" href="{{ route('checkout') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge badge-pill badge-primary">{{ session()->get('itens_carrinho') ?? 0}}</span>
                </a>
            </div>
        </nav>

        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container my-5 py-5">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="display-3 text-white animated slideInLeft">Curta sabores<br>Incríveis</h1>
                        <p class="text-white animated slideInLeft mb-4 pb-2">A Pizzaria Ribeiro é conhecida pela qualidade de suas pizzas, feitas com ingredientes frescos e selecionados. A massa é crocante e leve, e as coberturas variam das clássicas às mais sofisticadas, garantindo sabor autêntico e excelência em cada fatia.</p>
                        <a href="{{ route('cardapio') }}" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Faça seu pedido!</a>
                    </div>
                    <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                        <img class="img-fluid" src="site/img/hero.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-user-tie text-primary mb-4"></i>
                            <h5>Master Chefs</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-utensils text-primary mb-4"></i>
                            <h5>Quality Food</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-cart-plus text-primary mb-4"></i>
                            <h5>Online Order</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                            <h5>24/7 Service</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Team Start -->
    <div class="container-xxl pt-5 pb-3">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Membros da equipe</h5>
                <h1 class="mb-5">Nossos Master Chefs!</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item text-center rounded overflow-hidden">
                        <div class="rounded-circle overflow-hidden m-4">
                            <img class="img-fluid" src="site/img/team-1.jpg" alt="">
                        </div>
                        <h5 class="mb-0">Rafael Silva</h5>
                        <div class="d-flex justify-content-center mt-3">
                            <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item text-center rounded overflow-hidden">
                        <div class="rounded-circle overflow-hidden m-4">
                            <img class="img-fluid" src="site/img/team-2.jpg" alt="">
                        </div>
                        <h5 class="mb-0">Pedro Santos</h5>
                        <div class="d-flex justify-content-center mt-3">
                            <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item text-center rounded overflow-hidden">
                        <div class="rounded-circle overflow-hidden m-4">
                            <img class="img-fluid" src="site/img/team-3.jpg" alt="">
                        </div>
                        <h5 class="mb-0">Henrique Oliveira</h5>
                        <div class="d-flex justify-content-center mt-3">
                            <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item text-center rounded overflow-hidden">
                        <div class="rounded-circle overflow-hidden m-4">
                            <img class="img-fluid" src="site/img/team-4.jpg" alt="">
                        </div>
                        <h5 class="mb-0">Thiago Pereira</h5>
                        <div class="d-flex justify-content-center mt-3">
                            <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->

    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Avaliações</h5>
                <h1 class="mb-5">Nossos clientes dizem!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel">
                <div class="testimonial-item bg-transparent border rounded p-4">
                    <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                    <p>A Pizzaria Ribeiro é incrível! Sempre encontro a combinação perfeita de sabores, e a pizza chega quentinha e no ponto certo. Atendimento de primeira!</p>
                    <div class="d-flex align-items-center">
                        <div class="ps-3">
                            <h5 class="mb-1">Amanda Costa</h5>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-transparent border rounded p-4">
                    <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                    <p>Não conheço outra pizzaria que consiga entregar uma pizza com tanto sabor e qualidade. A Pizzaria Ribeiro sempre surpreende com recheios generosos e uma massa perfeita. Super recomendo!</p>
                    <div class="d-flex align-items-center">
                        <div class="ps-3">
                            <h5 class="mb-1">Lucas Ferreira</h5>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-transparent border rounded p-4">
                    <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                    <p>A Pizzaria Ribeiro é minha escolha sempre que estou com vontade de uma pizza de qualidade. As combinações de sabores são impecáveis e a crocância da massa é incomparável. Simplesmente maravilhosa!</p>
                    <div class="d-flex align-items-center">
                        <div class="ps-3">
                            <h5 class="mb-1">João Mendes</h5>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-transparent border rounded p-4">
                    <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                    <p>Sempre que peço pizza na Pizzaria Ribeiro, me surpreendo com a qualidade. Os ingredientes são sempre frescos e bem escolhidos, e a massa é leve e deliciosa. Uma verdadeira obra-prima!</p>
                    <div class="d-flex align-items-center">
                        <div class="ps-3">
                            <h5 class="mb-1">Gabriela Almeida</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    @include('components.footer');
</body>

</html>
