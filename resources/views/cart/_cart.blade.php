
<div class="cart-container">
    @if($cartItems->count() > 0)
        <div class="cart-items">
            <h2>Votre Panier</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product->images->count() > 0)
                                            <img src="{{ asset('storage/' . $item->product->images->first()->path) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="img-thumbnail me-3" 
                                                 style="width: 80px;">
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $item->product->name }}</h6>
                                            @if(!empty($item->options))
                                                <small class="text-muted">
                                                    @foreach($item->options as $key => $value)
                                                        {{ ucfirst($key) }}: {{ $value }}@if(!$loop->last), @endif
                                                    @endforeach
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($item->price, 2, ',', ' ') }} €</td>
                                <td>
                                    <div class="input-group" style="width: 120px;">
                                        <button class="btn btn-outline-secondary update-quantity" 
                                                type="button" 
                                                data-item-id="{{ $item->id }}" 
                                                data-action="decrement">-</button>
                                        <input type="number" 
                                               class="form-control text-center quantity-input" 
                                               value="{{ $item->quantity }}" 
                                               min="1" 
                                               data-item-id="{{ $item->id }}">
                                        <button class="btn btn-outline-secondary update-quantity" 
                                                type="button" 
                                                data-item-id="{{ $item->id }}" 
                                                data-action="increment">+</button>
                                    </div>
                                </td>
                                <td>{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} €</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger remove-item" 
                                            data-item-id="{{ $item->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Code promo</h5>
                            @if($summary['coupon'])
                                <div class="alert alert-success">
                                    Code promo appliqué: {{ $summary['coupon']['code'] }}
                                    <button type="button" class="btn-close float-end remove-coupon" aria-label="Supprimer"></button>
                                </div>
                            @else
                                <form id="apply-coupon-form" class="d-flex">
                                    @csrf
                                    <input type="text" name="code" class="form-control me-2" placeholder="Entrez votre code promo">
                                    <button type="submit" class="btn btn-primary">Appliquer</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Récapitulatif de la commande</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Sous-total</span>
                                <span>{{ number_format($summary['subtotal'], 2, ',', ' ') }} €</span>
                            </div>
                            @if($summary['coupon'])
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span>Réduction ({{ $summary['coupon']['code'] }})</span>
                                    <span>-{{ number_format($summary['discount'], 2, ',', ' ') }} €</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-between mb-2">
                                <span>Taxes</span>
                                <span>{{ number_format($summary['tax'], 2, ',', ' ') }} €</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <span>{{ number_format($summary['total'], 2, ',', ' ') }} €</span>
                            </div>
                            <div class="d-grid gap-2 mt-3">
                                <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">Passer la commande</a>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Continuer mes achats</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
            <h3>Votre panier est vide</h3>
            <p class="text-muted">Parcourez nos produits et ajoutez des articles à votre panier</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Découvrir nos produits</a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartContainer = document.querySelector('.cart-container');

        // --- Event Listeners ---
        cartContainer.addEventListener('click', function(e) {
            // Update quantity buttons
            if (e.target.matches('.update-quantity')) {
                const input = e.target.closest('.input-group').querySelector('.quantity-input');
                const itemId = e.target.dataset.itemId;
                let quantity = parseInt(input.value);
                
                if (e.target.dataset.action === 'increment') quantity++;
                else if (e.target.dataset.action === 'decrement' && quantity > 1) quantity--;
                
                updateCartItem(itemId, quantity);
            }

            // Remove item button
            if (e.target.matches('.remove-item') || e.target.closest('.remove-item')) {
                 e.preventDefault();
                if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
                    const itemId = e.target.closest('.remove-item').dataset.itemId;
                    removeCartItem(itemId);
                }
            }

            // Remove coupon button
            if (e.target.matches('.remove-coupon') || e.target.closest('.remove-coupon')) {
                e.preventDefault();
                removeCoupon();
            }
        });

        // Quantity input change
        cartContainer.addEventListener('change', function(e) {
            if (e.target.matches('.quantity-input')) {
                const itemId = e.target.dataset.itemId;
                let quantity = parseInt(e.target.value);
                if (quantity < 1) {
                    quantity = 1;
                    e.target.value = 1;
                }
                updateCartItem(itemId, quantity);
            }
        });

        // Apply coupon form
        cartContainer.addEventListener('submit', function(e) {
            if (e.target.id === 'apply-coupon-form') {
                e.preventDefault();
                const code = e.target.querySelector('input[name="code"]').value.trim();
                if (code) applyCoupon(code);
            }
        });

        // --- AJAX Functions ---
        const sendRequest = (url, method, body) => {
            const headers = {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            };
            return fetch(url, { method, headers, body: JSON.stringify(body) });
        };

        function updateCartItem(itemId, quantity) {
            const url = `{{ route('api.cart.update', ['itemId' => ':itemId']) }}`.replace(':itemId', itemId);
            sendRequest(url, 'PUT', { quantity })
                .then(res => res.json()).then(handleResponse).catch(handleError);
        }

        function removeCartItem(itemId) {
            const url = `{{ route('api.cart.remove', ['itemId' => ':itemId']) }}`.replace(':itemId', itemId);
            sendRequest(url, 'DELETE').then(res => res.json()).then(handleResponse).catch(handleError);
        }

        function applyCoupon(code) {
            sendRequest(`{{ route('api.cart.applyCoupon') }}`, 'POST', { code })
                .then(res => res.json()).then(handleResponse).catch(handleError);
        }

        function removeCoupon() {
            sendRequest(`{{ route('api.cart.removeCoupon') }}`, 'DELETE')
                .then(res => res.json()).then(handleResponse).catch(handleError);
        }

        // --- UI Update Functions ---
        function handleResponse(data) {
            if (data.success && data.data) {
                updateCartView(data.data);
                showToast(data.message || 'Panier mis à jour !');
            } else {
                showToast(data.message || 'Une erreur est survenue.', 'error');
            }
        }

        function handleError(error) {
            console.error('Cart Error:', error);
            showToast('Une erreur réseau est survenue.', 'error');
        }

        function updateCartView(cart) {
            const cartBody = cartContainer.querySelector('tbody');
            const summaryContainer = cartContainer.querySelector('.summary-container');
            
            if (cart.items.length === 0) {
                cartContainer.innerHTML = `
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                        <h3>Votre panier est vide</h3>
                        <p class="text-muted">Parcourez nos produits et ajoutez des articles à votre panier</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">Découvrir nos produits</a>
                    </div>`;
                return;
            }

            // Update items
            cartBody.innerHTML = cart.items.map(item => `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="/storage/${item.product.image}" alt="${item.product.name}" class="img-thumbnail me-3" style="width: 80px;">
                            <div>
                                <h6 class="mb-0">${item.product.name}</h6>
                                ${item.options ? `<small class="text-muted">${Object.entries(item.options).map(([k,v]) => `${k}: ${v}`).join(', ')}</small>` : ''}
                            </div>
                        </div>
                    </td>
                    <td>${parseFloat(item.price).toFixed(2)} €</td>
                    <td>
                        <div class="input-group" style="width: 120px;">
                            <button class="btn btn-outline-secondary update-quantity" type="button" data-item-id="${item.id}" data-action="decrement">-</button>
                            <input type="number" class="form-control text-center quantity-input" value="${item.quantity}" min="1" data-item-id="${item.id}">
                            <button class="btn btn-outline-secondary update-quantity" type="button" data-item-id="${item.id}" data-action="increment">+</button>
                        </div>
                    </td>
                    <td>${(item.price * item.quantity).toFixed(2)} €</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger remove-item" data-item-id="${item.id}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `).join('');

            // Update summary
            summaryContainer.querySelector('.subtotal-value').textContent = `${parseFloat(cart.subtotal).toFixed(2)} €`;
            summaryContainer.querySelector('.tax-value').textContent = `${parseFloat(cart.tax).toFixed(2)} €`;
            summaryContainer.querySelector('.total-value').textContent = `${parseFloat(cart.total).toFixed(2)} €`;

            const discountRow = summaryContainer.querySelector('.discount-row');
            const couponFormContainer = cartContainer.querySelector('.coupon-form-container');

            if (cart.coupon) {
                discountRow.querySelector('.discount-code').textContent = `Réduction (${cart.coupon.code})`;
                discountRow.querySelector('.discount-value').textContent = `-${parseFloat(cart.discount).toFixed(2)} €`;
                discountRow.classList.remove('d-none');
                couponFormContainer.innerHTML = `
                    <div class="alert alert-success d-flex justify-content-between align-items-center">
                        <span>Code: <strong>${cart.coupon.code}</strong></span>
                        <button class="btn-close remove-coupon"></button>
                    </div>`;
            } else {
                discountRow.classList.add('d-none');
                couponFormContainer.innerHTML = `
                    <form id="apply-coupon-form" class="d-flex">
                        @csrf
                        <input type="text" name="code" class="form-control me-2" placeholder="Entrez votre code promo">
                        <button type="submit" class="btn btn-primary">Appliquer</button>
                    </form>`;
            }
        }

        function showToast(message, type = 'success') {
            // Implement a toast notification system (e.g., using Bootstrap Toasts or a library)
            alert(message); // Placeholder
        }
    });
</script>
@endpush
