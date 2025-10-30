@extends('layouts.website-layout')
@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card auth-card">
                    <div class="auth-header">
                        <h2><i class="bi bi-shop me-2"></i>Espace Vendeur</h2>
                        <p>Connectez-vous à votre boutique</p>
                    </div>

                    <div class="auth-body">
                        <img src="{{ asset('img/test.jpg') }}" class="auth-avatar" alt="Espace vendeur">

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

                        <form method="POST" action="{{ route('vendors.handleLogin') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label-modern">
                                    <i class="bi bi-envelope me-1"></i>Adresse Email
                                </label>
                                <input type="email" class="form-control form-control-modern" id="email" name="email"
                                    placeholder="contact@maboutique.com" value="{{ old('email') }}" required>
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

                            <button type="submit" class="btn btn-auth mb-3">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Se Connecter
                            </button>

                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Pas encore de boutique ? 
                                    <a href="{{ route('vendors.register') }}" class="text-decoration-none fw-bold">
                                        Créer une boutique
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