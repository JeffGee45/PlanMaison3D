@extends('layouts.website-layout')
@section('content')

<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h2 class="text-center text-dark mt-5">ESPACE VENDEUR</h2>
        <div class="text-center mb-5 text-dark">Rejoindre en tant que vendeur</div>
        <div class="card my-5">

          @if (Session::get('success'))
          <div class="alert alert-success">{{Session::get('success')}}</div>
          @endif

          <form    class="card-body cardbody-color p-lg-5"
           method="POST"
            action=" {{ route ('vendors.handleRegister') }} ">
            
          @method('post') 
          @csrf

            <div class="text-center">
              <img src="https://imgs.search.brave.com/x-pEcp7Kw0Z6cqLf-bguU4ssnlBwLB3OYm9l0qbd4s0/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzAxLzQxLzQwLzc2/LzM2MF9GXzE0MTQw/NzY4M19BbU91QnRJ/SDU5enZ5aTFUOXQw/WnFaYU15WUwwWUdG/WS5qcGc" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                width="200px" alt="profile">
            </div>

            <div class="mb-3">
              <input type="text" class="form-control" id="name" name="name"
                placeholder="Nom du vendeur" value="{{ old('name') }}">

                @error ('name')
                 <div class="text-danger">{{ ($message) }}</div>
                @enderror
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" id="email" name="email"
                placeholder="Email@vendor.com" value="{{ old('email') }}" >
                @error ('email')
                 <div class="text-danger">{{ ($message) }}</div>
                @enderror
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" id="password" name="password"  placeholder="Mot de passe"
              value="{{ old('password') }}" >
              @error ('password')
                 <div class="text-danger">{{ ($message) }}</div>
                @enderror
            </div>
            <div class="text-center"><button type="submit" class="btn btn-color px-5 mb-5 w-100">Créer mon Compte</button></div>
            <div id="emailHelp" class="form-text text-center mb-5 text-dark">Déjà inscrit?<a href="{{ route('vendors.handleLogin')}}" class="text-dark fw-bold"> Connecter vous</a>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>


@endsection