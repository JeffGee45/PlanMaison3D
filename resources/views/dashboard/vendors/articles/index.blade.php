@extends('layouts.vendor-dashboard-layout')

@section('content')
<style>
    .modern-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }
    
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
    }
    
    .stats-icon {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    
    .product-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }
    
    .product-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }
    
    .badge-modern {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .btn-modern {
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state-icon {
        font-size: 80px;
        color: #dee2e6;
        margin-bottom: 24px;
    }
</style>

<div class="container-fluid px-4 py-4">
    <!-- En-tête moderne -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-2">
                        <i class="fas fa-home text-primary me-2"></i>Mes Plans de Maison
                    </h1>
                    <p class="text-muted mb-0">Gérez votre catalogue de plans</p>
                </div>
                <div>
                    <a href="{{ route('articles.create') }}" class="btn btn-primary btn-modern">
                        <i class="fas fa-plus-circle me-2"></i>Nouveau Plan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages de succès -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show modern-card mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ $articles->count() }}</h3>
                        <p class="mb-0 opacity-75">Plans Totaux</p>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-home"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ $articles->where('status', true)->count() }}</h3>
                        <p class="mb-0 opacity-75">Actifs</p>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ number_format($articles->sum('price'), 0, ',', ' ') }}</h3>
                        <p class="mb-0 opacity-75">Valeur Totale (FCFA)</p>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold mb-1">{{ number_format($articles->avg('price'), 0, ',', ' ') }}</h3>
                        <p class="mb-0 opacity-75">Prix Moyen (FCFA)</p>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des plans -->
    @if($articles->count() > 0)
        <div class="row">
            @foreach ($articles as $article)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card product-card">
                        <div class="position-relative">
                            @if($article->image)
                                <img src="{{ Storage::url($article->image) }}" class="product-image" alt="{{ $article->name }}">
                            @else
                                <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image text-muted" style="font-size: 48px;"></i>
                                </div>
                            @endif
                            
                            @if($article->status)
                                <span class="badge bg-success badge-modern position-absolute top-0 end-0 m-3">
                                    <i class="fas fa-check-circle me-1"></i>Actif
                                </span>
                            @else
                                <span class="badge bg-secondary badge-modern position-absolute top-0 end-0 m-3">
                                    <i class="fas fa-pause-circle me-1"></i>Inactif
                                </span>
                            @endif
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-2">{{ $article->name }}</h5>
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($article->description, 80) }}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <small class="text-muted d-block">Prix</small>
                                    <h5 class="fw-bold text-primary mb-0">
                                        {{ number_format($article->price, 0, ',', ' ') }} FCFA
                                    </h5>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Créé le</small>
                                    <small class="fw-semibold">{{ $article->created_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="fas fa-eye me-1"></i>Voir
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-secondary flex-fill">
                                    <i class="fas fa-edit me-1"></i>Modifier
                                </a>
                                <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $article->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- État vide -->
        <div class="modern-card">
            <div class="card-body">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Aucun plan pour le moment</h4>
                    <p class="text-muted mb-4">Commencez par créer votre premier plan de maison</p>
                    <a href="{{ route('articles.create') }}" class="btn btn-primary btn-modern">
                        <i class="fas fa-plus-circle me-2"></i>Créer mon Premier Plan
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce plan ?')) {
        // Logique de suppression à implémenter
        console.log('Suppression du plan ID:', id);
    }
}
</script>
@endsection
