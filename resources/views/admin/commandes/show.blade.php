@extends('layouts.app')
@section('title', 'Détail commande')

@section('content')
<div class="d-flex align-items-center mb-4 gap-3">
    <a href="{{ route('admin.commandes.index') }}" class="btn btn-outline-dark-custom">
        ← Retour
    </a>
    <h2 class="fw-bold mb-0">
        Commande #{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}
    </h2>
    <span class="badge badge-{{ $commande->statut }} fs-6">
        {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
    </span>
</div>

<div class="row g-4">

    {{-- Infos client --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header fw-bold" style="background-color:#1A1A1A; color:#fff;">
                👤 Client
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Nom :</strong> {{ $commande->user->name }}</p>
                <p class="mb-1"><strong>Email :</strong> {{ $commande->user->email }}</p>
                <p class="mb-0"><strong>Date :</strong> {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- Changer statut --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header fw-bold" style="background-color:#1A1A1A; color:#fff;">
                🔄 Changer le statut
            </div>
            <div class="card-body">
                @if(!in_array($commande->statut, ['payee', 'annulee']))
                <form method="POST"
                      action="{{ route('admin.commandes.updateStatut', $commande) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <select name="statut" class="form-select">
                            @foreach(['en_attente','en_preparation','prete','payee','annulee'] as $s)
                                <option value="{{ $s }}"
                                    {{ $commande->statut === $s ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $s)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-amber">
                            ✅ Mettre à jour
                        </button>
                    </div>
                </form>
                @else
                    <p class="text-muted mb-0">
                        Statut final — aucune modification possible.
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- Paiement --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header fw-bold" style="background-color:#1A1A1A; color:#fff;">
                💵 Paiement
            </div>
            <div class="card-body">
                @if($commande->paiement)
                    <p class="mb-1">
                        <strong>Montant :</strong>
                        <span class="price-amber">
                            {{ number_format($commande->paiement->montant, 0, ',', ' ') }} FCFA
                        </span>
                    </p>
                    <p class="mb-1"><strong>Mode :</strong> Espèces</p>
                    <p class="mb-0">
                        <strong>Date :</strong>
                        {{ $commande->paiement->date_paiement->format('d/m/Y H:i') }}
                    </p>
                @elseif($commande->statut === 'prete')
                    <form method="POST"
                          action="{{ route('admin.commandes.paiement', $commande) }}">
                        @csrf
                        <input type="hidden" name="mode" value="especes">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Montant reçu (FCFA)</label>
                            <input type="number" name="montant"
                                   value="{{ $commande->montant_total }}"
                                   class="form-control" min="0" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                💵 Enregistrer le paiement
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-muted mb-0">
                        Le paiement sera disponible quand la commande est prête.
                    </p>
                @endif
            </div>
        </div>
    </div>

</div>

{{-- Produits commandés --}}
<div class="card mt-4">
    <div class="card-header fw-bold" style="background-color:#1A1A1A; color:#fff;">
        🍔 Produits commandés
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th class="p-3">Burger</th>
                    <th class="p-3">Prix unitaire</th>
                    <th class="p-3">Quantité</th>
                    <th class="p-3">Sous-total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commande->produits as $produit)
                <tr>
                    <td class="p-3 align-middle fw-bold">{{ $produit->nom }}</td>
                    <td class="p-3 align-middle">
                        {{ number_format($produit->pivot->prix_unitaire, 0, ',', ' ') }} FCFA
                    </td>
                    <td class="p-3 align-middle">{{ $produit->pivot->quantite }}</td>
                    <td class="p-3 align-middle price-amber fw-bold">
                        {{ number_format($produit->pivot->prix_unitaire * $produit->pivot->quantite, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #1A1A1A; color: #fff;">
                    <td colspan="3" class="p-3 fw-bold text-end">TOTAL</td>
                    <td class="p-3 fw-bold" style="color: #D4530A; font-size: 1.1rem;">
                        {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
