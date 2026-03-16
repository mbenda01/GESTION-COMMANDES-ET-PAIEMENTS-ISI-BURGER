@extends('layouts.app')
@section('title', 'Catalogue')

@section('content')
<h2 class="fw-bold mb-4">🍔 Nos Burgers</h2>

{{-- Filtres --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('catalogue.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold">Rechercher</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="Nom du burger...">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Prix min (FCFA)</label>
                <input type="number" name="prix_min" value="{{ request('prix_min') }}"
                       class="form-control" placeholder="0" min="0">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Prix max (FCFA)</label>
                <input type="number" name="prix_max" value="{{ request('prix_max') }}"
                       class="form-control" placeholder="10000" min="0">
            </div>
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-amber w-100">Filtrer</button>
                    <a href="{{ route('catalogue.index') }}" class="btn btn-outline-dark-custom">✕</a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Grille produits --}}
<div class="row row-cols-1 row-cols-md-4 g-4">
    @forelse($produits as $produit)
    <div class="col">
        <div class="card h-100">
            <img src="{{ $produit->image ?? 'https://via.placeholder.com/400x250?text=Burger' }}"
                 class="card-img-top"
                 alt="{{ $produit->nom }}"
                 style="height: 180px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-bold">{{ $produit->nom }}</h5>
                <p class="card-text text-muted-custom flex-grow-1" style="font-size:13px;">
                    {{ Str::limit($produit->description, 60) }}
                </p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="price-amber fs-5">
                        {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                    </span>
                    <span class="badge bg-success" style="font-size:11px;">
                        {{ $produit->stock }} en stock
                    </span>
                </div>
                <a href="{{ route('catalogue.show', $produit) }}"
                   class="btn btn-amber mt-3">
                    Voir le détail
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted py-5">
        Aucun burger disponible pour le moment.
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $produits->links() }}</div>
@endsection
