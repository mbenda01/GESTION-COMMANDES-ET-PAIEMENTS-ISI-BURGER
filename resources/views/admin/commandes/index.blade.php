@extends('layouts.app')

@section('title', 'Gestion des commandes')

@section('content')

@push('styles')
<style>
    .commandes-kpi {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }
    .ckpi {
        background: white;
        border-radius: 14px;
        padding: 16px 20px;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.25s;
    }
    .ckpi:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
    .ckpi-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .ckpi-orange .ckpi-icon { background: #fff3e0; color: #e65100; }
    .ckpi-blue   .ckpi-icon { background: var(--blue-light); color: var(--blue); }
    .ckpi-green  .ckpi-icon { background: var(--success-light); color: var(--success); }
    .ckpi-gold   .ckpi-icon { background: #fff8e1; color: var(--gold); }
    .ckpi-val {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--gray-900);
        display: block;
        line-height: 1;
    }
    .ckpi-lbl {
        font-size: 0.72rem;
        color: var(--gray-400);
        font-weight: 600;
        display: block;
        margin-top: 3px;
    }

    .filter-bar {
        background: white;
        border-radius: 14px;
        padding: 16px 20px;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-select-sm {
        padding: 9px 12px;
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--gray-700);
        background: white;
        outline: none;
        cursor: pointer;
        transition: all 0.2s;
        min-width: 150px;
    }
    .filter-select-sm:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
    }

    .commande-row {
        background: white;
        border-radius: 14px;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 16px 20px;
        margin-bottom: 10px;
        display: grid;
        grid-template-columns: 130px 1fr 140px 130px 130px 120px;
        align-items: center;
        gap: 12px;
        transition: all 0.25s;
        animation: fadeInUp 0.35s ease both;
    }
    .commande-row:hover {
        border-color: var(--yellow);
        box-shadow: 0 4px 20px rgba(10,42,110,0.1);
        transform: translateY(-1px);
    }

    .cmd-ref {
        background: var(--blue-light);
        color: var(--blue-900);
        font-size: 0.78rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 7px;
        display: inline-block;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .cmd-client {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .cmd-avatar {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        background: linear-gradient(135deg, var(--blue-900), var(--blue-800));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 800;
        flex-shrink: 0;
    }
    .cmd-client-name {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--gray-900);
        display: block;
    }
    .cmd-client-email {
        font-size: 0.72rem;
        color: var(--gray-400);
        display: block;
    }

    .cmd-montant {
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--blue-900);
        white-space: nowrap;
    }

    .cmd-date {
        font-size: 0.78rem;
        color: var(--gray-400);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .statut-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 800;
        white-space: nowrap;
    }
    .sp-en_attente     { background: #fff3e0; color: #e65100; }
    .sp-en_preparation { background: #fff8e1; color: #f57c00; }
    .sp-prete          { background: var(--success-light); color: var(--success); }
    .sp-payee          { background: #e8f5e9; color: #2e7d32; }
    .sp-annulee        { background: var(--danger-light); color: var(--danger); }

    .cmd-actions { display: flex; gap: 6px; justify-content: flex-end; }

    .btn-cmd-voir {
        background: linear-gradient(135deg, var(--yellow), var(--gold));
        color: var(--blue-900);
        border: none;
        border-radius: 9px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.75rem;
        font-weight: 800;
        padding: 7px 12px;
        display: flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(255,193,7,0.3);
    }
    .btn-cmd-voir:hover {
        background: linear-gradient(135deg, var(--yellow-dark), #d97706);
        transform: translateY(-1px);
        color: var(--blue-900);
    }

    .btn-cmd-annuler {
        background: var(--danger-light);
        color: var(--danger);
        border: none;
        border-radius: 9px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.75rem;
        font-weight: 800;
        padding: 7px 12px;
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-cmd-annuler:hover { background: var(--danger); color: white; }

    .list-header-row {
        background: linear-gradient(90deg, var(--blue-900), #0f1e4a);
        border-radius: 12px;
        padding: 10px 20px;
        display: grid;
        grid-template-columns: 130px 1fr 140px 130px 130px 120px;
        gap: 12px;
        margin-bottom: 8px;
    }
    .list-header-row span {
        font-size: 0.68rem;
        font-weight: 800;
        color: rgba(255,255,255,0.65);
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }
</style>
@endpush

{{-- ── KPI ── --}}
@php
    $enAttente    = \App\Models\Commande::whereDate('created_at', today())->where('statut','en_attente')->count();
    $enPrep       = \App\Models\Commande::whereDate('created_at', today())->where('statut','en_preparation')->count();
    $pretesAujourd = \App\Models\Commande::whereDate('created_at', today())->where('statut','prete')->count();
    $recetteJour  = \App\Models\Paiement::whereDate('date_paiement', today())->sum('montant');
@endphp

<div class="commandes-kpi">
    <div class="ckpi ckpi-orange">
        <div class="ckpi-icon"><i class="bi bi-clock-fill"></i></div>
        <div>
            <span class="ckpi-val">{{ $enAttente }}</span>
            <span class="ckpi-lbl">En attente (aujourd'hui)</span>
        </div>
    </div>
    <div class="ckpi ckpi-blue">
        <div class="ckpi-icon"><i class="bi bi-fire"></i></div>
        <div>
            <span class="ckpi-val">{{ $enPrep }}</span>
            <span class="ckpi-lbl">En préparation</span>
        </div>
    </div>
    <div class="ckpi ckpi-green">
        <div class="ckpi-icon"><i class="bi bi-check-circle-fill"></i></div>
        <div>
            <span class="ckpi-val">{{ $pretesAujourd }}</span>
            <span class="ckpi-lbl">Prêtes aujourd'hui</span>
        </div>
    </div>
    <div class="ckpi ckpi-gold">
        <div class="ckpi-icon"><i class="bi bi-coin"></i></div>
        <div>
            <span class="ckpi-val">{{ number_format($recetteJour, 0, ',', ' ') }}</span>
            <span class="ckpi-lbl">FCFA encaissés aujourd'hui</span>
        </div>
    </div>
</div>

{{-- ── HEADER ── --}}
<div class="page-header-isi">
    <div>
        <h2 class="page-title-isi">
            <i class="bi bi-receipt"></i> Gestion des commandes
        </h2>
        <p class="page-subtitle-isi">
            {{ $commandes->total() }} commande(s) au total
        </p>
    </div>
</div>

{{-- ── FILTRES ── --}}
<div class="filter-bar">
    <i class="bi bi-funnel-fill" style="color:var(--blue);font-size:1rem;"></i>
    <form method="GET" action="{{ route('admin.commandes.index') }}"
          style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;flex:1;">
        <select name="statut" class="filter-select-sm" onchange="this.form.submit()">
            <option value="">Tous les statuts</option>
            @foreach(['en_attente'=>'En attente','en_preparation'=>'En préparation','prete'=>'Prête','payee'=>'Payée','annulee'=>'Annulée'] as $val => $label)
                <option value="{{ $val }}" {{ request('statut') == $val ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @if(request('statut'))
            <a href="{{ route('admin.commandes.index') }}" class="btn-isi-outline" style="padding:8px 14px;">
                <i class="bi bi-x-lg"></i> Effacer
            </a>
        @endif
    </form>
</div>

{{-- ── ENTÊTE TABLE ── --}}
@if($commandes->count() > 0)
<div class="list-header-row">
    <span>Référence</span>
    <span>Client</span>
    <span>Montant</span>
    <span>Date</span>
    <span>Statut</span>
    <span style="text-align:right;">Actions</span>
</div>
@endif

{{-- ── LISTE ── --}}
@forelse($commandes as $i => $commande)
<div class="commande-row" style="animation-delay:{{ $i * 0.04 }}s">

    <div>
        <span class="cmd-ref">
            #{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}
        </span>
    </div>

    <div class="cmd-client">
        <div class="cmd-avatar">
            {{ strtoupper(substr($commande->nom_complet_client, 0, 1)) }}
        </div>
        <div>
            <span class="cmd-client-name">{{ $commande->nom_complet_client }}</span>
            <span class="cmd-client-email">{{ $commande->email_client_final }}</span>
        </div>
    </div>

    <div class="cmd-montant">
        {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
    </div>

    <div class="cmd-date">
        <i class="bi bi-calendar3"></i>
        {{ $commande->created_at->format('d/m/Y H:i') }}
    </div>

    <div>
        <span class="statut-pill sp-{{ $commande->statut }}">
            @switch($commande->statut)
                @case('en_attente')     <i class="bi bi-clock-fill"></i> En attente @break
                @case('en_preparation') <i class="bi bi-fire"></i> En préparation @break
                @case('prete')          <i class="bi bi-check-circle-fill"></i> Prête @break
                @case('payee')          <i class="bi bi-patch-check-fill"></i> Payée @break
                @case('annulee')        <i class="bi bi-x-circle-fill"></i> Annulée @break
            @endswitch
        </span>
    </div>

    <div class="cmd-actions">
        <a href="{{ route('admin.commandes.show', $commande) }}"
           class="btn-cmd-voir">
            <i class="bi bi-eye-fill"></i> Voir
        </a>
        @if($commande->estAnnulable())
        <form method="POST"
              action="{{ route('admin.commandes.destroy', $commande) }}"
              onsubmit="return confirm('Annuler cette commande ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-cmd-annuler">
                <i class="bi bi-x-lg"></i>
            </button>
        </form>
        @endif
    </div>

</div>
@empty
<div class="empty-state-isi">
    <div class="empty-icon-isi">
        <i class="bi bi-receipt-cutoff"></i>
    </div>
    <h3>Aucune commande trouvée</h3>
    <p>Aucune commande ne correspond à vos critères.</p>
</div>
@endforelse

{{-- ── PAGINATION ── --}}
@if($commandes->hasPages())
<nav class="mt-4">
    <ul class="pagination-isi">
        <li class="page-item {{ $commandes->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $commandes->previousPageUrl() }}">
                <i class="bi bi-chevron-left"></i>
            </a>
        </li>
        @foreach($commandes->getUrlRange(1, $commandes->lastPage()) as $page => $url)
            <li class="page-item {{ $commandes->currentPage() == $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach
        <li class="page-item {{ !$commandes->hasMorePages() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $commandes->nextPageUrl() }}">
                <i class="bi bi-chevron-right"></i>
            </a>
        </li>
    </ul>
</nav>
@endif

@endsection
