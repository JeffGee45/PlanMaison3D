@extends('layouts.admin')

@section('title', 'Modifier l\'article')

@section('content')
<h1 class="h2">Modifier l'article</h1>

<div class="card shadow-sm mt-4">
    <div class="card-body">
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.posts._form')
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
