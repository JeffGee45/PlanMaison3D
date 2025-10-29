<div class="col mb-4">
    <div class="card product-card">
        <!-- Product image-->
        <div class="product-image-wrapper">
            @if($article->image)
                <img src="{{Storage::url($article->image)}}" alt="{{$article->name}}" class="card-img-top">
            @else
                <img src="https://ui-avatars.com/api/?background=667eea&color=fff&size=400&name={{urlencode($article->name)}}" alt="{{$article->name}}" class="card-img-top">
            @endif
            <span class="product-badge">Nouveau</span>
        </div>
      
        <!-- Product details-->
        <div class="card-body">
            <div class="text-center">
                <!-- Product name-->
                <h5>{{$article->name}}</h5>
                
                <!-- Product reviews-->
                <div class="product-stars mb-2">
                    <i class="bi-star-fill"></i>
                    <i class="bi-star-fill"></i>
                    <i class="bi-star-fill"></i>
                    <i class="bi-star-fill"></i>
                    <i class="bi-star-fill"></i>
                    <span class="text-muted ms-1">(5.0)</span>
                </div>

                <!-- Product description -->
                @if($article->description)
                <p class="text-muted small mb-3">{{ Str::limit($article->description, 80) }}</p>
                @endif
                
                <!-- Product price-->
                <div class="product-price">
                    {{number_format($article->price, 0, ',', ' ')}} <small>CFA</small>
                </div>

                <!-- Product features -->
                <div class="d-flex justify-content-center gap-3 mb-3 text-muted small">
                    <span><i class="bi bi-rulers me-1"></i>Plans 2D/3D</span>
                    <span><i class="bi bi-download me-1"></i>PDF</span>
                </div>
            </div>
        </div>
      
        @auth
        <div class="card-footer p-3 pt-0 border-top-0 bg-transparent">
            <div class="d-grid gap-2">
                <a class="btn btn-product" href="{{route('order.article',$article->id)}}">
                    <i class="bi bi-cart-plus me-2"></i>Acheter Maintenant
                </a>
                <button class="btn btn-outline-secondary btn-sm" type="button">
                    <i class="bi bi-eye me-1"></i>Aperçu
                </button>
            </div>
        </div>
        @else
        <div class="card-footer p-3 pt-0 border-top-0 bg-transparent">
            <div class="d-grid gap-2">
                <a class="btn btn-product" href="{{route('user.login')}}">
                    <i class="bi bi-lock me-2"></i>Connectez-vous pour acheter
                </a>
            </div>
        </div>
        @endauth
    </div>
</div>