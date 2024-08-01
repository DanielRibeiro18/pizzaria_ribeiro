<!DOCTYPE html>
<html lang="pt-br">

@include('components.head', ['title'=>'Contato'])

<body>
<div class="container-xxl bg-white p-0">

    @include('components.navbar', ['theme'=>'Entre em contato!']);


    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Contact Us</h5>
                <h1 class="mb-5">Contact For Any Query</h1>
            </div>
            <div class="row g-4">

                <div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
                    <iframe class="position-relative rounded w-100 h-100"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.866545370843!2d-45.54574368502178!3d-22.95748928498171!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ccc24957c3f1df%3A0xa2bcb2a2a843c0c6!2sR.%201%C2%BA%20de%20Janeiro%2C%20231%2C%20Trememb%C3%A9%20-%20SP%2C%2012120-093%2C%20Brasil!5e0!3m2!1sen!2sbr!4v1690900889298!5m2!1sen!2sbr"
                            frameborder="0" style="min-height: 350px; border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
                    </iframe>
                </div>
                <div class="col-md-6">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" placeholder="Nome">
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Email">
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject" placeholder="Subject">
                                        <label for="subject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Deixe sua mensagem!" id="message" style="height: 150px"></textarea>
                                        <label for="message">Message</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit" onclick="alert('Mensagem enviada com sucesso!')">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    @include('components.footer');

</body>

</html>
