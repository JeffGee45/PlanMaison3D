@extends('layouts.admin')

@section('title', 'Créer un coupon')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Créer un coupon</h1>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom du coupon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="code" class="form-label">Code (laisser vide pour générer automatiquement)</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                       id="code" name="code" value="{{ old('code') }}">
                                <button class="btn btn-outline-secondary" type="button" id="generate-code">
                                    <i class="fas fa-sync-alt"></i> Générer
                                </button>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="2">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="type" class="form-label">Type de réduction <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Montant fixe</option>
                                <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Pourcentage</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="value" class="form-label">Valeur <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0.01" 
                                       class="form-control @error('value') is-invalid @enderror" 
                                       id="value" name="value" value="{{ old('value') }}" required>
                                <span class="input-group-text" id="value-addon">€</span>
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="min_cart_amount" class="form-label">Montant minimum du panier</label>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('min_cart_amount') is-invalid @enderror" 
                                       id="min_cart_amount" name="min_cart_amount" 
                                       value="{{ old('min_cart_amount') }}">
                                <span class="input-group-text">€</span>
                                @error('min_cart_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Laissez vide pour aucun minimum</small>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="starts_at" class="form-label">Date de début <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('starts_at') is-invalid @enderror" 
                                   id="starts_at" name="starts_at" 
                                   value="{{ old('starts_at', now()->format('Y-m-d\TH:i')) }}" required>
                            @error('starts_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="expires_at" class="form-label">Date d'expiration</label>
                            <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror" 
                                   id="expires_at" name="expires_at" 
                                   value="{{ old('expires_at') }}">
                            @error('expires_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="no_expiry">
                                <label class="form-check-label" for="no_expiry">
                                    Pas de date d'expiration
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="usage_limit" class="form-label">Limite d'utilisation</label>
                            <input type="number" min="1" class="form-control @error('usage_limit') is-invalid @enderror" 
                                   id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}">
                            @error('usage_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Laissez vide pour une utilisation illimitée</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-check form-switch mt-4 pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Activer ce coupon</label>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary me-md-2">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle expiry date
        const expiresAtInput = document.getElementById('expires_at');
        const noExpiryCheckbox = document.getElementById('no_expiry');
        
        noExpiryCheckbox.addEventListener('change', function() {
            expiresAtInput.disabled = this.checked;
            if (this.checked) {
                expiresAtInput.value = '';
            }
        });
        
        // Set initial state
        if (!expiresAtInput.value) {
            noExpiryCheckbox.checked = true;
            expiresAtInput.disabled = true;
        }
        
        // Generate random code
        document.getElementById('generate-code').addEventListener('click', function() {
            const code = Math.random().toString(36).substring(2, 10).toUpperCase();
            document.getElementById('code').value = code;
        });
        
        // Toggle value suffix based on type
        const typeSelect = document.getElementById('type');
        const valueAddon = document.getElementById('value-addon');
        const valueInput = document.getElementById('value');
        
        function updateValueSuffix() {
            if (typeSelect.value === 'percent') {
                valueAddon.textContent = '%';
                valueInput.step = '1';
                valueInput.max = '100';
            } else {
                valueAddon.textContent = '€';
                valueInput.step = '0.01';
                valueInput.removeAttribute('max');
            }
        }
        
        typeSelect.addEventListener('change', updateValueSuffix);
        
        // Initialize on page load
        updateValueSuffix();
    });
</script>
@endpush
