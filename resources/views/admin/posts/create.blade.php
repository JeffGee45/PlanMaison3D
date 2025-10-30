@extends('layouts.admin')

@section('title', 'Nouvel Article')

@section('content')
<h1 class="h2">Nouvel Article</h1>

<div class="card shadow-sm mt-4">
    <div class="card-body">
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.posts._form')
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Créer l'article</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
