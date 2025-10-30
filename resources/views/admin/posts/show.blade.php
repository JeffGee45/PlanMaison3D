@extends('layouts.admin')

@section('title', 'Détails de l\'article')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2">Détails de l'article</h1>
    <div>
        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline-primary me-2">
            <i class="bi bi-pencil-square"></i> Modifier
        </a>
        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-trash"></i> Supprimer
            </button>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="max-height: 400px; object-fit: cover;">
    @endif
    <div class="card-body">
        <h2 class="card-title">{{ $post->title }}</h2>
        <div class="d-flex align-items-center text-muted mb-3">
            <span>Publié le {{ $post->created_at->format('d/m/Y') }}</span>
            <span class="mx-2">•</span>
            <span>Par {{ $post->user->name }}</span>
            <span class="mx-2">•</span>
            <span class="badge bg-{{ $post->status == 'published' ? 'success' : 'warning' }}">
                {{ ucfirst($post->status) }}
            </span>
        </div>
        
        <div class="mb-4">
            <strong>Catégorie :</strong> {{ $post->category->name }}
        </div>
        
        @if($post->tags->count() > 0)
            <div class="mb-4">
                <strong>Tags :</strong>
                @foreach($post->tags as $tag)
                    <span class="badge bg-secondary">{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif
        
        <div class="blog-content">
            {!! $post->content !!}
        </div>
    </div>
    <div class="card-footer bg-white">
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>
@endsection
