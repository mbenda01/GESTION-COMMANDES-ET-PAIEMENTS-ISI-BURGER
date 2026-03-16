@extends('layouts.app')
@section('title', 'Gestion des produits')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0" style="color: #1A1A1A;">🍔 Gestion des produits</h2>
    <a href="{{ route('admin.produits.create') }}" class="btn btn-amber">
        + Ajouter un burger
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead style="background-color: #1A1A1A; color: #FFFFFF;">
                <tr>
                    <th class="p-3">Image</th>
                    <th class="p-3">Nom</th>
                    <th class="p-3">Prix</th>
                    <th class="p-3">Stock</th>
                    <th class="p-3">Statut</th>
                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produits as $produit)
                <tr>
                    <td class="p-3">
                        @if($produit->image)
                            <img src="{{ $produit->image }}" alt="{{ $produit->nom }}"
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        @else
                            <div style="width:60px;height:60px;background:#F5F5F5;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                🍔
                            </div>
                        @endif
                    </td>
                    <td class="p-3 fw-bold align-middle">{{ $produit->nom }}</td>
                    <td class="p-3 align-middle price-amber fw-bold">
                        {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                    </td>
                    <td class="p-3 align-middle">
                        @if($produit->stock === 0)
                            <span class="badge bg-danger">Rupture</span>
                        @elseif($produit->stock <= 5)
                            <span class="badge bg-warning text-dark">{{ $produit->stock }} restants</span>
                        @else
                            <span class="badge bg-success">{{ $produit->stock }} en stock</span>
                        @endif
                    </td>
                    <td class="p-3 align-middle">
                        @if($produit->archive)
                            <span class="badge bg-secondary">Archivé</span>
                        @else
                            <span class="badge bg-success">Actif</span>
                        @endif
                    </td>
                    <td class="p-3 align-middle text-center">
                        <div class="d-flex gap-2 justify-content-center">

                            {{-- Modifier --}}
                            <a href="{{ route('admin.produits.edit', $produit) }}"
                               class="btn btn-sm btn-outline-dark-custom">
                                ✏️ Modifier
                            </a>

                            {{-- Archiver / Désarchiver --}}
                            <form method="POST"
                                  action="{{ route('admin.produits.archive', $produit) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="btn btn-sm {{ $produit->archive ? 'btn-outline-success' : 'btn-outline-warning' }}">
                                    {{ $produit->archive ? '♻️ Désarchiver' : '📦 Archiver' }}
                                </button>
                            </form>

                            {{-- Supprimer --}}
                            <form method="POST"
                                  action="{{ route('admin.produits.destroy', $produit) }}"
                                  onsubmit="return confirm('Supprimer ce burger ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    🗑️ Supprimer
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Aucun produit trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $produits->links() }}
</div>
@endsection
