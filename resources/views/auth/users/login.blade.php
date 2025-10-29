@extends('layouts.website-layout')
@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card auth-card">
                    <div class="auth-header">
                        <h2><i class="bi bi-house-door me-2"></i>PlanMaison3D</h2>
                        <p>Connectez-vous à votre compte</p>
                    </div>

                    <div class="auth-body">
                        <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png"
                            class="auth-avatar" alt="Avatar">

                        @if (Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>{{ Session::get('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>{{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('handleUserLogin') }}">
                            @csrf

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
                                @error('password')
                                    <div class="text-danger mt-2"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Se souvenir de moi
                                    </label>
                                </div>
                                <a href="#!" class="text-decoration-none">Mot de passe oublié?</a>
                            </div>

                            <button type="submit" class="btn btn-auth mb-3">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Se Connecter
                            </button>

                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Pas encore de compte? 
                                    <a href="{{ route('user.register') }}" class="text-decoration-none fw-bold">
                                        Créer un compte
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
