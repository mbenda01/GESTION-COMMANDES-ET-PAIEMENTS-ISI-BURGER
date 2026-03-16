@extends('layouts.app')
@section('title', 'Gestion des commandes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">📋 Gestion des commandes</h2>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead style="background-color: #1A1A1A; color: #FFFFFF;">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Client</th>
                    <th class="p-3">Montant</th>
                    <th class="p-3">Statut</th>
                    <th class="p-3">Date</th>
                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commandes as $commande)
                <tr>
                    <td class="p-3 align-middle fw-bold">
                        #{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="p-3 align-middle">{{ $commande->user->name }}</td>
                    <td class="p-3 align-middle price-amber fw-bold">
                        {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                    </td>
                    <td class="p-3 align-middle">
                        <span class="badge badge-{{ $commande->statut }}">
                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                        </span>
                    </td>
                    <td class="p-3 align-middle text-muted-custom">
                        {{ $commande->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="p-3 align-middle text-center">
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('admin.commandes.show', $commande) }}"
                               class="btn btn-sm btn-amber">
                                👁️ Voir
                            </a>
                            @if($commande->statut !== 'annulee' && $commande->statut !== 'payee')
                            <form method="POST"
                                  action="{{ route('admin.commandes.destroy', $commande) }}"
                                  onsubmit="return confirm('Annuler cette commande ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    ✖ Annuler
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Aucune commande trouvée.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $commandes->links() }}
</div>
@endsection
