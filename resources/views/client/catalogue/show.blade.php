@extends('layouts.app')

@section('title', $produit->nom)

@section('content')

@push('styles')
<style>
    .detail-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
        font-size: 0.85rem;
    }

    .detail-breadcrumb a {
        color: var(--blue);
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: color 0.2s;
    }

    .detail-breadcrumb a:hover { color: var(--blue-800); }

    .breadcrumb-sep { color: var(--gray-300); }

    .breadcrumb-current {
        color: var(--gray-400);
        font-weight: 500;
    }

    .detail-layout {
        display: grid;
        grid-template-columns: 460px 1fr;
        gap: 28px;
        align-items: start;
    }

    /* ── IMAGE ── */
    .detail-image-card {
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    }

    .detail-image-card img {
        width: 100%;
        height: 320px;
        object-fit: cover;
        display: block;
        transition: transform 0.5s;
    }

    .detail-image-card:hover img { transform: scale(1.04); }

    .detail-image-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 50%, rgba(10,42,110,0.35) 100%);
    }

    .detail-dispo-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.25);
    }

    .detail-dispo-badge.disponible {
        background: rgba(22,163,74,0.9);
        color: white;
    }

    .detail-dispo-badge.indisponible {
        background: rgba(220,38,38,0.9);
        color: white;
    }

    .detail-price-hero {
        position: absolute;
        bottom: 16px;
        left: 16px;
        background: linear-gradient(135deg, rgba(10,42,110,0.95), rgba(13,110,253,0.85));
        color: white;
        padding: 10px 18px;
        border-radius: 12px;
        border: 1px solid rgba(255,193,7,0.3);
    }

    .detail-price-main {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1;
        display: block;
    }

    .detail-price-sub {
        font-size: 0.7rem;
        opacity: 0.8;
        margin-top: 2px;
    }

    /* ── CONTENT ── */
    .detail-right {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .detail-header-block {
        background: white;
        border-radius: 18px;
        padding: 24px;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    }

    .detail-type-chip {
        display: inline-flex;
        align-items: center;
        background: var(--blue-light);
        color: var(--blue);
        font-size: 0.7rem;
        font-weight: 800;
        padding: 3px 12px;
        border-radius: 999px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    .detail-burger-name {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--gray-900);
        letter-spacing: -0.5px;
        margin: 0 0 12px;
    }

    .detail-description {
        font-size: 0.9rem;
        color: var(--gray-600);
        line-height: 1.8;
        margin: 0;
    }

    .detail-info-block {
        background: white;
        border-radius: 18px;
        padding: 20px 24px;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    }

    .detail-block-title {
        font-size: 0.75rem;
        font-weight: 800;
        color: var(--gray-400);
        text-transform: uppercase;
        letter-spacing: 0.6px;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 16px;
    }

    .detail-block-title i { color: var(--yellow); }

    .rupture-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--danger-light);
        color: var(--danger);
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 0.875rem;
        font-weight: 700;
        border: 1px solid rgba(220,38,38,0.2);
        margin-bottom: 16px;
    }

    .btn-commander-detail {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, var(--yellow), var(--gold));
        color: var(--blue-900);
        border: none;
        border-radius: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: 0 6px 20px rgba(255,193,7,0.4);
    }

    .btn-commander-detail:hover {
        background: linear-gradient(135deg, var(--yellow-dark), #d97706);
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(255,193,7,0.5);
        color: var(--blue-900);
    }

    .btn-commander-detail.disabled {
        background: var(--gray-200);
        color: var(--gray-400);
        box-shadow: none;
        cursor: not-allowed;
        pointer-events: none;
    }

    .btn-retour-catalogue {
        width: 100%;
        padding: 12px;
        background: white;
        color: var(--gray-700);
        border: 2px solid var(--gray-200);
        border-radius: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.25s;
    }

    .btn-retour-catalogue:hover {
        border-color: var(--blue);
        color: var(--blue);
        background: var(--blue-light);
    }

    @media (max-width: 992px) {
        .detail-layout { grid-template-columns: 1fr; }
        .detail-image-card img { height: 260px; }
    }
</style>
@endpush

{{-- ── BREADCRUMB ── --}}
<div class="detail-breadcrumb">
    <a href="{{ route('catalogue.index') }}">
        <i class="bi bi-grid-3x3-gap-fill"></i> Catalogue
    </a>
    <span class="breadcrumb-sep">/</span>
    <span class="breadcrumb-current">{{ $produit->nom }}</span>
</div>

{{-- ── LAYOUT ── --}}
<div class="detail-layout">

    {{-- IMAGE --}}
    <div>
        <div class="detail-image-card">
            <img
                src="{{ $produit->image ?? 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=800' }}"
                alt="{{ $produit->nom }}">
            <div class="detail-image-overlay"></div>

            <span class="detail-dispo-badge {{ $produit->estDisponible() ? 'disponible' : 'indisponible' }}">
                <i class="bi {{ $produit->estDisponible() ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                {{ $produit->estDisponible() ? 'Disponible' : 'Indisponible' }}
            </span>

            <div class="detail-price-hero">
                <span class="detail-price-main">
                    {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                </span>
                <div class="detail-price-sub">par burger</div>
            </div>
        </div>
    </div>

    {{-- CONTENU --}}
    <div class="detail-right">

        {{-- Nom + description --}}
        <div class="detail-header-block">
            <span class="detail-type-chip">
                <i class="bi bi-egg-fried me-1"></i> Burger ISI
            </span>
            <h1 class="detail-burger-name">{{ $produit->nom }}</h1>
            <p class="detail-description">
                {{ $produit->description ?? 'Aucune description disponible pour ce burger.' }}
            </p>
        </div>

        {{-- Actions --}}
        <div class="detail-info-block">
            <div class="detail-block-title">
                <i class="bi bi-cart-fill"></i> Commander
            </div>

            @if(!$produit->estDisponible())
                <div class="rupture-alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div>
                        <div style="font-size: 0.9rem;">
                            {{ $produit->archive ? 'Ce burger est archivé.' : 'Ce burger est en rupture de stock.' }}
                        </div>
                        <div style="font-size: 0.78rem; opacity: 0.8; margin-top: 2px;">
                            Revenez plus tard ou consultez nos autres burgers.
                        </div>
                    </div>
                </div>
            @endif

            @if($produit->estDisponible())
                <a href="{{ route('commandes.create') }}?produit={{ $produit->id }}"
                   class="btn-commander-detail mb-3">
                    <i class="bi bi-cart-plus-fill"></i>
                    Commander ce burger
                </a>
            @else
                <span class="btn-commander-detail disabled mb-3">
                    <i class="bi bi-slash-circle"></i>
                    Indisponible actuellement
                </span>
            @endif

            <a href="{{ route('catalogue.index') }}" class="btn-retour-catalogue">
                <i class="bi bi-arrow-left"></i>
                Retour au catalogue
            </a>
        </div>

        {{-- Prix récapitulatif --}}
        <div class="detail-info-block">
            <div class="detail-block-title">
                <i class="bi bi-receipt"></i> Récapitulatif
            </div>
            <div class="d-flex justify-content-between align-items-center py-2"
                 style="border-bottom: 1px solid var(--gray-100);">
                <span style="font-size: 0.85rem; color: var(--gray-400); font-weight: 500;">
                    Prix unitaire
                </span>
                <span style="font-size: 0.92rem; font-weight: 800; color: var(--blue-900);">
                    {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                </span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2"
                 style="border-bottom: 1px solid var(--gray-100);">
                <span style="font-size: 0.85rem; color: var(--gray-400); font-weight: 500;">
                    Livraison
                </span>
                <span style="font-size: 0.85rem; font-weight: 700; color: var(--success);">
                    <i class="bi bi-check-circle-fill me-1"></i> Incluse
                </span>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <span style="font-size: 0.9rem; color: var(--gray-700); font-weight: 700;">
                    Total (1 burger)
                </span>
                <span style="font-size: 1.1rem; font-weight: 800; color: var(--blue-900);">
                    {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                </span>
            </div>
        </div>

    </div>
</div>

@endsection
