@extends('layouts.website-layout')

@section('content')
<!-- Hero Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="text-center py-4">
            <h1 class="display-4 fw-bold text-primary">Nos Plans de Maisons</h1>
            <p class="lead text-muted">Découvrez notre sélection exclusive de plans modernes et fonctionnels</p>
            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="#plans" class="btn btn-primary btn-lg px-4">Voir les plans</a>
                <a href="#contact" class="btn btn-outline-primary btn-lg px-4">Nous contacter</a>
            </div>
        </div>
    </div>
</section>

<!-- Plans Section -->
<section id="plans" class="py-5">
    <div class="container">
        <!-- Filtres -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('house-plans.index') }}" method="GET" class="row g-3 align-items-end">
                            <div class="col-lg-3 col-md-6">
                                <label for="style" class="form-label">Style</label>
                                <select name="style" id="style" class="form-select">
                                    <option value="">Tous les styles</option>
                                    @foreach($styles as $style)
                                        <option value="{{ $style }}" {{ ($filters['style'] ?? '') == $style ? 'selected' : '' }}>
                                            {{ ucfirst($style) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label for="bedrooms" class="form-label">Chambres</label>
                                <select name="bedrooms" id="bedrooms" class="form-select">
                                    <option value="">Toutes</option>
                                    @for ($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ ($filters['bedrooms'] ?? '') == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ $i > 1 ? 'chambres' : 'chambre' }}{{ $i === 6 ? '+' : '' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label for="price_min" class="form-label">Prix (FCFA)</label>
                                <div class="input-group">
                                    <input type="number" name="price_min" id="price_min" class="form-control" placeholder="Min" value="{{ $filters['price_min'] ?? '' }}">
                                    <input type="number" name="price_max" id="price_max" class="form-control" placeholder="Max" value="{{ $filters['price_max'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label for="surface_min" class="form-label">Surface (m²)</label>
                                <div class="input-group">
                                    <input type="number" name="surface_min" id="surface_min" class="form-control" placeholder="Min" value="{{ $filters['surface_min'] ?? '' }}">
                                    <input type="number" name="surface_max" id="surface_max" class="form-control" placeholder="Max" value="{{ $filters['surface_max'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-12">
                                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des plans -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse ($plans as $plan)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
                        <a href="{{ route('house-plans.show', $plan->slug) }}" class="text-decoration-none">
                            <div class="position-relative" style="height: 220px; overflow: hidden;">
                                @if($plan->image_path && file_exists(public_path($plan->image_path)))
                                    <img src="{{ asset($plan->image_path) }}" 
                                         class="card-img-top h-100" 
                                         alt="{{ $plan->name }}" 
                                         style="object-fit: cover; transition: transform 0.3s ease;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light h-100">
                                        <div class="text-center p-4">
                                            <i class="bi bi-house-door text-muted" style="font-size: 3rem;"></i>
                                            <p class="mt-2 mb-0 text-muted">Aperçu non disponible</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="position-absolute bottom-0 start-0 p-3">
                                    <span class="badge bg-primary">Nouveau</span>
                                </div>
                            </div>
                        </a>
                        <div class="card-body p-3">
                            <h5 class="card-title mb-1"><a href="{{ route('house-plans.show', $plan->slug) }}" class="text-dark text-decoration-none">{{ $plan->name }}</a></h5>
                            <p class="card-text text-muted small mb-2">{{ Str::limit($plan->description, 80) }}</p>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-light text-dark"><i class="bi bi-rulers me-1"></i> {{ $plan->surface_area }} m²</span>
                                <span class="badge bg-light text-dark"><i class="bi bi-door-closed me-1"></i> {{ $plan->bedrooms }} ch.</span>
                                <span class="badge bg-light text-dark"><i class="bi bi-droplet me-1"></i> {{ $plan->bathrooms }} sdb</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-5 text-primary">{{ number_format($plan->price, 0, ',', ' ') }} €</span>
                            </div>
                        </div>
                        <div class="card-footer p-3 pt-0 border-top-0 bg-transparent">
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $plan->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi-cart-plus me-2"></i>Ajouter au panier
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 my-5">
                        <div class="mb-4">
                            <i class="bi bi-house-x text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="h4">Aucun plan disponible pour le moment</h3>
                        <p class="text-muted mb-4">Notre catalogue est en cours de mise à jour. Revenez bientôt pour découvrir nos nouveaux plans !</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-2"></i> Retour à l'accueil
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($plans->hasPages())
        <div class="mt-5 d-flex justify-content-center">
            <nav aria-label="Pagination">
                {{ $plans->links('pagination::bootstrap-5') }}
            </nav>
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="h3 mb-3">Vous ne trouvez pas votre bonheur ?</h2>
                <p class="mb-0">Nos architectes locaux peuvent créer un plan personnalisé adapté à votre terrain et à votre budget.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <a href="#contact" class="btn btn-light btn-lg">Demander un devis personnalisé</a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center p-4 bg-white rounded-3 h-100">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-shield-check fs-4"></i>
                    </div>
                    <h4 class="h5">Garantie Satisfait ou Remboursé</h4>
                    <p class="mb-0 text-muted">15 jours pour changer d'avis, remboursement intégral sous 7 jours ouvrés.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4 bg-white rounded-3 h-100">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-tools fs-4"></i>
                    </div>
                    <h4 class="h5">Plans Adaptés au Climat</h4>
                    <p class="mb-0 text-muted">Conçus spécialement pour le climat tropical du Togo.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4 bg-white rounded-3 h-100">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-headset fs-4"></i>
                    </div>
                    <h4 class="h5">Support Local</h4>
                    <p class="mb-0 text-muted">Une équipe locale disponible pour vous conseiller sur les matériaux et la construction.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-5 bg-primary text-white p-5 d-none d-md-flex flex-column">
                            <h3 class="h4 mb-4">Contactez-nous</h3>
                            <p class="mb-4">Une question sur nos plans de maisons ? Notre équipe est là pour vous répondre.</p>
                            <div class="mt-auto">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-envelope me-3"></i>
                                    <span>contact@planmaison3d.tg</span>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-telephone me-3"></i>
                                    <span>+228 90 12 34 56</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-geo-alt me-3"></i>
                                    <span>Rue des Entrepreneurs, Quartier Nyékonakpoè, Lomé, Togo</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card-body p-5">
                                <h3 class="h4 mb-4">Demande d'information</h3>
                                <p class="text-muted small mb-4">Notre équipe vous répondra sous 24h ouvrées.</p>
                                <form>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nom complet</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Téléphone (Togo)</label>
                                        <input type="tel" class="form-control" id="phone">
                                    </div>
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Votre message</label>
                                        <textarea class="form-control" id="message" rows="4" required></textarea>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Envoyer la demande</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h1">Questions fréquentes</h2>
            <p class="lead text-muted">Trouvez les réponses aux questions les plus courantes au Togo</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Les plans sont-ils modifiables ?
                            </button>
                        </h3>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Oui, tous nos plans sont entièrement modifiables par nos architectes pour s'adapter à vos besoins spécifiques. Vous pouvez demander des modifications de surface, d'agencement ou de style architectural.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Quel est le délai de livraison d'un plan ?
                            </button>
                        </h3>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Les plans standards sont disponibles immédiatement après paiement. Pour les plans personnalisés, nos architectes basés à Lomé vous proposeront un rendez-vous sous 48h pour discuter de votre projet. Le délai de réalisation varie ensuite de 1 à 3 semaines selon la complexité.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3 rounded-3 overflow-hidden">
                        <h3 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Puis-je me faire rembourser si le plan ne me convient pas ?
                            </button>
                        </h3>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Oui, nous offrons une garantie satisfait ou remboursé de 15 jours. Si le plan ne vous convient pas, vous pouvez demander un remboursement intégral sous 7 jours ouvrés suivant l'achat, sans justification. Les virements sont effectués sur un compte bancaire local au Togo.
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                    <p class="mb-3">Vous avez d'autres questions ?</p>
                    <a href="#contact" class="btn btn-outline-primary">Contactez notre équipe</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .hover-shadow {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
    }
    .icon-box {
        width: 60px;
        height: 60px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
    }
    .accordion-button:not(.collapsed) {
        background-color: rgba(13, 110, 253, 0.05);
        color: #0d6efd;
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }
    .card-img-top {
        transition: transform 0.5s ease;
    }
    .card:hover .card-img-top {
        transform: scale(1.05);
    }
</style>
@endpush
