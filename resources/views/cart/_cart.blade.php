@if(isset($items) && $items->count() > 0)
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($item->housePlan->image_path)
                                    <img src="{{ asset($item->housePlan->image_path) }}" alt="{{ $item->housePlan->name }}" class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center me-3" style="width: 80px; height: 80px;">
                                        <i class="bi bi-house-door text-muted" style="font-size: 2rem;"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $item->housePlan->name }}</h6>
                                    <div class="text-muted small">
                                        <span class="me-2"><i class="bi bi-rulers"></i> {{ $item->housePlan->surface_area }} m²</span>
                                        <span class="me-2"><i class="bi bi-door-open"></i> {{ $item->housePlan->bedrooms }} ch.</span>
                                        <span><i class="bi bi-droplet"></i> {{ $item->housePlan->bathrooms }} sdb</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ number_format($item->housePlan->price, 0, ',', ' ') }} €</td>
                        <td>
                            <div class="input-group" style="max-width: 120px;">
                                <button class="btn btn-outline-secondary btn-sm update-quantity" 
                                        data-item-id="{{ $item->id }}" 
                                        data-action="decrement">-</button>
                                <input type="number" 
                                       class="form-control form-control-sm text-center quantity-input" 
                                       value="{{ $item->quantity }}" 
                                       min="1" 
                                       data-item-id="{{ $item->id }}">
                                <button class="btn btn-outline-secondary btn-sm update-quantity" 
                                        data-item-id="{{ $item->id }}" 
                                        data-action="increment">+</button>
                            </div>
                        </td>
                        <td>{{ number_format($item->housePlan->price * $item->quantity, 0, ',', ' ') }} €</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="alert alert-info mb-0">
        Votre panier est vide. <a href="{{ route('house-plans.index') }}" class="alert-link">Parcourir nos plans</a>
    </div>
@endif
