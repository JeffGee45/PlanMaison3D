@extends('layouts.vendor-dashboard-layout')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <div>
                <h1 class="h3 mb-0">Tableau de Bord</h1>
                <p class="text-muted mb-0">Bienvenue, {{ auth('vendor')->user()->name }}</p>
            </div>
            <div>
                <a href="{{ route('articles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nouveau Plan
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Total Ventes</div>
                            <div class="stat-value">0</div>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>0% ce mois
                            </small>
                        </div>
                        <div class="stat-icon bg-primary bg-gradient">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Revenus</div>
                            <div class="stat-value">0 <small>CFA</small></div>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>0% ce mois
                            </small>
                        </div>
                        <div class="stat-icon bg-success bg-gradient">
                            <i class="fas fa-dollar-sign text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Plans Actifs</div>
                            <div class="stat-value">0</div>
                            <small class="text-muted">
                                <i class="fas fa-home me-1"></i>Total publié
                            </small>
                        </div>
                        <div class="stat-icon bg-warning bg-gradient">
                            <i class="fas fa-box text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Clients</div>
                            <div class="stat-value">0</div>
                            <small class="text-muted">
                                <i class="fas fa-users me-1"></i>Acheteurs uniques
                            </small>
                        </div>
                        <div class="stat-icon bg-danger bg-gradient">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card dashboard-card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Évolution des Ventes</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card dashboard-card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Catégories</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="card dashboard-card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Commandes Récentes</h5>
                <a href="#!" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Plan</th>
                                <th>Montant</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    Aucune commande pour le moment
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card dashboard-card text-center">
                    <div class="card-body">
                        <i class="fas fa-plus-circle fa-3x text-primary mb-3"></i>
                        <h5>Ajouter un Plan</h5>
                        <p class="text-muted">Publiez un nouveau plan de maison</p>
                        <a href="{{ route('articles.create') }}" class="btn btn-primary">Commencer</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card text-center">
                    <div class="card-body">
                        <i class="fas fa-list fa-3x text-success mb-3"></i>
                        <h5>Gérer les Plans</h5>
                        <p class="text-muted">Modifiez vos plans existants</p>
                        <a href="{{ route('articles.index') }}" class="btn btn-success">Voir la liste</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card text-center">
                    <div class="card-body">
                        <i class="fas fa-cog fa-3x text-warning mb-3"></i>
                        <h5>Configuration</h5>
                        <p class="text-muted">Paramètres de votre boutique</p>
                        <a href="#!" class="btn btn-warning">Configurer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script>
        // Sales Chart
        const salesCtx = document.getElementById('salesChart');
        if (salesCtx) {
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                    datasets: [{
                        label: 'Ventes',
                        data: [0, 0, 0, 0, 0, 0],
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart');
        if (categoryCtx) {
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Moderne', 'Villa', 'Duplex'],
                    datasets: [{
                        data: [0, 0, 0],
                        backgroundColor: ['#667eea', '#10b981', '#f59e0b']
                    }]
                }
            });
        }
    </script>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('demo/chart-bar-demo.js') }}"></script>
@endpush

@endsection
