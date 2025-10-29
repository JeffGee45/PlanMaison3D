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
            <div class="mt-5">
                <h3>Plan 2D</h3>
                @if($plan->plan_2d_path && file_exists(public_path($plan->plan_2d_path)))
                    <img src="{{ asset($plan->plan_2d_path) }}" alt="Plan 2D de {{ $plan->name }}" class="img-fluid rounded shadow-sm">
                @else
                    <div class="alert alert-info">
                        <p class="mb-0">Le plan 2D n'est pas encore disponible pour ce modèle.</p>
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
                        <a href="#" class="btn btn-success btn-lg">Acheter ce plan</a>
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
