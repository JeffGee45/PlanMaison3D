@extends('layouts.admin')

@section('title', 'Gestion des coupons')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Gestion des coupons</h1>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouveau coupon
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Valeur</th>
                            <th>Utilisations</th>
                            <th>Date de début</th>
                            <th>Date d'expiration</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                            <tr>
                                <td><code>{{ $coupon->code }}</code></td>
                                <td>{{ $coupon->name }}</td>
                                <td>
                                    @if($coupon->type === 'fixed')
                                        <span class="badge bg-info">Montant fixe</span>
                                    @else
                                        <span class="badge bg-success">Pourcentage</span>
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->type === 'fixed')
                                        {{ number_format($coupon->value, 2, ',', ' ') }} €
                                    @else
                                        {{ $coupon->value }}%
                                    @endif
                                </td>
                                <td>
                                    {{ $coupon->usage_count }}
                                    @if($coupon->usage_limit)
                                        / {{ $coupon->usage_limit }}
                                    @else
                                        / ∞
                                    @endif
                                </td>
                                <td>{{ $coupon->starts_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $coupon->expires_at ? $coupon->expires_at->format('d/m/Y H:i') : 'Illimité' }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-status" 
                                               type="checkbox" 
                                               data-id="{{ $coupon->id }}"
                                               {{ $coupon->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ $coupon->is_active ? 'Actif' : 'Inactif' }}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce coupon ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Aucun coupon trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle coupon status
        document.querySelectorAll('.toggle-status').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const couponId = this.dataset.id;
                const isActive = this.checked;
                
                fetch(`/admin/coupons/${couponId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'PATCH',
                        is_active: isActive
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const label = this.nextElementSibling;
                        label.textContent = data.is_active ? 'Actif' : 'Inactif';
                        
                        // Show success message
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-success alert-dismissible fade show mt-3';
                        alert.innerHTML = `
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        
                        const container = document.querySelector('.container-fluid');
                        container.insertBefore(alert, container.firstChild);
                        
                        // Auto-hide after 3 seconds
                        setTimeout(() => {
                            alert.classList.remove('show');
                            setTimeout(() => alert.remove(), 150);
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.checked = !isActive; // Revert the checkbox
                    alert('Une erreur est survenue lors de la mise à jour du statut du coupon.');
                });
            });
        });
    });
</script>
@endpush
