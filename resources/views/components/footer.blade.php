<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5 d-flex align-items-start">
            <div class="col-lg-6 col-md-6">
                <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Contato</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Rua Primeiro de Janeiro, 231 - Centro - Tremembé</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>(12) 99223-2750</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>pizzariaribeiro@gmail.com</p>
            </div>
            <div class="col-lg-6 col-md-6">
                <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Funcionamento</h4>

                <div class="row">
                    @foreach($horarios as $horario)
                        <div class="col-md-4">
                            <h5 class="text-light fw-normal">{{ $horario->dia_semana }}</h5>
                            <p>
                                @if($horario->fechado)
                                    Fechado
                                @else
                                    {{ $horario->hora_abertura }} - {{ $horario->hora_fechamento }}
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span>&copy; 2024 Pizzaria Ribeiro. Todos os direitos reservados.</span>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ URL::to('/') }}/site/lib/wow/wow.min.js"></script>
<script src="{{ URL::to('/') }}/site/lib/easing/easing.min.js"></script>
<script src="{{ URL::to('/') }}/site/lib/waypoints/waypoints.min.js"></script>
<script src="{{ URL::to('/') }}/site/lib/counterup/counterup.min.js"></script>
<script src="{{ URL::to('/') }}/site/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="{{ URL::to('/') }}/site/lib/tempusdominus/js/moment.min.js"></script>
<script src="{{ URL::to('/') }}/site/lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="{{ URL::to('/') }}/site/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Template Javascript -->
<script src="{{ URL::to('/') }}/site/js/main.js"></script>
