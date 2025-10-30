@extends('layouts.website-layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Demande de personnalisation</h1>
                    <p class="mb-0">Plan : {{ $plan->name }}</p>
                </div>

                <div class="card-body">
                    <form action="{{ route('customization-requests.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="house_plan_id" value="{{ $plan->id }}">

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="name" class="form-label">Nom complet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                            <small class="text-muted">Facultatif, pour vous contacter plus facilement</small>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">Votre demande de personnalisation <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                            <small class="text-muted">Décrivez en détail les modifications que vous souhaitez apporter au plan (au moins 10 caractères)</small>
                            @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('house-plans.show', $plan->slug) }}" class="btn btn-outline-secondary me-md-2">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Envoyer la demande
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 mt-4 mt-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h2 class="h5 mb-0">Détails du plan</h2>
                </div>
                <div class="card-body">
                    @if($plan->plan_2d_path && file_exists(public_path($plan->plan_2d_path)))
                        <img src="{{ asset($plan->plan_2d_path) }}" alt="Plan 2D" class="img-fluid rounded mb-3">
                    @endif
                    <h3 class="h5">{{ $plan->name }}</h3>
                    <ul class="list-unstyled">
                        <li><strong>Surface :</strong> {{ $plan->surface_area }} m²</li>
                        <li><strong>Chambres :</strong> {{ $plan->bedrooms }}</li>
                        <li><strong>Salles de bain :</strong> {{ $plan->bathrooms }}</li>
                        <li><strong>Étages :</strong> {{ $plan->floors }}</li>
                        <li><strong>Prix :</strong> {{ number_format($plan->price, 0, ',', ' ') }} €</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
