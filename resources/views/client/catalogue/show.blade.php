@extends('layouts.app')
@section('title', $produit->nom)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <a href="{{ route('catalogue.index') }}" class="btn btn-outline-dark-custom mb-4">
            ← Retour au catalogue
        </a>

        <div class="card">
            <img src="{{ $produit->image ?? 'https://via.placeholder.com/800x350?text=Burger' }}"
                 class="card-img-top"
                 alt="{{ $produit->nom }}"
                 style="height: 300px; object-fit: cover;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <h2 class="fw-bold">{{ $produit->nom }}</h2>
                    <span class="price-amber fs-3 fw-bold">
                        {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                    </span>
                </div>
                <p class="text-muted-custom mt-2">{{ $produit->description }}</p>
                <p class="mt-2">
                    <span class="badge bg-success">{{ $produit->stock }} en stock</span>
                </p>

                <div class="d-grid mt-4">
                    <a href="{{ route('commandes.create') }}?produit={{ $produit->id }}"
                       class="btn btn-amber btn-lg">
                        🛒 Commander ce burger
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
