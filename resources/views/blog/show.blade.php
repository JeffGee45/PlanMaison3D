@extends('layouts.website-layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-4">
                    <h1 class="card-title display-5 fw-bold mb-3">{{ $post->title }}</h1>
                    <div class="d-flex align-items-center mb-4 text-muted">
                        <small>Publié le {{ $post->created_at->format('d F Y') }}</small>
                        <span class="mx-2">•</span>
                        <small>Par {{ $post->user->name }}</small>
                        <span class="mx-2">•</span>
                        <small>Catégorie : <a href="#" class="text-muted">{{ $post->category->name }}</a></small>
                    </div>

                    <div class="blog-content fs-5">
                        {!! $post->content !!}
                    </div>
                </div>
                <div class="card-footer bg-light p-3">
                    @if($post->tags->count() > 0)
                        <strong>Tags :</strong>
                        @foreach($post->tags as $tag)
                            <a href="#" class="badge bg-secondary text-decoration-none">{{ $tag->name }}</a>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="mt-5">
                <a href="{{ route('blog.index') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Retour au blog</a>
            </div>
        </div>
    </div>
</div>
@endsection
