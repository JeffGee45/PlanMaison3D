@extends('layouts.website-layout')
@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card auth-card">
                    <div class="auth-header">
                        <h2><i class="bi bi-house-door me-2"></i>PlanMaison3D</h2>
                        <p>Créez votre compte gratuitement</p>
                    </div>

                    <div class="auth-body">
                        <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png"
                            class="auth-avatar" alt="Avatar">

                        @if (Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>{{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>{{ Session::get('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('handleUserRegister') }}">
                            @method('post')
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label-modern">
                                    <i class="bi bi-person me-1"></i>Nom Complet
                                </label>
                                <input type="text" class="form-control form-control-modern" id="name" name="name"
                                    placeholder="Jean Dupont" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-danger mt-2"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label-modern">
                                    <i class="bi bi-envelope me-1"></i>Adresse Email
                                </label>
                                <input type="email" class="form-control form-control-modern" id="email" name="email"
                                    placeholder="exemple@email.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger mt-2"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label-modern">
                                    <i class="bi bi-lock me-1"></i>Mot de passe
                                </label>
                                <input type="password" class="form-control form-control-modern" id="password" name="password"
                                    placeholder="••••••••" required>
                                <small class="text-muted">Minimum 8 caractères</small>
                                @error('password')
                                    <div class="text-danger mt-2"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    J'accepte les <a href="#!" class="text-decoration-none">conditions d'utilisation</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-auth mb-3">
                                <i class="bi bi-person-plus me-2"></i>Créer mon Compte
                            </button>

                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Déjà inscrit? 
                                    <a href="{{ route('user.login') }}" class="text-decoration-none fw-bold">
                                        Se connecter
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
