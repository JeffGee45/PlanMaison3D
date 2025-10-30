@extends('layouts.website-layout')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Votre Panier</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            @if(count($cartItems) > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        @include('cart._cart', ['items' => $cartItems])
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    Votre panier est vide. <a href="{{ route('house-plans.index') }}" class="alert-link">Parcourir nos plans</a>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            @if(count($cartItems) > 0)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Récapitulatif</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Sous-total</span>
                            <span>{{ number_format($summary['subtotal'], 0, ',', ' ') }} FCFA</span>
                        </div>
                        @if($summary['discount'] > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Réduction</span>
                                <span>-{{ number_format($summary['discount'], 0, ',', ' ') }} FCFA</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total</span>
                            <span class="fw-bold">{{ number_format($summary['total'], 0, ',', ' ') }} FCFA</span>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-primary w-100">Procéder au paiement</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
