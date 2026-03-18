@extends('layouts.app')

@section('title', 'Mes commandes')

@section('content')

@push('styles')
<style>
    .commandes-hero {
        background: linear-gradient(135deg, var(--blue-900) 0%, #0f1e4a 60%, var(--blue-800) 100%);
        border-radius: 20px;
        padding: 32px 40px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }
    .commandes-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 40px 40px;
    }
    .commandes-hero .hero-content { position: relative; z-index: 2; }

    .commande-row-card {
        background: white;
        border-radius: 16px;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 20px 24px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        transition: all 0.25s;
        animation: fadeInUp 0.4s ease both;
    }
    .commande-row-card:hover {
        border-color: var(--yellow);
        box-shadow: 0 6px 24px rgba(10,42,110,0.1);
        transform: translateY(-2px);
    }

    .commande-ref {
        background: var(--blue-light);
        color: var(--blue-900);
        font-size: 0.78rem;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        letter-spacing: 0.3px;
    }

    .commande-date {
        font-size: 0.8rem;
        color: var(--gray-400);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .commande-burgers {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--gray-700);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .commande-montant {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--blue-900);
        white-space: nowrap;
    }

    .commande-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-voir-commande {
        background: linear-gradient(135deg, var(--yellow), var(--gold));
        color: var(--blue-900);
        border: none;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.8rem;
        font-weight: 800;
        padding: 9px 16px;
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.25s;
        box-shadow: 0 3px 10px rgba(255,193,7,0.3);
    }
    .btn-voir-commande:hover {
        background: linear-gradient(135deg, var(--yellow-dark), #d97706);
        transform: translateY(-1px);
        color: var(--blue-900);
    }

    .statut-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 800;
        white-space: nowrap;
    }
    .statut-en_attente     { background: #fff3e0; color: #e65100; }
    .statut-en_preparation { background: #fff8e1; color: #f57c00; }
    .statut-prete          { background: var(--success-light); color: var(--success); }
    .statut-payee          { background: #e8f5e9; color: #2e7d32; }
    .statut-annulee        { background: var(--danger-light); color: var(--danger); }

    .kpi-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }
    .kpi-mini {
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
    .kpi-mini:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
    .kpi-mini-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .kpi-blue  .kpi-mini-icon { background: var(--blue-light); color: var(--blue); }
    .kpi-green .kpi-mini-icon { background: var(--success-light); color: var(--success); }
    .kpi-gold  .kpi-mini-icon { background: #fff8e1; color: var(--gold); }
    .kpi-mini-val {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--gray-900);
        line-height: 1;
        display: block;
    }
    .kpi-mini-lbl {
        font-size: 0.72rem;
        color: var(--gray-400);
        font-weight: 600;
        display: block;
        margin-top: 2px;
    }
</style>
@endpush

{{-- ── HERO ── --}}
<div class="commandes-hero">
    <div class="hero-content">
        <div style="display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,var(--yellow),var(--gold));color:var(--blue-900);font-size:0.72rem;font-weight:800;padding:4px 14px;border-radius:999px;text-transform:uppercase;letter-spacing:0.8px;margin-bottom:12px;">
            <i class="bi bi-bag-fill"></i> Espace client
        </div>
        <h1 style="font-size:1.8rem;font-weight:800;color:white;letter-spacing:-0.5px;margin-bottom:6px;">
            Mes <span style="color:var(--yellow);">commandes</span>
        </h1>
        <p style="font-size:0.9rem;color:rgba(255,255,255,0.6);margin:0;">
            Suivez vos commandes et validez vos achats
        </p>
    </div>
</div>

{{-- ── KPI ── --}}
@php
    $total = $commandes->total();

    if (Auth::check()) {
        $enCours = \App\Models\Commande::where('user_id', Auth::id())
            ->whereIn('statut', ['en_attente','en_preparation'])
            ->count();
        $montantTotal = \App\Models\Commande::where('user_id', Auth::id())
            ->sum('montant_total');
    } else {
        $ids = session('commandes_ids', []);
        $enCours = \App\Models\Commande::whereIn('id', $ids)
            ->whereIn('statut', ['en_attente','en_preparation'])
            ->count();
        $montantTotal = \App\Models\Commande::whereIn('id', $ids)
            ->sum('montant_total');
    }
@endphp

<div class="kpi-row">
    <div class="kpi-mini kpi-blue">
        <div class="kpi-mini-icon"><i class="bi bi-bag-fill"></i></div>
        <div>
            <span class="kpi-mini-val">{{ $total }}</span>
            <span class="kpi-mini-lbl">Commande(s) passée(s)</span>
        </div>
    </div>
    <div class="kpi-mini kpi-green">
        <div class="kpi-mini-icon"><i class="bi bi-hourglass-split"></i></div>
        <div>
            <span class="kpi-mini-val">{{ $enCours }}</span>
            <span class="kpi-mini-lbl">En cours</span>
        </div>
    </div>
    <div class="kpi-mini kpi-gold">
        <div class="kpi-mini-icon"><i class="bi bi-coin"></i></div>
        <div>
            <span class="kpi-mini-val">{{ number_format($montantTotal, 0, ',', ' ') }}</span>
            <span class="kpi-mini-lbl">FCFA total commandé</span>
        </div>
    </div>
</div>

{{-- ── HEADER ── --}}
<div class="page-header-isi">
    <div>
        <h2 class="page-title-isi">
            <i class="bi bi-receipt"></i> Liste des commandes
        </h2>
        <p class="page-subtitle-isi">Cliquez sur "Voir" pour consulter le détail et valider votre achat</p>
    </div>
    <a href="{{ route('commandes.create') }}" class="btn-isi-yellow">
        <i class="bi bi-cart-plus-fill"></i> Nouvelle commande
    </a>
</div>

{{-- ── LISTE ── --}}
@forelse($commandes as $commande)
    <div class="commande-row-card" style="animation-delay: {{ $loop->index * 0.05 }}s">

        <div class="d-flex align-items-center gap-12 flex-wrap gap-3">
            <span class="commande-ref">
                #{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}
            </span>
            <span class="commande-date">
                <i class="bi bi-calendar3"></i>
                {{ $commande->created_at->format('d/m/Y à H:i') }}
            </span>
        </div>

        <div class="commande-burgers">
            <i class="bi bi-egg-fried" style="color:var(--yellow);"></i>
            {{ $commande->produits->count() }} burger(s)
        </div>

        <span class="commande-montant">
            {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
        </span>

        <span class="statut-pill statut-{{ $commande->statut }}">
            @switch($commande->statut)
                @case('en_attente')
                    <i class="bi bi-clock-fill"></i> En attente
                    @break
                @case('en_preparation')
                    <i class="bi bi-fire"></i> En préparation
                    @break
                @case('prete')
                    <i class="bi bi-check-circle-fill"></i> Prête
                    @break
                @case('payee')
                    <i class="bi bi-patch-check-fill"></i> Payée
                    @break
                @case('annulee')
                    <i class="bi bi-x-circle-fill"></i> Annulée
                    @break
            @endswitch
        </span>

        <div class="commande-actions">
            <a href="{{ route('commandes.show', $commande) }}" class="btn-voir-commande">
                <i class="bi bi-eye-fill"></i> Voir & Valider
            </a>
        </div>

    </div>
@empty
    <div class="empty-state-isi">
        <div class="empty-icon-isi">
            <i class="bi bi-bag-x"></i>
        </div>
        <h3>Aucune commande pour le moment</h3>
        <p>Vous n'avez pas encore passé de commande. Découvrez nos burgers !</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ route('catalogue.index') }}" class="btn-isi-yellow">
                <i class="bi bi-grid-3x3-gap-fill"></i> Voir le catalogue
            </a>
            <a href="{{ route('commandes.create') }}" class="btn-isi-primary">
                <i class="bi bi-cart-plus-fill"></i> Commander
            </a>
        </div>
    </div>
@endforelse

{{-- ── PAGINATION ── --}}
@if($commandes->hasPages())
<nav>
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
@if(session('success'))
<script>
    localStorage.removeItem('isi_panier');
</script>
@endif
@endif

@endsection
