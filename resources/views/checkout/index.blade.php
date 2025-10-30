@extends('layouts.website-layout')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Paiement</h1>
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('process.payment') }}" method="POST" id="payment-form">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="mb-4">Informations de paiement</h5>
                                
                                <div class="mb-3">
                                    <label for="card-holder-name" class="form-label">Nom sur la carte</label>
                                    <input type="text" class="form-control" id="card-holder-name" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Détails de la carte</label>
                                    <div id="card-element" class="form-control p-2">
                                        <!-- Un élément Stripe sera inséré ici. -->
                                    </div>
                                    <div id="card-errors" class="text-danger mt-2" role="alert"></div>
                                </div>
                                
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg" id="submit-button">
                                        Payer {{ number_format($summary['total'], 0, ',', ' ') }} FCFA
                                    </button>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Récapitulatif</h5>
                                        
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Sous-total</span>
                                            <span>{{ number_format($summary['subtotal'], 0, ',', ' ') }} FCFA</span>
                                        </div>
                                        
                                        @if(isset($summary['discount']) && $summary['discount'] > 0)
                                            <div class="d-flex justify-content-between mb-2 text-success">
                                                <span>Réduction</span>
                                                <span>-{{ number_format($summary['discount'], 0, ',', ' ') }} FCFA</span>
                                            </div>
                                        @endif
                                        
                                        <hr>
                                        
                                        <div class="d-flex justify-content-between mb-3">
                                            <strong>Total</strong>
                                            <strong>{{ number_format($summary['total'], 0, ',', ' ') }} FCFA</strong>
                                        </div>
                                        
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="terms" required>
                                            <label class="form-check-label small" for="terms">
                                                J'accepte les <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">conditions générales de vente</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Conditions générales -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Conditions générales de vente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Acceptation des conditions</h6>
                <p>En passant commande sur notre site, vous acceptez sans réserve les présentes conditions générales de vente.</p>
                
                <h6 class="mt-4">2. Prix et paiement</h6>
                <p>Les prix sont indiqués en FCFA et sont valables tant qu'ils sont visibles sur le site. Le paiement est dû immédiatement après la commande.</p>
                
                <h6 class="mt-4">3. Livraison</h6>
                <p>Les plans de maison sont disponibles en téléchargement immédiat après confirmation du paiement.</p>
                
                <h6 class="mt-4">4. Droit de rétractation</h6>
                <p>Conformément à la législation en vigueur, vous disposez d'un délai de 14 jours pour exercer votre droit de rétractation.</p>
                
                <h6 class="mt-4">5. Propriété intellectuelle</h6>
                <p>Les plans achetés sont destinés à un usage personnel. Toute reproduction ou distribution est strictement interdite sans autorisation écrite.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Configuration de Stripe
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
            },
        },
    });
    
    cardElement.mount('#card-element');
    
    // Gestion des erreurs de saisie de la carte
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    
    // Soumission du formulaire
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        
        const submitButton = document.getElementById('submit-button');
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Traitement...';
        
        const {error, paymentMethod} = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
                name: document.getElementById('card-holder-name').value,
            },
        });
        
        if (error) {
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            submitButton.disabled = false;
            submitButton.textContent = 'Payer {{ number_format($summary['total'], 0, ',', ' ') }} FCFA';
        } else {
            // Ajouter le payment_method_id au formulaire et le soumettre
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'payment_method');
            hiddenInput.setAttribute('value', paymentMethod.id);
            form.appendChild(hiddenInput);
            
            // Soumettre le formulaire
            form.submit();
        }
    });
</script>
@endpush
