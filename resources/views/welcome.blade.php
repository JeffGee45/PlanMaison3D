@extends('layouts.website-layout')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container px-4 px-lg-5">
        <div class="hero-content text-center text-white">
            <h1 class="animate-fade-in-up">Trouvez le Plan de Maison Parfait</h1>
            <p class="animate-fade-in-up">Découvrez notre collection de plans de maisons 3D modernes et personnalisables</p>
            
            <!-- Search Bar -->
            <div class="hero-search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher un plan de maison..." aria-label="Rechercher">
                    <button class="btn" type="button">
                        <i class="bi bi-search me-2"></i>Rechercher
                    </button>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row mt-5 text-center">
                <div class="col-md-4 mb-3">
                    <div class="d-flex flex-column align-items-center">
                        <h3 class="fw-bold mb-0">500+</h3>
                        <p class="mb-0 opacity-75">Plans Disponibles</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-flex flex-column align-items-center">
                        <h3 class="fw-bold mb-0">1000+</h3>
                        <p class="mb-0 opacity-75">Clients Satisfaits</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-flex flex-column align-items-center">
                        <h3 class="fw-bold mb-0">50+</h3>
                        <p class="mb-0 opacity-75">Styles Différents</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5">
        <div class="row g-4">
            <div class="col-md-3 text-center">
                <div class="feature-icon bg-primary bg-gradient text-white rounded-circle mb-3 mx-auto" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-box-seam" style="font-size: 2rem;"></i>
                </div>
                <h5 class="fw-bold">Visualisation 3D</h5>
                <p class="text-muted">Explorez vos plans en 3D interactif</p>
            </div>
            <div class="col-md-3 text-center">
                <div class="feature-icon bg-success bg-gradient text-white rounded-circle mb-3 mx-auto" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-palette" style="font-size: 2rem;"></i>
                </div>
                <h5 class="fw-bold">Personnalisation</h5>
                <p class="text-muted">Adaptez les plans à vos besoins</p>
            </div>
            <div class="col-md-3 text-center">
                <div class="feature-icon bg-warning bg-gradient text-white rounded-circle mb-3 mx-auto" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-download" style="font-size: 2rem;"></i>
                </div>
                <h5 class="fw-bold">Téléchargement Rapide</h5>
                <p class="text-muted">Accès immédiat après achat</p>
            </div>
            <div class="col-md-3 text-center">
                <div class="feature-icon bg-danger bg-gradient text-white rounded-circle mb-3 mx-auto" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-headset" style="font-size: 2rem;"></i>
                </div>
                <h5 class="fw-bold">Support 24/7</h5>
                <p class="text-muted">Assistance à tout moment</p>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5">
    <div class="container px-4 px-lg-5">
        <div class="text-center mb-5">
            <h2 class="section-title">Nos Plans de Maisons</h2>
            <p class="section-subtitle">Découvrez notre sélection de plans modernes et fonctionnels</p>
        </div>
        
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
            @foreach ($articles as $article)
                <x-product-item :article="$article" />
            @endforeach
        </div>

        @if(count($articles) === 0)
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
            <h4 class="mt-3 text-muted">Aucun plan disponible pour le moment</h4>
            <p class="text-muted">Revenez bientôt pour découvrir nos nouveaux plans !</p>
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container px-4 px-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-8 text-white">
                <h2 class="fw-bold mb-3">Vous êtes architecte ou designer ?</h2>
                <p class="lead mb-0">Rejoignez notre plateforme et vendez vos plans de maisons à des milliers de clients</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('vendors.register') }}" class="btn btn-light btn-lg px-5">
                    <i class="bi bi-shop me-2"></i>Devenir Vendeur
                </a>
            </div>
        </div>
    </div>
</section>
      
@endsection
     






