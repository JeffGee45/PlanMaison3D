@extends('layouts.website-layout')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">Notre Blog</h1>
        <p class="lead text-muted">Conseils, tendances et inspirations pour votre future maison.</p>
    </div>

    <div class="row g-4">
        @forelse($posts as $post)
            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                <div class="card h-100 shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><a href="{{ route('blog.show', $post->slug) }}" class="text-dark text-decoration-none stretched-link">{{ $post->title }}</a></h5>
                        <p class="card-text text-muted flex-grow-1">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <small class="text-muted">
                            Publié le {{ $post->created_at->format('d/m/Y') }}
                            @if($post->user)
                                par {{ $post->user->name }}
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-journal-x fs-1 text-muted"></i>
                    <h3 class="mt-3">Aucun article pour le moment</h3>
                    <p class="text-muted">Revenez bientôt pour découvrir nos dernières actualités.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $posts->links() }}
    </div>
</div>
@endsection
