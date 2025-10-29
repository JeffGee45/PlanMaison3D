@extends('layouts.website-layout')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="text-center py-4">
            <h1 class="display-4 fw-bold">Contactez-nous</h1>
            <p class="lead">Une question ? Notre équipe est là pour vous répondre</p>
        </div>
    </div>
</section>

<!-- Contact Info Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-geo-alt fs-2"></i>
                        </div>
                        <h4 class="h5 mb-3">Notre Adresse</h4>
                        <p class="text-muted mb-0">Rue des Entrepreneurs<br>Quartier Nyékonakpoè<br>Lomé, Togo</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-envelope fs-2"></i>
                        </div>
                        <h4 class="h5 mb-3">Email</h4>
                        <p class="text-muted mb-1">contact@planmaison3d.tg</p>
                        <p class="text-muted mb-0">commercial@planmaison3d.tg</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-telephone fs-2"></i>
                        </div>
                        <h4 class="h5 mb-3">Téléphone</h4>
                        <p class="text-muted mb-1">+228 90 12 34 56</p>
                        <p class="text-muted mb-0">Lun - Sam, 8h - 18h</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Envoyez-nous un message</h2>
                        <p class="text-center text-muted mb-5">Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.</p>
                        
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Votre nom complet <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Votre email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Sujet <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Votre message <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="privacy" name="privacy" required>
                                        <label class="form-check-label small" for="privacy">
                                            En soumettant ce formulaire, j'accepte que les informations saisies soient utilisées pour me recontacter dans le cadre de ma demande. <a href="#" class="text-primary">Politique de confidentialité</a>.
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="bi bi-send me-2"></i>Envoyer le message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5">
    <div class="container">
        <div class="ratio ratio-21x9 rounded-3 overflow-hidden shadow">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d1.224763714266588!3d6.20251416213097!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1023e3e7da82d3e1%3A0x7b4d1a8f4a9e8c6b!2sLom%C3%A9%2C%20Togo!5e0!3m2!1sfr!2stg!4v1620000000000!5m2!1sfr!2stg" 
                    width="600" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
            </iframe>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h1">Questions fréquentes</h2>
            <p class="lead text-muted">Trouvez des réponses aux questions les plus courantes</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Quels sont les horaires d'ouverture ?
                            </button>
                        </h3>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Notre équipe est disponible du lundi au samedi de 8h à 18h. Vous pouvez nous contacter par téléphone, email ou via notre formulaire de contact. En dehors de ces horaires, n'hésitez pas à nous laisser un message, nous vous répondrons dès la réouverture.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Comment puis-je prendre rendez-vous ?
                            </button>
                        </h3>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Vous pouvez prendre rendez-vous en nous appelant au +228 90 12 34 56 ou en remplissant notre formulaire de contact. Notre équipe vous contactera dans les 24 heures pour confirmer votre rendez-vous et discuter de vos besoins.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Quelles sont les zones desservies ?
                            </button>
                        </h3>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Nous desservons tout le Togo, avec une présence principale à Lomé. Nos services sont disponibles dans toutes les régions du pays, avec des frais de déplacement variables en fonction de la localisation. Contactez-nous pour plus d'informations sur votre zone spécifique.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="h1 mb-4">Prêt à commencer votre projet ?</h2>
        <p class="lead mb-4">Notre équipe est à votre écoute pour discuter de vos besoins en matière de plan de maison.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="tel:+22890123456" class="btn btn-light btn-lg px-4">
                <i class="bi bi-telephone me-2"></i>Nous appeler
            </a>
            <a href="mailto:contact@planmaison3d.tg" class="btn btn-outline-light btn-lg px-4">
                <i class="bi bi-envelope me-2"></i>Nous écrire
            </a>
        </div>
    </div>
</section>
@endsection
