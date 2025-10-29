@extends('layouts.vendor-dashboard-layout')

@section('content')
<style>
    /* Styles personnalisés pour une meilleure ergonomie */
    .modern-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }
    
    .modern-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
    }
    
    .form-control-modern {
        border-radius: 12px;
        border: 2px solid #e9ecef;
        padding: 12px 16px;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    
    .form-control-modern:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }
    
    .upload-zone {
        border: 3px dashed #dee2e6;
        border-radius: 16px;
        padding: 40px;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .upload-zone:hover {
        border-color: #0d6efd;
        background: #e7f1ff;
    }
    
    .upload-zone.dragover {
        border-color: #0d6efd;
        background: #cfe2ff;
    }
    
    .preview-container {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        margin-top: 20px;
    }
    
    .preview-image {
        max-height: 400px;
        width: 100%;
        object-fit: cover;
        border-radius: 16px;
    }
    
    .remove-image {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .remove-image:hover {
        background: #dc3545;
        transform: scale(1.1);
    }
    
    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #e9ecef;
    }
    
    .section-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }
    
    .btn-modern {
        border-radius: 12px;
        padding: 12px 32px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .tip-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
    }
    
    .tip-item {
        display: flex;
        align-items: start;
        gap: 12px;
        margin-bottom: 16px;
    }
    
    .tip-item:last-child {
        margin-bottom: 0;
    }
    
    .tip-icon {
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .preview-card {
        background: #f8f9fa;
        border-radius: 16px;
        padding: 20px;
        border: 2px solid #e9ecef;
    }
    
    .preview-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .char-counter {
        font-size: 12px;
        color: #6c757d;
        text-align: right;
        margin-top: 4px;
    }
    
    .progress-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 32px;
        position: relative;
    }
    
    .progress-step {
        flex: 1;
        text-align: center;
        position: relative;
    }
    
    .progress-step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .progress-step.active .progress-step-circle {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .progress-step.completed .progress-step-circle {
        background: #28a745;
        color: white;
    }
</style>

<div class="container-fluid px-4 py-4">
    <!-- En-tête moderne -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-2">
                        <i class="fas fa-plus-circle text-primary me-2"></i>Créer un Nouveau Plan
                    </h1>
                    <p class="text-muted mb-0">Ajoutez un nouveau plan de maison à votre catalogue</p>
                </div>
                <div>
                    <a href="{{ route('articles.index') }}" class="btn btn-light btn-modern">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages d'alerte -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show modern-card mb-4" role="alert">
            <div class="d-flex align-items-center mb-2">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Erreurs de validation</strong>
            </div>
            <ul class="mb-0 ps-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show modern-card mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('articles.handleCreate') }}" method="POST" enctype="multipart/form-data" id="createPlanForm">
        @csrf
        
        <div class="row">
            <!-- Colonne principale du formulaire -->
            <div class="col-lg-8">
                <!-- Section 1: Image du plan -->
                <div class="modern-card mb-4">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-image"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Image du Plan</h5>
                                <small class="text-muted">Ajoutez une image attractive de votre plan</small>
                            </div>
                        </div>

                        <div class="upload-zone" id="uploadZone">
                            <input type="file" 
                                   name="image" 
                                   id="imageInput" 
                                   accept="image/*" 
                                   class="d-none"
                                   @error('image') is-invalid @enderror>
                            
                            <div id="uploadContent">
                                <div class="mb-3">
                                    <i class="fas fa-cloud-upload-alt text-primary" style="font-size: 48px;"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Glissez-déposez votre image ici</h6>
                                <p class="text-muted mb-3">ou cliquez pour parcourir vos fichiers</p>
                                <button type="button" class="btn btn-primary btn-modern" onclick="document.getElementById('imageInput').click()">
                                    <i class="fas fa-folder-open me-2"></i>Choisir une image
                                </button>
                                <p class="text-muted small mt-3 mb-0">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Formats acceptés: JPG, PNG, GIF • Taille max: 2 Mo • Résolution recommandée: 1200x800px
                                </p>
                            </div>
                        </div>

                        <div id="previewContainer" class="preview-container d-none">
                            <img id="imagePreview" src="" alt="Aperçu" class="preview-image">
                            <button type="button" class="remove-image" onclick="removeImage()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        @error('image')
                            <div class="text-danger mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Section 2: Informations de base -->
                <div class="modern-card mb-4">
                    <div class="card-body p-4">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Informations de Base</h5>
                                <small class="text-muted">Décrivez votre plan en détail</small>
                            </div>
                        </div>

                        <!-- Nom du plan -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                Nom du Plan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-modern @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Ex: Villa Moderne 3 Chambres avec Piscine"
                                   maxlength="255"
                                   required>
                            <div class="char-counter">
                                <span id="nameCounter">0</span>/255 caractères
                            </div>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                Description Détaillée <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control form-control-modern @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="6" 
                                      placeholder="Décrivez les caractéristiques principales de votre plan: nombre de pièces, surface, style architectural, matériaux, équipements..."
                                      maxlength="2000"
                                      required>{{ old('description') }}</textarea>
                            <div class="char-counter">
                                <span id="descCounter">0</span>/2000 caractères
                            </div>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Prix -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="price" class="form-label fw-semibold">
                                    Prix (FCFA) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-money-bill-wave text-success"></i>
                                    </span>
                                    <input type="number" 
                                           class="form-control form-control-modern @error('price') is-invalid @enderror" 
                                           id="price" 
                                           name="price" 
                                           value="{{ old('price') }}" 
                                           min="0" 
                                           step="0.01" 
                                           placeholder="50000"
                                           required>
                                    <span class="input-group-text bg-light">FCFA</span>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Prix en Francs CFA
                                </small>
                                @error('price')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="category_id" class="form-label fw-semibold">
                                    Catégorie
                                </label>
                                <select class="form-select form-control-modern @error('category_id') is-invalid @enderror" 
                                        id="category_id" 
                                        name="category_id">
                                    <option value="">Sélectionnez une catégorie</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="modern-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="reset" class="btn btn-outline-secondary btn-modern">
                                <i class="fas fa-undo me-2"></i>Réinitialiser
                            </button>
                            <button type="submit" class="btn btn-primary btn-modern" id="submitBtn">
                                <i class="fas fa-check-circle me-2"></i>Publier le Plan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne latérale -->
            <div class="col-lg-4">
                <!-- Aperçu en temps réel -->
                <div class="modern-card mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-eye text-primary me-2"></i>Aperçu en Temps Réel
                        </h6>
                        <div class="preview-card">
                            <div class="mb-3">
                                <div id="previewCardImage" 
                                     class="img-fluid rounded d-flex align-items-center justify-content-center bg-light" 
                                     style="width: 100%; height: 200px; overflow: hidden; background-color: #e9ecef; color: #6c757d;">
                                    <div class="text-center">
                                        <i class="bi bi-image" style="font-size: 2rem;"></i>
                                        <p class="mb-0 mt-2">Aperçu de l'image</p>
                                    </div>
                                </div>
                            </div>
                            <div class="preview-badge mb-2">Nouveau</div>
                            <h6 class="fw-bold mb-2" id="previewTitle">Titre de votre plan</h6>
                            <p class="text-muted small mb-3" id="previewDesc">Description de votre plan...</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">
                                    <i class="fas fa-tag me-1"></i>Prix
                                </span>
                                <span class="fw-bold text-primary" id="previewPrice">0 FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Conseils -->
                <div class="tip-card">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-lightbulb me-2"></i>Conseils pour Réussir
                    </h6>
                    
                    <div class="tip-item">
                        <div class="tip-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong class="d-block mb-1">Titre Accrocheur</strong>
                            <small>Utilisez des mots-clés descriptifs et précis</small>
                        </div>
                    </div>

                    <div class="tip-item">
                        <div class="tip-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong class="d-block mb-1">Description Complète</strong>
                            <small>Détaillez toutes les caractéristiques importantes</small>
                        </div>
                    </div>

                    <div class="tip-item">
                        <div class="tip-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong class="d-block mb-1">Image de Qualité</strong>
                            <small>Utilisez des photos nettes et bien éclairées</small>
                        </div>
                    </div>

                    <div class="tip-item">
                        <div class="tip-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong class="d-block mb-1">Prix Compétitif</strong>
                            <small>Fixez un prix juste et attractif</small>
                        </div>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="modern-card">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-chart-line text-success me-2"></i>Optimisation
                        </h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small">Titre</span>
                            <span class="badge bg-success" id="titleStatus">Non rempli</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small">Description</span>
                            <span class="badge bg-success" id="descStatus">Non rempli</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small">Prix</span>
                            <span class="badge bg-success" id="priceStatus">Non rempli</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small">Image</span>
                            <span class="badge bg-warning" id="imageStatus">Non ajoutée</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de l'upload d'image
    const uploadZone = document.getElementById('uploadZone');
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const uploadContent = document.getElementById('uploadContent');
    const previewCardImage = document.getElementById('previewCardImage');
    const imageStatus = document.getElementById('imageStatus');

    // Click sur la zone d'upload
    uploadZone.addEventListener('click', function(e) {
        if (e.target !== imageInput) {
            imageInput.click();
        }
    });

    // Drag & Drop
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadZone.classList.add('dragover');
    });

    uploadZone.addEventListener('dragleave', function() {
        uploadZone.classList.remove('dragover');
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            handleImageUpload(files[0]);
        }
    });

    function handleImageUpload(file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Mettre à jour l'aperçu avec l'image téléchargée
            previewCardImage.innerHTML = `
                <img src="${e.target.result}" 
                     alt="Aperçu de l'image" 
                     class="img-fluid rounded" 
                     style="width: 100%; height: 100%; object-fit: cover;">`;
            
            previewContainer.classList.remove('d-none');
            uploadContent.classList.add('d-none');
            imageStatus.textContent = 'Image ajoutée';
            imageStatus.classList.remove('bg-warning');
            imageStatus.classList.add('bg-success');
        };
        
        reader.readAsDataURL(file);
    }

    // Changement de fichier
    imageInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            handleImageUpload(e.target.files[0]);
        }
    });

    // Suppression de l'image
    window.removeImage = function() {
        imageInput.value = '';
        uploadContent.classList.remove('d-none');
        previewContainer.classList.add('d-none');
        // Afficher le conteneur de prévisualisation avec un placeholder
        previewCardImage.innerHTML = `
            <div class="text-center w-100">
                <i class="bi bi-image" style="font-size: 2rem;"></i>
                <p class="mb-0 mt-2">Aperçu de l'image</p>
            </div>`;
        imageStatus.textContent = 'Non ajoutée';
        imageStatus.classList.remove('bg-success');
        imageStatus.classList.add('bg-warning');
    };

    // Aperçu en temps réel
    const nameInput = document.getElementById('name');
    const descInput = document.getElementById('description');
    const priceInput = document.getElementById('price');
    const previewTitle = document.getElementById('previewTitle');
    const previewDesc = document.getElementById('previewDesc');
    const previewPrice = document.getElementById('previewPrice');
    const nameCounter = document.getElementById('nameCounter');
    const descCounter = document.getElementById('descCounter');
    const titleStatus = document.getElementById('titleStatus');
    const descStatus = document.getElementById('descStatus');
    const priceStatus = document.getElementById('priceStatus');

    nameInput.addEventListener('input', function() {
        const value = this.value;
        previewTitle.textContent = value || 'Titre de votre plan';
        nameCounter.textContent = value.length;
        
        if (value.length >= 10) {
            titleStatus.textContent = 'Excellent';
            titleStatus.classList.remove('bg-warning');
            titleStatus.classList.add('bg-success');
        } else if (value.length > 0) {
            titleStatus.textContent = 'Trop court';
            titleStatus.classList.remove('bg-success');
            titleStatus.classList.add('bg-warning');
        } else {
            titleStatus.textContent = 'Non rempli';
            titleStatus.classList.remove('bg-success', 'bg-warning');
            titleStatus.classList.add('bg-secondary');
        }
    });

    descInput.addEventListener('input', function() {
        const value = this.value;
        previewDesc.textContent = value.substring(0, 100) + (value.length > 100 ? '...' : '') || 'Description de votre plan...';
        descCounter.textContent = value.length;
        
        if (value.length >= 50) {
            descStatus.textContent = 'Excellent';
            descStatus.classList.remove('bg-warning');
            descStatus.classList.add('bg-success');
        } else if (value.length > 0) {
            descStatus.textContent = 'Trop court';
            descStatus.classList.remove('bg-success');
            descStatus.classList.add('bg-warning');
        } else {
            descStatus.textContent = 'Non rempli';
            descStatus.classList.remove('bg-success', 'bg-warning');
            descStatus.classList.add('bg-secondary');
        }
    });

    priceInput.addEventListener('input', function() {
        const value = parseFloat(this.value) || 0;
        previewPrice.textContent = value.toLocaleString('fr-FR') + ' FCFA';
        
        if (value > 0) {
            priceStatus.textContent = 'Défini';
            priceStatus.classList.remove('bg-warning');
            priceStatus.classList.add('bg-success');
        } else {
            priceStatus.textContent = 'Non rempli';
            priceStatus.classList.remove('bg-success');
            priceStatus.classList.add('bg-warning');
        }
    });

    // Animation du bouton de soumission
    const form = document.getElementById('createPlanForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function() {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Publication en cours...';
        submitBtn.disabled = true;
    });

    // Initialiser les compteurs avec les valeurs existantes
    if (nameInput.value) {
        nameInput.dispatchEvent(new Event('input'));
    }
    if (descInput.value) {
        descInput.dispatchEvent(new Event('input'));
    }
    if (priceInput.value) {
        priceInput.dispatchEvent(new Event('input'));
    }
});
</script>
@endsection
