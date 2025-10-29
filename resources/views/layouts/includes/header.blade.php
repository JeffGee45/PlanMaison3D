<nav class="navbar navbar-expand-lg navbar-modern">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="/">PlanMaison3D</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/">
                        <i class="bi bi-house-door me-1"></i>Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('house-plans.index') }}">
                        <i class="bi bi-building me-1"></i>Nos Plans
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">
                        <i class="bi bi-info-circle me-1"></i>À propos
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-grid me-1"></i>Catalogue
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('vendors.register') }}">
                            <i class="bi bi-shop me-2"></i>Devenir Vendeur
                        </a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">
                            <i class="bi bi-star me-2"></i>Plans Populaires
                        </a></li>
                        <li><a class="dropdown-item" href="#!">
                            <i class="bi bi-bookmark me-2"></i>Catégories
                        </a></li>
                        <li><a class="dropdown-item" href="#!">
                            <i class="bi bi-heart me-2"></i>Nouveautés
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">
                        <i class="bi bi-telephone me-1"></i>Contact
                    </a>
                </li>
            </ul>
            
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-cart" type="button">
                    <i class="bi-cart-fill me-2"></i>
                    Panier
                    <span class="badge bg-danger ms-2 rounded-pill">0</span>
                </button>

                @guest
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i>Compte
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('user.register') }}">
                                <i class="bi bi-person-plus me-2"></i>Créer un compte
                            </a>
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('user.login') }}">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                            </a>
                        </li>
                    </ul>
                </div>
                @endguest

                @auth
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="#!">
                                <i class="bi bi-person me-2"></i>Mon Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#!">
                                <i class="bi bi-bag me-2"></i>Mes Commandes
                            </a>
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('user.logout') }}">
                                <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </div>
    </div>
</nav>