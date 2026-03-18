@extends('layouts.app')

@section('title', 'Commande #' . str_pad($commande->id, 5, '0', STR_PAD_LEFT))

@section('content')

@push('styles')
<style>
    .admin-cmd-hero {
        background: linear-gradient(135deg, var(--blue-900) 0%, #0f1e4a 60%, var(--blue-800) 100%);
        border-radius: 20px;
        padding: 28px 36px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }
    .admin-cmd-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 40px 40px;
    }
    .admin-cmd-hero .hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .statut-hero-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 18px;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 800;
    }
    .sph-en_attente     { background: rgba(230,81,0,0.2);   color: #ffcc80; border: 1px solid rgba(230,81,0,0.3); }
    .sph-en_preparation { background: rgba(245,124,0,0.2);  color: #ffe082; border: 1px solid rgba(245,124,0,0.3); }
    .sph-prete          { background: rgba(22,163,74,0.2);  color: #86efac; border: 1px solid rgba(22,163,74,0.3); }
    .sph-payee          { background: rgba(46,125,50,0.2);  color: #a7f3d0; border: 1px solid rgba(46,125,50,0.3); }
    .sph-annulee        { background: rgba(220,38,38,0.2);  color: #fca5a5; border: 1px solid rgba(220,38,38,0.3); }

    .admin-cmd-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }

    .info-card {
        background: white;
        border-radius: 18px;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .info-card-header {
        padding: 15px 22px;
        background: linear-gradient(90deg, var(--blue-900), #0f1e4a);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .info-card-header h5 {
        margin: 0;
        font-size: 0.88rem;
        font-weight: 800;
        color: white;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .info-card-header h5 i { color: var(--yellow); }
    .info-card-body { padding: 20px 22px; }

    .table-admin {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .table-admin thead tr {
        background: var(--gray-50);
        border-bottom: 2px solid var(--gray-100);
    }
    .table-admin thead th {
        padding: 11px 18px;
        font-size: 0.7rem;
        font-weight: 800;
        color: var(--gray-400);
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }
    .table-admin tbody tr {
        border-bottom: 1px solid var(--gray-100);
        transition: background 0.15s;
    }
    .table-admin tbody tr:last-child { border-bottom: none; }
    .table-admin tbody tr:hover { background: var(--gray-50); }
    .table-admin tbody td {
        padding: 13px 18px;
        font-size: 0.875rem;
        vertical-align: middle;
    }
    .table-admin tfoot tr {
        background: linear-gradient(90deg, var(--blue-900), #0f1e4a);
    }
    .table-admin tfoot td {
        padding: 13px 18px;
        font-weight: 800;
        color: white;
    }

    .burger-img-sm {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid var(--gray-100);
        font-size: 0.875rem;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row-label {
        color: var(--gray-400);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.82rem;
    }
    .info-row-label i { color: var(--blue); }
    .info-row-value { font-weight: 700; color: var(--gray-900); text-align: right; }

    .statut-form-select {
        width: 100%;
        padding: 11px 14px;
        border: 2px solid var(--gray-200);
        border-radius: 11px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-900);
        background: white;
        outline: none;
        transition: all 0.25s;
        cursor: pointer;
        margin-bottom: 12px;
    }
    .statut-form-select:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
    }

    .paiement-card {
        background: linear-gradient(135deg, var(--blue-900), var(--blue-800));
        border-radius: 18px;
        padding: 20px 22px;
        color: white;
        margin-bottom: 20px;
    }
    .paiement-card-title {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: rgba(255,255,255,0.55);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .paiement-card-title i { color: var(--yellow); }

    .montant-input {
        width: 100%;
        padding: 12px 14px;
        background: rgba(255,255,255,0.1);
        border: 2px solid rgba(255,255,255,0.2);
        border-radius: 11px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1rem;
        font-weight: 800;
        color: white;
        outline: none;
        transition: all 0.25s;
        margin-bottom: 12px;
    }
    .montant-input::placeholder { color: rgba(255,255,255,0.4); }
    .montant-input:focus {
        border-color: var(--yellow);
        box-shadow: 0 0 0 3px rgba(255,193,7,0.2);
    }

    .btn-payer {
        width: 100%;
        padding: 13px;
        background: linear-gradient(135deg, var(--yellow), var(--gold));
        color: var(--blue-900);
        border: none;
        border-radius: 11px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.25s;
        box-shadow: 0 4px 14px rgba(255,193,7,0.4);
    }
    .btn-payer:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(255,193,7,0.5);
    }

    .paye-info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 7px 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .paye-info-row:last-child { border-bottom: none; }
    .paye-label { font-size: 0.78rem; color: rgba(255,255,255,0.55); font-weight: 500; }
    .paye-value { font-size: 0.88rem; font-weight: 700; color: white; }
    .paye-total { color: var(--yellow); font-size: 1.1rem; font-weight: 800; }

    @media (max-width: 992px) {
        .admin-cmd-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

<div class="admin-cmd-hero">
    <div class="hero-content">
        <div>
            <div style="display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,var(--yellow),var(--gold));color:var(--blue-900);font-size:0.72rem;font-weight:800;padding:4px 14px;border-radius:999px;text-transform:uppercase;letter-spacing:0.8px;margin-bottom:10px;">
                <i class="bi bi-receipt-cutoff"></i> Détail commande
            </div>
            <h1 style="font-size:1.8rem;font-weight:800;color:white;letter-spacing:-0.5px;margin:0;">
                Commande <span style="color:var(--yellow);">#{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}</span>
            </h1>
        </div>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span class="statut-hero-pill sph-{{ $commande->statut }}">
                @switch($commande->statut)
                    @case('en_attente')     <i class="bi bi-clock-fill"></i> En attente @break
                    @case('en_preparation') <i class="bi bi-fire"></i> En préparation @break
                    @case('prete')          <i class="bi bi-check-circle-fill"></i> Prête @break
                    @case('payee')          <i class="bi bi-patch-check-fill"></i> Payée @break
                    @case('annulee')        <i class="bi bi-x-circle-fill"></i> Annulée @break
                @endswitch
            </span>
            <a href="{{ route('admin.commandes.index') }}"
               class="btn-isi-outline"
               style="border-color:rgba(255,255,255,0.3);color:white;">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</div>

<div class="admin-cmd-grid">

    <div>

        {{-- Produits --}}
        <div class="info-card">
            <div class="info-card-header">
                <h5><i class="bi bi-egg-fried"></i> Burgers commandés</h5>
            </div>
            <table class="table-admin">
                <thead>
                    <tr>
                        <th>Burger</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commande->produits as $produit)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img
                                    src="{{ $produit->image ?? 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=100' }}"
                                    alt="{{ $produit->nom }}"
                                    class="burger-img-sm">
                                <span style="font-weight:800;color:var(--blue-900);">
                                    {{ $produit->nom }}
                                </span>
                            </div>
                        </td>
                        <td style="color:var(--gray-600);font-weight:600;">
                            {{ number_format($produit->pivot->prix_unitaire, 0, ',', ' ') }} FCFA
                        </td>
                        <td>
                            <span style="background:var(--blue-light);color:var(--blue);font-weight:800;font-size:0.82rem;padding:3px 10px;border-radius:6px;">
                                × {{ $produit->pivot->quantite }}
                            </span>
                        </td>
                        <td style="font-weight:800;color:var(--blue-900);">
                            {{ number_format($produit->pivot->prix_unitaire * $produit->pivot->quantite, 0, ',', ' ') }} FCFA
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right;color:rgba(255,255,255,0.7);">TOTAL</td>
                        <td style="color:var(--yellow);font-size:1.05rem;">
                            {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Infos client --}}
        <div class="info-card">
            <div class="info-card-header">
                <h5><i class="bi bi-person-fill"></i> Informations client</h5>
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-row-label"><i class="bi bi-person-badge-fill"></i> Nom complet</span>
                    <span class="info-row-value">{{ $commande->nom_complet_client }}</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label"><i class="bi bi-envelope-fill"></i> Email</span>
                    <span class="info-row-value">{{ $commande->email_client_final }}</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label"><i class="bi bi-geo-alt-fill"></i> Adresse livraison</span>
                    <span class="info-row-value">{{ $commande->adresse_livraison ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-row-label"><i class="bi bi-calendar3"></i> Date commande</span>
                    <span class="info-row-value">{{ $commande->created_at->format('d/m/Y à H:i') }}</span>
                </div>
            </div>
        </div>

    </div>

    <div>

        {{-- Changer statut --}}
        @if(!in_array($commande->statut, ['payee', 'annulee']))
        <div class="info-card" style="margin-bottom:20px;">
            <div class="info-card-header">
                <h5><i class="bi bi-arrow-repeat"></i> Changer le statut</h5>
            </div>
            <div class="info-card-body">
                <form method="POST"
                      action="{{ route('admin.commandes.updateStatut', $commande) }}">
                    @csrf
                    @method('PATCH')
                    <select name="statut" class="statut-form-select">
                        @foreach(['en_attente'=>'En attente','en_preparation'=>'En préparation','prete'=>'Prête'] as $val => $label)
                            <option value="{{ $val }}" {{ $commande->statut === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-isi-primary w-100 justify-content-center">
                        <i class="bi bi-check-lg"></i> Mettre à jour le statut
                    </button>
                </form>
                @if($commande->statut === 'prete')
                    <div style="background:var(--success-light);color:var(--success);border-radius:10px;padding:10px 14px;font-size:0.8rem;font-weight:700;margin-top:12px;display:flex;align-items:center;gap:7px;">
                        <i class="bi bi-envelope-fill"></i>
                        Passage à "Prête" → email + facture PDF envoyés au client
                    </div>
                @endif
            </div>
        </div>
        @else
        <div class="info-card" style="margin-bottom:20px;">
            <div class="info-card-header">
                <h5><i class="bi bi-lock-fill"></i> Statut final</h5>
            </div>
            <div class="info-card-body">
                <p style="color:var(--gray-400);font-size:0.875rem;margin:0;">
                    Cette commande est <strong>{{ $commande->statut === 'payee' ? 'payée' : 'annulée' }}</strong>.
                    Aucune modification possible.
                </p>
            </div>
        </div>
        @endif

        {{-- Paiement --}}
        <div class="paiement-card">
            <div class="paiement-card-title">
                <i class="bi bi-cash-coin"></i> Paiement
            </div>

            @if($commande->paiement)
                <div class="paye-info-row">
                    <span class="paye-label">Montant payé</span>
                    <span class="paye-value paye-total">
                        {{ number_format($commande->paiement->montant, 0, ',', ' ') }} FCFA
                    </span>
                </div>
                <div class="paye-info-row">
                    <span class="paye-label">Mode</span>
                    <span class="paye-value">Espèces</span>
                </div>
                <div class="paye-info-row">
                    <span class="paye-label">Date</span>
                    <span class="paye-value">
                        {{ $commande->paiement->date_paiement->format('d/m/Y à H:i') }}
                    </span>
                </div>

            @elseif($commande->estPayable())
                <form method="POST"
                      action="{{ route('admin.commandes.paiement', $commande) }}">
                    @csrf
                    <input type="hidden" name="mode" value="especes">
                    <div style="font-size:0.78rem;color:rgba(255,255,255,0.55);margin-bottom:8px;font-weight:600;">
                        Montant reçu (FCFA)
                    </div>
                    <input
                        type="number"
                        name="montant"
                        value="{{ $commande->montant_total }}"
                        class="montant-input"
                        min="0"
                        required>
                    <button type="submit" class="btn-payer">
                        <i class="bi bi-cash-coin"></i> Enregistrer le paiement
                    </button>
                </form>

            @else
                <p style="color:rgba(255,255,255,0.45);font-size:0.82rem;margin:0;">
                    Le paiement sera disponible quand la commande est <strong style="color:rgba(255,255,255,0.7);">Prête</strong>.
                </p>
            @endif
        </div>

        {{-- Annuler --}}
        @if($commande->estAnnulable())
        <form method="POST"
              action="{{ route('admin.commandes.destroy', $commande) }}"
              onsubmit="return confirm('Annuler définitivement cette commande ?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="btn-isi-outline w-100 justify-content-center"
                    style="border-color:var(--danger);color:var(--danger);">
                <i class="bi bi-x-circle-fill"></i> Annuler la commande
            </button>
        </form>
        @endif

    </div>
</div>

@endsection
