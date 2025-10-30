@extends('layouts.website-layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Mes Commandes</h4>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>N° Commande</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($order->status === 'completed')
                                                    <span class="badge bg-success">Terminée</span>
                                                @elseif($order->status === 'pending')
                                                    <span class="badge bg-warning">En attente</span>
                                                @elseif($order->status === 'cancelled')
                                                    <span class="badge bg-danger">Annulée</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $order->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
                                            <td>
                                                <a href="#!" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderDetails{{ $order->id }}">
                                                    <i class="bi bi-eye"></i> Détails
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Modal Détails de la commande -->
                                        <div class="modal fade" id="orderDetails{{ $order->id }}" tabindex="-1" aria-labelledby="orderDetailsLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="orderDetailsLabel">Détails de la commande #{{ $order->id }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-4">
                                                            <div class="col-md-6">
                                                                <h6>Détails de la commande</h6>
                                                                <p class="mb-1"><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                                                <p class="mb-1"><strong>Statut :</strong> 
                                                                    @if($order->status === 'completed')
                                                                        <span class="badge bg-success">Terminée</span>
                                                                    @elseif($order->status === 'pending')
                                                                        <span class="badge bg-warning">En attente</span>
                                                                    @elseif($order->status === 'cancelled')
                                                                        <span class="badge bg-danger">Annulée</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>Adresse de facturation</h6>
                                                                <p class="mb-1">{{ $order->billing_name }}</p>
                                                                <p class="mb-1">{{ $order->billing_address }}</p>
                                                                <p class="mb-1">{{ $order->billing_city }}, {{ $order->billing_postcode }}</p>
                                                                <p class="mb-0">{{ $order->billing_country }}</p>
                                                            </div>
                                                        </div>

                                                        <h6>Articles commandés</h6>
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Produit</th>
                                                                        <th>Prix unitaire</th>
                                                                        <th>Quantité</th>
                                                                        <th>Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($order->items as $item)
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    @if($item->product && $item->product->image)
                                                                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->name }}" class="img-thumbnail me-2" style="width: 50px;">
                                                                                    @endif
                                                                                    <div>
                                                                                        <h6 class="mb-0">{{ $item->name }}</h6>
                                                                                        <small class="text-muted">Réf: {{ $item->product->id ?? 'N/A' }}</small>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>{{ number_format($item->price, 0, ',', ' ') }} FCFA</td>
                                                                            <td>{{ $item->quantity }}</td>
                                                                            <td>{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} FCFA</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                @if($order->notes)
                                                                    <div class="alert alert-info">
                                                                        <h6>Notes :</h6>
                                                                        <p class="mb-0">{{ $order->notes }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th>Sous-total :</th>
                                                                                <td class="text-end">{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</td>
                                                                            </tr>
                                                                            @if($order->discount > 0)
                                                                                <tr>
                                                                                    <th>Réduction :</th>
                                                                                    <td class="text-end">-{{ number_format($order->discount, 0, ',', ' ') }} FCFA</td>
                                                                                </tr>
                                                                            @endif
                                                                            <tr>
                                                                                <th>Frais de livraison :</th>
                                                                                <td class="text-end">{{ number_format($order->shipping, 0, ',', ' ') }} FCFA</td>
                                                                            </tr>
                                                                            <tr class="table-active">
                                                                                <th>Total :</th>
                                                                                <th class="text-end">{{ number_format($order->total, 0, ',', ' ') }} FCFA</th>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        @if($order->status === 'pending')
                                                            <button type="button" class="btn btn-danger">Annuler la commande</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-cart-x display-1 text-muted"></i>
                            </div>
                            <h4>Vous n'avez pas encore passé de commande</h4>
                            <p class="text-muted mb-4">Parcourez notre catalogue et trouvez des articles qui vous plaisent.</p>
                            <a href="{{ route('house-plans.index') }}" class="btn btn-primary">Voir les plans disponibles</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }
    .order-item {
        transition: all 0.3s ease;
    }
    .order-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    // Script pour gérer les interactions de la page des commandes
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser les tooltips de Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush

@endsection
