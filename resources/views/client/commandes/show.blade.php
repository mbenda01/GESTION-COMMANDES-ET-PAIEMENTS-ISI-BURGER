@extends('layouts.app')

@section('title', 'Commande #' . str_pad($commande->id, 5, '0', STR_PAD_LEFT))

@section('content')

@push('styles')
<style>
    .detail-commande-hero {
        background: linear-gradient(135deg, var(--blue-900) 0%, #0f1e4a 60%, var(--blue-800) 100%);
        border-radius: 20px;
        padding: 28px 36px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }
    .detail-commande-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 40px 40px;
    }
    .detail-commande-hero .hero-content {
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
    .statut-en_attente     { background: rgba(230,81,0,0.2);   color: #ffcc80; border: 1px solid rgba(230,81,0,0.3); }
    .statut-en_preparation { background: rgba(245,124,0,0.2);  color: #ffe082; border: 1px solid rgba(245,124,0,0.3); }
    .statut-prete          { background: rgba(22,163,74,0.2);  color: #86efac; border: 1px solid rgba(22,163,74,0.3); }
    .statut-payee          { background: rgba(46,125,50,0.2);  color: #a7f3d0; border: 1px solid rgba(46,125,50,0.3); }
    .statut-annulee        { background: rgba(220,38,38,0.2);  color: #fca5a5; border: 1px solid rgba(220,38,38,0.3); }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }

    .detail-block {
        background: white;
        border-radius: 18px;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .detail-block-header {
        padding: 16px 22px;
        background: linear-gradient(90deg, var(--blue-900), #0f1e4a);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .detail-block-header h5 {
        margin: 0;
        font-size: 0.88rem;
        font-weight: 800;
        color: white;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-block-header h5 i { color: var(--yellow); }

    .table-commande {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .table-commande thead tr {
        background: var(--gray-50);
        border-bottom: 2px solid var(--gray-100);
    }

    .table-commande thead th {
        padding: 12px 20px;
        font-size: 0.72rem;
        font-weight: 800;
        color: var(--gray-400);
        text-transform: uppercase;
        letter-spacing: 0.6px;
        text-align: left;
    }

    .table-commande tbody tr {
        border-bottom: 1px solid var(--gray-100);
        transition: background 0.15s;
    }

    .table-commande tbody tr:last-child { border-bottom: none; }
    .table-commande tbody tr:hover { background: var(--gray-50); }

    .table-commande tbody td {
        padding: 14px 20px;
        font-size: 0.875rem;
        vertical-align: middle;
    }

    .table-commande tfoot tr {
        background: linear-gradient(90deg, var(--blue-900), #0f1e4a);
    }

    .table-commande tfoot td {
        padding: 14px 20px;
        font-size: 0.9rem;
        font-weight: 800;
        color: white;
    }

    .burger-name-cell {
        font-weight: 800;
        color: var(--blue-900);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .burger-img-mini {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 22px;
        border-bottom: 1px solid var(--gray-100);
    }

    .info-row:last-child { border-bottom: none; }

    .info-label {
        font-size: 0.8rem;
        color: var(--gray-400);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .info-label i { color: var(--blue); }

    .info-value {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--gray-900);
        text-align: right;
    }

    .total-price-big {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--blue-900);
    }

    .validation-block {
        background: white;
        border-radius: 18px;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .validation-header {
        padding: 16px 22px;
        background: linear-gradient(135deg, var(--yellow), var(--gold));
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .validation-header h5 {
        margin: 0;
        font-size: 0.88rem;
        font-weight: 800;
        color: var(--blue-900);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .validation-body { padding: 20px 22px; }

    .prete-alert {
        background: var(--success-light);
        color: var(--success);
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 0.875rem;
        font-weight: 700;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
        border: 1px solid rgba(22,163,74,0.2);
    }

    .waiting-alert {
        background: #fff8e1;
        color: #f57c00;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 0.875rem;
        font-weight: 700;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
        border: 1px solid rgba(245,124,0,0.2);
    }

    .paid-alert {
        background: #e8f5e9;
        color: #2e7d32;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 0.875rem;
        font-weight: 700;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
        border: 1px solid rgba(46,125,50,0.2);
    }

    .cancelled-alert {
        background: var(--danger-light);
        color: var(--danger);
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 0.875rem;
        font-weight: 700;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
        border: 1px solid rgba(220,38,38,0.2);
    }

    .timeline {
        display: flex;
        flex-direction: column;
        gap: 0;
        margin-top: 4px;
    }

    .timeline-step {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding-bottom: 16px;
        position: relative;
    }

    .timeline-step:last-child { padding-bottom: 0; }

    .timeline-step::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 30px;
        bottom: 0;
        width: 2px;
        background: var(--gray-100);
    }

    .timeline-step:last-child::before { display: none; }

    .timeline-dot {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .timeline-dot.done    { background: var(--success-light); color: var(--success); }
    .timeline-dot.active  { background: linear-gradient(135deg, var(--yellow), var(--gold)); color: var(--blue-900); }
    .timeline-dot.pending { background: var(--gray-100); color: var(--gray-400); }

    .timeline-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--gray-700);
        display: block;
        padding-top: 4px;
    }

    .timeline-label.done    { color: var(--success); }
    .timeline-label.active  { color: var(--gold); }
    .timeline-label.pending { color: var(--gray-400); }

    @media (max-width: 992px) {
        .detail-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

{{-- ── HERO ── --}}
<div class="detail-commande-hero">
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
            <span class="statut-hero-pill statut-{{ $commande->statut }}">
                @switch($commande->statut)
                    @case('en_attente')     <i class="bi bi-clock-fill"></i> En attente @break
                    @case('en_preparation') <i class="bi bi-fire"></i> En préparation @break
                    @case('prete')          <i class="bi bi-check-circle-fill"></i> Prête @break
                    @case('payee')          <i class="bi bi-patch-check-fill"></i> Payée @break
                    @case('annulee')        <i class="bi bi-x-circle-fill"></i> Annulée @break
                @endswitch
            </span>
            <a href="{{ route('commandes.index') }}" class="btn-isi-outline"
               style="border-color:rgba(255,255,255,0.3);color:white;">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</div>

<div class="detail-grid">

    {{-- ── COLONNE GAUCHE ── --}}
    <div>

        {{-- Produits commandés --}}
        <div class="detail-block">
            <div class="detail-block-header">
                <h5><i class="bi bi-egg-fried"></i> Burgers commandés</h5>
            </div>
            <table class="table-commande">
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
                            <div class="burger-name-cell">
                                <img
                                    src="{{ $produit->image ?? 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=100' }}"
                                    alt="{{ $produit->nom }}"
                                    class="burger-img-mini">
                                {{ $produit->nom }}
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
                        <td colspan="3" style="text-align:right;">
                            <span style="color:rgba(255,255,255,0.7);font-weight:700;">TOTAL</span>
                        </td>
                        <td>
                            <span style="color:var(--yellow);font-size:1.1rem;">
                                {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                            </span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Infos client --}}
        <div class="detail-block">
            <div class="detail-block-header">
                <h5><i class="bi bi-person-fill"></i> Informations client</h5>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="bi bi-person-badge-fill"></i> Nom complet</span>
                <span class="info-value">{{ $commande->nom_complet_client }}</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="bi bi-envelope-fill"></i> Email</span>
                <span class="info-value">{{ $commande->email_client_final }}</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="bi bi-geo-alt-fill"></i> Adresse livraison</span>
                <span class="info-value">{{ $commande->adresse_livraison ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="bi bi-calendar3"></i> Date commande</span>
                <span class="info-value">{{ $commande->created_at->format('d/m/Y à H:i') }}</span>
            </div>
            @if($commande->paiement)
            <div class="info-row">
                <span class="info-label"><i class="bi bi-cash-coin"></i> Payé le</span>
                <span class="info-value" style="color:var(--success);">
                    {{ $commande->paiement->date_paiement->format('d/m/Y à H:i') }}
                </span>
            </div>
            @endif
        </div>

    </div>

    {{-- ── COLONNE DROITE ── --}}
    <div>

        {{-- Validation / Statut --}}
        <div class="validation-block mb-4">
            <div class="validation-header">
                <h5><i class="bi bi-patch-check-fill"></i> Statut & Validation</h5>
            </div>
            <div class="validation-body">

                @switch($commande->statut)
                    @case('en_attente')
                        <div class="waiting-alert">
                            <i class="bi bi-clock-fill fs-5 flex-shrink-0"></i>
                            <div>
                                <div>Votre commande est en attente de traitement.</div>
                                <div style="font-size:0.78rem;opacity:0.8;margin-top:4px;">
                                    Vous recevrez un email dès qu'elle sera prise en charge.
                                </div>
                            </div>
                        </div>
                        @break

                    @case('en_preparation')
                        <div class="waiting-alert">
                            <i class="bi bi-fire fs-5 flex-shrink-0"></i>
                            <div>
                                <div>Votre commande est en cours de préparation !</div>
                                <div style="font-size:0.78rem;opacity:0.8;margin-top:4px;">
                                    Nos équipes préparent vos burgers avec soin.
                                </div>
                            </div>
                        </div>
                        @break

                    @case('prete')
                        <div class="prete-alert">
                            <i class="bi bi-check-circle-fill fs-5 flex-shrink-0"></i>
                            <div>
                                <div>Votre commande est prête !</div>
                                <div style="font-size:0.78rem;opacity:0.8;margin-top:4px;">
                                    Un email avec votre facture PDF vous a été envoyé.
                                </div>
                            </div>
                        </div>
                        @break

                    @case('payee')
                        <div class="paid-alert">
                            <i class="bi bi-patch-check-fill fs-5 flex-shrink-0"></i>
                            <div>
                                <div>Commande payée et finalisée !</div>
                                <div style="font-size:0.78rem;opacity:0.8;margin-top:4px;">
                                    Merci de votre confiance chez ISI BURGER.
                                </div>
                            </div>
                        </div>
                        @break

                    @case('annulee')
                        <div class="cancelled-alert">
                            <i class="bi bi-x-circle-fill fs-5 flex-shrink-0"></i>
                            <div>
                                <div>Cette commande a été annulée.</div>
                                <div style="font-size:0.78rem;opacity:0.8;margin-top:4px;">
                                    Contactez-nous pour plus d'informations.
                                </div>
                            </div>
                        </div>
                        @break
                @endswitch

                {{-- Timeline --}}
                <div class="timeline">
                    @php
                        $statuts = ['en_attente','en_preparation','prete','payee'];
                        $indexActuel = array_search($commande->statut, $statuts);
                    @endphp

                    @foreach([
                        'en_attente'     => ['label' => 'En attente',      'icon' => 'bi-clock-fill'],
                        'en_preparation' => ['label' => 'En préparation',  'icon' => 'bi-fire'],
                        'prete'          => ['label' => 'Prête',           'icon' => 'bi-check-circle-fill'],
                        'payee'          => ['label' => 'Payée',           'icon' => 'bi-patch-check-fill'],
                    ] as $key => $step)
                        @php
                            $idx = array_search($key, $statuts);
                            $state = ($indexActuel !== false && $idx < $indexActuel) ? 'done'
                                   : (($commande->statut === $key) ? 'active' : 'pending');
                            if($commande->statut === 'annulee') $state = 'pending';
                        @endphp
                        <div class="timeline-step">
                            <div class="timeline-dot {{ $state }}">
                                <i class="bi {{ $step['icon'] }}"></i>
                            </div>
                            <span class="timeline-label {{ $state }}">{{ $step['label'] }}</span>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        {{-- Récapitulatif montant --}}
        <div class="detail-block">
            <div class="detail-block-header">
                <h5><i class="bi bi-receipt"></i> Récapitulatif</h5>
            </div>
            <div class="info-row">
                <span class="info-label">Nb de burgers</span>
                <span class="info-value">{{ $commande->produits->sum('pivot.quantite') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Livraison</span>
                <span class="info-value" style="color:var(--success);">Incluse</span>
            </div>
            <div class="info-row" style="background:var(--gray-50);">
                <span class="info-label" style="font-weight:800;color:var(--gray-700);">Total</span>
                <span class="total-price-big">
                    {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                </span>
            </div>
        </div>

        {{-- Bouton retour --}}
        <a href="{{ route('commandes.index') }}" class="btn-isi-outline w-100 justify-content-center mt-3">
            <i class="bi bi-arrow-left"></i> Retour à mes commandes
        </a>

        <a href="{{ route('catalogue.index') }}" class="btn-isi-yellow w-100 justify-content-center mt-2">
            <i class="bi bi-grid-3x3-gap-fill"></i> Continuer mes achats
        </a>

    </div>
</div>

@endsection
