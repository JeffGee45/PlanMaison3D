@extends('layouts.admin')

@section('title', 'Détails du coupon')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Détails du coupon</h1>
        <div>
            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informations générales</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Code :</div>
                        <div class="col-md-8">
                            <code class="fs-5">{{ $coupon->code }}</code>
                            <button class="btn btn-sm btn-outline-secondary ms-2" 
                                    onclick="navigator.clipboard.writeText('{{ $coupon->code }}').then(() => {
                                        const tooltip = new bootstrap.Tooltip(document.getElementById('copy-tooltip'), {
                                            title: 'Copié !',
                                            trigger: 'manual'
                                        });
                                        tooltip.show();
                                        setTimeout(() => tooltip.hide(), 1000);
                                    });">
                                <i class="fas fa-copy" id="copy-tooltip" data-bs-toggle="tooltip"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nom :</div>
                        <div class="col-md-8">{{ $coupon->name }}</div>
                    </div>
                    
                    @if($coupon->description)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Description :</div>
                        <div class="col-md-8">{{ $coupon->description }}</div>
                    </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Type de réduction :</div>
                        <div class="col-md-8">
                            @if($coupon->type === 'fixed')
                                <span class="badge bg-info">Montant fixe</span>
                            @else
                                <span class="badge bg-success">Pourcentage</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Valeur :</div>
                        <div class="col-md-8">
                            @if($coupon->type === 'fixed')
                                {{ number_format($coupon->value, 2, ',', ' ') }} €
                            @else
                                {{ $coupon->value }}%
                            @endif
                            
                            @if($coupon->min_cart_amount)
                                <span class="text-muted ms-2">(Minimum d'achat : {{ number_format($coupon->min_cart_amount, 2, ',', ' ') }} €)</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Statut :</div>
                        <div class="col-md-8">
                            @if($coupon->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                            
                            @if($coupon->isValid())
                                <span class="badge bg-success ms-2">Valide</span>
                            @else
                                <span class="badge bg-danger ms-2">Invalide</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Période de validité</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Date de début :</div>
                        <div class="col-md-8">
                            {{ $coupon->starts_at->format('d/m/Y H:i') }}
                            @if($coupon->starts_at->isFuture())
                                <span class="badge bg-warning text-dark ms-2">À venir</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 fw-bold">Date d'expiration :</div>
                        <div class="col-md-8">
                            @if($coupon->expires_at)
                                {{ $coupon->expires_at->format('d/m/Y H:i') }}
                                @if($coupon->expires_at->isPast())
                                    <span class="badge bg-danger ms-2">Expiré</span>
                                @else
                                    <span class="text-muted">({{ $coupon->expires_at->diffForHumans() }})</span>
                                @endif
                            @else
                                <span class="text-muted">Aucune date d'expiration</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Utilisation</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <div class="display-4 fw-bold">
                            {{ $coupon->usage_count }}
                        </div>
                        <div class="text-muted">Utilisations</div>
                    </div>
                    
                    @if($coupon->usage_limit)
                        <div class="progress mb-3" style="height: 20px;">
                            @php
                                $percentage = min(100, ($coupon->usage_count / $coupon->usage_limit) * 100);
                            @endphp
                            <div class="progress-bar bg-{{ $percentage >= 100 ? 'danger' : 'success' }}" 
                                 role="progressbar" 
                                 style="width: {{ $percentage }}%" 
                                 aria-valuenow="{{ $percentage }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                {{ number_format($percentage, 1) }}%
                            </div>
                        </div>
                        <div class="text-muted mb-3">
                            Limite : {{ $coupon->usage_limit }} utilisations
                        </div>
                    @else
                        <div class="text-muted mb-3">
                            Pas de limite d'utilisation
                        </div>
                    @endif
                    
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.coupons.toggle-status', $coupon) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $coupon->is_active ? 'warning' : 'success' }} w-100 mb-2">
                                <i class="fas fa-{{ $coupon->is_active ? 'pause' : 'check' }}"></i>
                                {{ $coupon->is_active ? 'Désactiver' : 'Activer' }}
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        
                        <button type="button" class="btn btn-outline-danger w-100" 
                                data-bs-toggle="modal" data-bs-target="#deleteCouponModal">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Code d'intégration</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Utilisez ce code pour intégrer ce coupon dans vos communications :
                    </p>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" value="{{ $coupon->code }}" id="coupon-code" readonly>
                        <button class="btn btn-outline-secondary" type="button" 
                                onclick="copyToClipboard('coupon-code')">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                    
                    <p class="text-muted">
                        Lien de partage :
                    </p>
                    <div class="input-group">
                        <input type="text" class="form-control" 
                               value="{{ url('/') }}?coupon={{ $coupon->code }}" 
                               id="coupon-link" readonly>
                        <button class="btn btn-outline-secondary" type="button" 
                                onclick="copyToClipboard('coupon-link')">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCouponModal" tabindex="-1" aria-labelledby="deleteCouponModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteCouponModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer définitivement ce coupon ?</p>
                <p class="mb-0">Cette action est irréversible et affectera tous les utilisateurs qui utilisent actuellement ce coupon.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Enable tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Copy to clipboard function
    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        element.select();
        element.setSelectionRange(0, 99999); // For mobile devices
        
        try {
            const successful = document.execCommand('copy');
            const message = successful ? 'Copié !' : 'Échec de la copie';
            
            // Show feedback
            const tooltip = new bootstrap.Tooltip(element.nextElementSibling, {
                title: message,
                trigger: 'manual'
            });
            tooltip.show();
            
            // Hide after 1 second
            setTimeout(() => {
                tooltip.hide();
                setTimeout(() => tooltip.dispose(), 150);
            }, 1000);
            
            return successful;
        } catch (err) {
            console.error('Erreur lors de la copie :', err);
            return false;
        }
    }
    
    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
</script>
@endpush
