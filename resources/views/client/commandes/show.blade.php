@extends('layouts.app')
@section('title', 'Détail commande')

@section('content')
<div class="d-flex align-items-center mb-4 gap-3">
    <a href="{{ route('commandes.index') }}" class="btn btn-outline-dark-custom">
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

    <div class="col-md-4">
        <div class="card">
            <div class="card-header fw-bold" style="background-color:#1A1A1A;color:#fff;">
                📋 Informations
            </div>
            <div class="card-body">
                <p class="mb-1">
                    <strong>Date :</strong>
                    {{ $commande->created_at->format('d/m/Y à H:i') }}
                </p>
                <p class="mb-1">
                    <strong>Total :</strong>
                    <span class="price-amber fw-bold">
                        {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                    </span>
                </p>
                @if($commande->paiement)
                <p class="mb-0">
                    <strong>Payé le :</strong>
                    {{ $commande->paiement->date_paiement->format('d/m/Y') }}
                </p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header fw-bold" style="background-color:#1A1A1A;color:#fff;">
                🍔 Burgers commandés
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
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
                        <tr style="background-color:#1A1A1A; color:#fff;">
                            <td colspan="3" class="p-3 text-end fw-bold">TOTAL</td>
                            <td class="p-3 fw-bold" style="color:#D4530A;">
                                {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
