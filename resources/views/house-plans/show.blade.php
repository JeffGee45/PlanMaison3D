@extends('layouts.website-layout')

@push('styles')
<style>
    #panorama {
        width: 100%;
        height: 500px;
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mb-4">{{ $plan->name }}</h1>

            <!-- Visite Virtuelle -->
            <div id="panorama"></div>
            <p class="text-muted small mt-2 text-center">Utilisez votre souris pour vous déplacer dans la visite virtuelle.</p>

            <!-- Plan 2D -->
            <div class="mt-5 pt-4 border-top">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="h4 mb-0">Plan Technique 2D</h3>
                    <div class="d-grid gap-2 d-md-flex flex-wrap">
                        <a href="{{ route('house-plans.download', $plan->slug) }}" class="btn btn-primary me-md-2 mb-2">
                            <i class="bi bi-download me-2"></i>Télécharger le plan
                        </a>
                        <a href="{{ route('customization-requests.create', $plan) }}" class="btn btn-outline-primary me-md-2 mb-2">
                            <i class="bi bi-pencil-square me-2"></i>Personnaliser ce plan
                        </a>
                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $plan->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-outline-secondary mb-2">
                                <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
                            </button>
                        </form>
                    </div>
                </div>
                @if($plan->plan_2d_path && file_exists(public_path($plan->plan_2d_path)))
                    <div class="bg-light p-3 rounded border">
                        <img src="{{ asset($plan->plan_2d_path) }}" alt="Plan 2D de {{ $plan->name }}" class="img-fluid rounded">
                    </div>
                    <p class="text-muted small mt-2">Le plan inclut les dimensions des pièces, les emplacements des portes et fenêtres.</p>
                @else
                    <div class="alert alert-light text-center">
                        <i class="bi bi-file-earmark-excel fs-3 d-block mb-2"></i>
                        Le plan 2D détaillé sera bientôt disponible.
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 2rem;">
                <div class="card-body">
                    <h3 class="card-title">Détails du Plan</h3>
                    <p class="card-text">{{ $plan->description }}</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between"><strong>Prix</strong> <span>{{ number_format($plan->price, 2, ',', ' ') }} €</span></li>
                        <li class="list-group-item d-flex justify-content-between"><strong>Superficie</strong> <span>{{ $plan->surface_area }} m²</span></li>
                        <li class="list-group-item d-flex justify-content-between"><strong>Étages</strong> <span>R+{{ $plan->floors }}</span></li>
                        <li class="list-group-item d-flex justify-content-between"><strong>Chambres</strong> <span>{{ $plan->bedrooms }}</span></li>
                        <li class="list-group-item d-flex justify-content-between"><strong>Salles de bain</strong> <span>{{ $plan->bathrooms }}</span></li>
                    </ul>
                    <div class="d-grid mt-4">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $plan->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-success btn-lg w-100">Acheter ce plan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        pannellum.viewer('panorama', {
            "type": "equirectangular",
            "panorama": "{{ asset($plan->panorama_image_path) }}",
            "autoLoad": true,
            "autoRotate": -2,
            "showControls": true
        });
    });
</script>
@endpush
