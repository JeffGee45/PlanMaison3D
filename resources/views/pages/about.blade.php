@extends('layouts.website-layout')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="text-center py-4">
            <h1 class="display-4 fw-bold">À Propos de PlanMaison3D</h1>
            <p class="lead">Votre partenaire de confiance pour des plans de maisons personnalisés au Togo</p>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="h1 mb-4">Notre Histoire</h2>
                <p class="lead">Fondée en 2023 à Lomé, PlanMaison3D est née d'une passion pour l'architecture et le design d'intérieur.</p>
                <p>Notre mission est de rendre accessible à tous des plans de maisons de qualité, adaptés au climat et aux spécificités du Togo, à des prix abordables.</p>
                <p>Nous croyons que chaque Togolais mérite de vivre dans un espace beau, fonctionnel et adapté à son mode de vie.</p>
                
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-building fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">+200</h5>
                                <small class="text-muted">Plans réalisés</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-people fs-4"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">+150</h5>
                                <small class="text-muted">Clients satisfaits</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative rounded-3 overflow-hidden shadow-lg">
                    <img src="{{ asset('img/Maison3.jpg') }}" alt="Équipe PlanMaison3D" class="img-fluid rounded-3">
                    <div class="position-absolute bottom-0 start-0 bg-primary text-white p-3 m-3 rounded">
                        <h5 class="mb-0">Notre équipe d'experts</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h1">Nos Valeurs</h2>
            <p class="lead text-muted">Ce qui nous guide dans notre travail quotidien</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-lightbulb fs-2"></i>
                        </div>
                        <h4 class="h5">Innovation</h4>
                        <p class="text-muted mb-0">Nous repoussons les limites du design pour des solutions uniques et créatives.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-shield-check fs-2"></i>
                        </div>
                        <h4 class="h5">Qualité</h4>
                        <p class="text-muted mb-0">Des plans détaillés et des matériaux de qualité pour une construction durable.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-people fs-2"></i>
                        </div>
                        <h4 class="h5">Client d'abord</h4>
                        <p class="text-muted mb-0">Votre satisfaction est notre priorité absolue à chaque étape du projet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h1">Notre Équipe</h2>
            <p class="lead text-muted">Des professionnels passionnés à votre service</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="{{ asset('img/team1.jpg') }}" class="card-img-top" alt="Membre de l'équipe" onerror="this.src='https://via.placeholder.com/400x300?text=Architecte+Expert'">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">Koffi Adjo</h5>
                        <p class="text-muted mb-3">Architecte Principal</p>
                        <p class="card-text">15 ans d'expérience dans la conception de maisons adaptées au climat tropical.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-primary"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-primary"><i class="bi bi-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="{{ asset('img/team2.jpg') }}" class="card-img-top" alt="Membre de l'équipe" onerror="this.src='https://via.placeholder.com/400x300?text=Designer+Interior'">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">Afi Gbédjé</h5>
                        <p class="text-muted mb-3">Designer d'Intérieur</p>
                        <p class="card-text">Spécialiste en aménagement d'espaces de vie fonctionnels et esthétiques.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-primary"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-primary"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="{{ asset('img/team3.jpg') }}" class="card-img-top" alt="Membre de l'équipe" onerror="this.src='https://via.placeholder.com/400x300?text=Gestion+Projet'">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">Komlan Améwoui</h5>
                        <p class="text-muted mb-3">Chef de Projet</p>
                        <p class="card-text">Assure le suivi personnalisé de chaque projet de A à Z.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="text-primary"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-primary"><i class="bi bi-facebook"></i></a>
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
        <h2 class="h1 mb-4">Prêt à concrétiser votre projet ?</h2>
        <p class="lead mb-4">Notre équipe est à votre écoute pour discuter de vos besoins en matière de plan de maison.</p>
        <a href="{{ route('contact') }}" class="btn btn-light btn-lg px-5">
            <i class="bi bi-chat-dots me-2"></i>Nous contacter
        </a>
    </div>
</section>
@endsection
