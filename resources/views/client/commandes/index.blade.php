@extends('layouts.app')
@section('title', 'Mes commandes')

@section('content')
<h2 class="fw-bold mb-4">📦 Mes commandes</h2>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead style="background-color: #1A1A1A; color: #FFFFFF;">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Burgers</th>
                    <th class="p-3">Montant</th>
                    <th class="p-3">Statut</th>
                    <th class="p-3 text-center">Détail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commandes as $commande)
                <tr>
                    <td class="p-3 align-middle fw-bold">
                        #{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="p-3 align-middle text-muted-custom">
                        {{ $commande->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="p-3 align-middle">
                        {{ $commande->produits->count() }} burger(s)
                    </td>
                    <td class="p-3 align-middle price-amber fw-bold">
                        {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                    </td>
                    <td class="p-3 align-middle">
                        <span class="badge badge-{{ $commande->statut }}">
                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                        </span>
                    </td>
                    <td class="p-3 align-middle text-center">
                        <a href="{{ route('commandes.show', $commande) }}"
                           class="btn btn-sm btn-amber">
                            👁️ Voir
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        Vous n'avez pas encore de commande.
                        <br>
                        <a href="{{ route('catalogue.index') }}" class="btn btn-amber mt-3">
                            🍔 Commander maintenant
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $commandes->links() }}</div>
@endsection
