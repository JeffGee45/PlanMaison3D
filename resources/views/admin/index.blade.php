@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Tableau de bord d'administration</h1>
    
    <div class="row">
        <!-- Statistiques rapides -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Articles du blog</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Post::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-journal-text fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('admin.posts.index') }}" class="text-primary text-decoration-none">
                        Voir les articles <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Catégories</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Category::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tags</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Tag::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-tag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Utilisateurs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Derniers articles -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Derniers articles</h6>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Nouvel article
            </a>
        </div>
        <div class="card-body">
            @if(\App\Models\Post::count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Auteur</th>
                                <th>Date de publication</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Post::latest()->take(5)->get() as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                                            {{ $post->status === 'published' ? 'Publié' : 'Brouillon' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-info text-white">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-3">
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-outline-primary">
                        Voir tous les articles <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            @else
                <div class="alert alert-info">
                    Aucun article n'a été publié pour le moment.
                    <a href="{{ route('admin.posts.create') }}" class="alert-link">Créer votre premier article</a>.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
