@extends('layouts.website-layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <div class="text-success mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                        </div>
                        <h1 class="h2 mb-3">Paiement réussi !</h1>
                        <p class="lead mb-4">Merci pour votre commande #{{ $order->id }}</p>
                        <p class="text-muted">Nous avons bien reçu votre paiement de <strong>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong>.</p>
                    </div>
                    
                    <div class="card bg-light mb-4">
                        <div class="card-body text-start">
                            <h5 class="card-title mb-3">Récapitulatif de la commande</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Numéro de commande :</span>
                                <strong>#{{ $order->id }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Date :</span>
                                <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Montant total :</span>
                                <strong>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Statut :</span>
                                <span class="badge bg-success">Payé</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <p class="mb-4">Un email de confirmation a été envoyé à <strong>{{ Auth::user()->email }}</strong> avec les détails de votre commande.</p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('user.orders') }}" class="btn btn-primary">Voir mes commandes</a>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Retour à l'accueil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
