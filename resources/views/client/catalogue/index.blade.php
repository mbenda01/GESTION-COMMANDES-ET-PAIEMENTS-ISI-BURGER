@extends('layouts.app')

@section('title', 'Catalogue — Nos Burgers')

@section('content')

@push('styles')
<style>
    .catalogue-hero {
        background: linear-gradient(135deg, var(--blue-900) 0%, #0f1e4a 60%, var(--blue-800) 100%);
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }

    .catalogue-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 40px 40px;
    }

    .catalogue-hero::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255,193,7,0.06);
        top: -100px;
        right: -80px;
    }

    .hero-content { position: relative; z-index: 2; }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, var(--yellow), var(--gold));
        color: var(--blue-900);
        font-size: 0.72rem;
        font-weight: 800;
        padding: 5px 14px;
        border-radius: 999px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 14px;
    }

    .hero-title {
        font-size: 2rem;
        font-weight: 800;
        color: white;
        letter-spacing: -0.5px;
        margin-bottom: 8px;
    }

    .hero-title span { color: var(--yellow); }

    .hero-sub {
        font-size: 0.95rem;
        color: rgba(255,255,255,0.6);
        margin: 0;
        font-weight: 400;
    }

    .filters-card {
        background: white;
        border-radius: 16px;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 28px;
    }

    .filters-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 20px;
        background: linear-gradient(90deg, var(--blue-900), #0f1e4a);
        color: white;
    }

    .filters-header h6 {
        margin: 0;
        font-size: 0.88rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filters-header h6 i { color: var(--yellow); }

    .badge-results {
        background: var(--yellow);
        color: var(--blue-900);
        font-size: 0.72rem;
        font-weight: 800;
        padding: 3px 12px;
        border-radius: 999px;
    }

    .filters-body { padding: 18px 20px; }

    .filter-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--gray-700);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .filter-label i { color: var(--blue); }

    .filter-control {
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.875rem;
        padding: 9px 12px;
        transition: all 0.25s;
        width: 100%;
        outline: none;
    }

    .filter-control:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
    }

    .btn-filter-reset {
        background: var(--danger-light);
        color: var(--danger);
        border: none;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.875rem;
        font-weight: 700;
        padding: 9px 16px;
        width: 100%;
        transition: all 0.25s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
    }

    .btn-filter-reset:hover { background: #fecaca; }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .section-title i { color: var(--yellow); }

    .burger-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: all 0.35s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        animation: fadeInUp 0.4s ease both;
    }

    .burger-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 40px rgba(10,42,110,0.14);
        border-color: var(--yellow);
    }

    .burger-card.indisponible {
        opacity: 0.75;
        filter: grayscale(0.3);
    }

    .burger-card.indisponible:hover {
        transform: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border-color: var(--gray-200);
        cursor: not-allowed;
    }

    .card-image-wrap {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .card-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .burger-card:hover:not(.indisponible) .card-image-wrap img {
        transform: scale(1.06);
    }

    .card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,0.22) 100%);
    }

    .dispo-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 5px;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.25);
    }

    .dispo-badge.disponible {
        background: rgba(22,163,74,0.9);
        color: white;
    }

    .dispo-badge.indisponible {
        background: rgba(220,38,38,0.9);
        color: white;
    }

    .price-overlay {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: linear-gradient(135deg, rgba(10,42,110,0.95), rgba(13,110,253,0.85));
        color: white;
        padding: 7px 14px;
        border-radius: 10px;
        border: 1px solid rgba(255,193,7,0.3);
    }

    .price-amount {
        font-size: 1rem;
        font-weight: 800;
        line-height: 1;
        display: block;
    }

    .price-label {
        font-size: 0.62rem;
        opacity: 0.8;
    }

    .card-body-isi {
        padding: 16px 18px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .burger-name {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--blue-900);
        margin: 0;
    }

    .burger-desc {
        font-size: 0.8rem;
        color: var(--gray-400);
        line-height: 1.5;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .rupture-msg {
        display: flex;
        align-items: center;
        gap: 6px;
        background: var(--danger-light);
        color: var(--danger);
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.78rem;
        font-weight: 700;
        margin-top: 4px;
    }

    .card-footer-isi {
        padding: 12px 18px 16px;
        border-top: 1px solid var(--gray-100);
        display: flex;
        gap: 8px;
    }

    .btn-detail-card {
        flex: 1;
        background: var(--blue-light);
        color: var(--blue);
        border: none;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 9px 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.25s;
    }

    .btn-detail-card:hover {
        background: var(--blue);
        color: white;
    }

    .btn-commander-card {
        flex: 2;
        background: linear-gradient(135deg, var(--yellow), var(--gold));
        color: var(--blue-900);
        border: none;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.8rem;
        font-weight: 800;
        padding: 9px 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.25s;
        box-shadow: 0 3px 10px rgba(255,193,7,0.3);
    }

    .btn-commander-card:hover {
        background: linear-gradient(135deg, var(--yellow-dark), #d97706);
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(255,193,7,0.4);
        color: var(--blue-900);
    }

    .btn-commander-card.disabled-btn {
        background: var(--gray-200);
        color: var(--gray-400);
        box-shadow: none;
        cursor: not-allowed;
        pointer-events: none;
    }
</style>
<script>
    function showRuptureModal(nom) {
        document.getElementById('ruptureNom').textContent = nom;
        new bootstrap.Modal(document.getElementById('modalRupture')).show();
    }
</script>
@endpush

{{-- ── HERO ── --}}
<div class="catalogue-hero">
    <div class="hero-content">
        <div class="hero-badge">
            <i class="bi bi-egg-fried"></i> Nos Burgers
        </div>
        <h1 class="hero-title">
            Découvrez nos <span>burgers</span> du moment
        </h1>
        <p class="hero-sub">
            Commandez sans créer de compte — livraison rapide à votre adresse
        </p>
    </div>
</div>

{{-- ── FILTRES ── --}}
<div class="filters-card">
    <div class="filters-header">
        <h6>
            <i class="bi bi-funnel-fill"></i>
            Filtrer les burgers
        </h6>
        <span class="badge-results">{{ $produits->total() }} résultat(s)</span>
    </div>
    <div class="filters-body">
        <form method="GET" action="{{ route('catalogue.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="filter-label">
                        <i class="bi bi-search"></i> Rechercher
                    </label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="filter-control"
                        placeholder="Nom du burger...">
                </div>
                <div class="col-md-3">
                    <label class="filter-label">
                        <i class="bi bi-currency-exchange"></i> Prix min (FCFA)
                    </label>
                    <input
                        type="number"
                        name="prix_min"
                        value="{{ request('prix_min') }}"
                        class="filter-control"
                        placeholder="0"
                        min="0">
                </div>
                <div class="col-md-3">
                    <label class="filter-label">
                        <i class="bi bi-currency-exchange"></i> Prix max (FCFA)
                    </label>
                    <input
                        type="number"
                        name="prix_max"
                        value="{{ request('prix_max') }}"
                        class="filter-control"
                        placeholder="10 000"
                        min="0">
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-isi-primary flex-fill" style="justify-content:center;">
                            <i class="bi bi-search"></i> Filtrer
                        </button>
                        @if(request('search') || request('prix_min') || request('prix_max'))
                            <a href="{{ route('catalogue.index') }}"
                               class="btn-isi-outline"
                               style="padding: 9px 12px;">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ── GRILLE PRODUITS ── --}}
<div class="section-header">
    <h2 class="section-title">
        <i class="bi bi-grid-3x3-gap-fill"></i>
        Tous nos burgers
    </h2>
    <small style="color: var(--gray-400); font-weight: 500; font-size: 0.82rem;">
        Page {{ $produits->currentPage() }} / {{ $produits->lastPage() }}
    </small>
</div>

@forelse($produits->chunk(3) as $row)
<div class="row g-4 mb-4">
    @foreach($row as $produit)
    <div class="col-md-4">
        <div class="burger-card {{ !$produit->estDisponible() ? 'indisponible' : '' }}">

            <div class="card-image-wrap">
                <img
                    src="{{ $produit->image ?? 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400' }}"
                    alt="{{ $produit->nom }}"
                    loading="lazy">
                <div class="card-overlay"></div>

                <span class="dispo-badge {{ $produit->estDisponible() ? 'disponible' : 'indisponible' }}">
                    <i class="bi {{ $produit->estDisponible() ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                    {{ $produit->estDisponible() ? 'Disponible' : 'Indisponible' }}
                </span>

                <div class="price-overlay">
                    <span class="price-amount">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
                    <span class="price-label">/ burger</span>
                </div>
            </div>

            <div class="card-body-isi">
                <h5 class="burger-name">{{ $produit->nom }}</h5>
                <p class="burger-desc">{{ $produit->description }}</p>

                @if(!$produit->estDisponible())
                    <div class="rupture-msg">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        {{ $produit->archive ? 'Produit archivé' : 'Rupture de stock' }}
                    </div>
                @endif
            </div>

        <div class="card-footer-isi">
            <a href="{{ route('catalogue.show', $produit) }}"
            class="btn-detail-card">
                <i class="bi bi-eye-fill"></i> Détail
            </a>

            @if($produit->estDisponible())
                <a href="{{ route('commandes.create') }}?produit={{ $produit->id }}"
                class="btn-commander-card">
                    <i class="bi bi-cart-plus-fill"></i> Commander
                </a>
            @elseif(!$produit->archive && $produit->bloque)
                {{-- Bloqué : bouton grisé + modal --}}
                <button type="button"
                        class="btn-commander-card disabled-btn"
                        onclick="showRuptureModal('{{ $produit->nom }}')">
                    <i class="bi bi-slash-circle"></i> Rupture de stock
                </button>
            @else
                <span class="btn-commander-card disabled-btn">
                    <i class="bi bi-slash-circle"></i> Indisponible
                </span>
            @endif
        </div>

        </div>
    </div>
    @endforeach
</div>
@empty
<div class="empty-state-isi">
    <div class="empty-icon-isi">
        <i class="bi bi-egg-fried"></i>
    </div>
    <h3>Aucun burger trouvé</h3>
    <p>Essayez de modifier vos critères de recherche.</p>
    <a href="{{ route('catalogue.index') }}" class="btn-isi-yellow">
        <i class="bi bi-arrow-clockwise"></i> Voir tous les burgers
    </a>
</div>
@endforelse

{{-- ── PAGINATION ── --}}
@if($produits->hasPages())
<nav>
    <ul class="pagination-isi">
        <li class="page-item {{ $produits->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $produits->previousPageUrl() }}">
                <i class="bi bi-chevron-left"></i>
            </a>
        </li>

        @foreach($produits->getUrlRange(1, $produits->lastPage()) as $page => $url)
            <li class="page-item {{ $produits->currentPage() == $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        <li class="page-item {{ !$produits->hasMorePages() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $produits->nextPageUrl() }}">
                <i class="bi bi-chevron-right"></i>
            </a>
        </li>
    </ul>
</nav>
@endif
{{-- ── MODAL RUPTURE ── --}}
<div class="modal fade modal-isi" id="modalRupture" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,var(--danger),#b91c1c);">
                <h5 class="modal-title" style="color:white;font-weight:800;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-exclamation-triangle-fill" style="color:#fca5a5;"></i>
                    Rupture de stock
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="text-align:center;padding:28px 24px;">
                <div style="width:64px;height:64px;background:var(--danger-light);border-radius:16px;
                            display:flex;align-items:center;justify-content:center;
                            margin:0 auto 16px;font-size:1.8rem;color:var(--danger);">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h6 id="ruptureNom" style="font-size:1rem;font-weight:800;color:var(--gray-900);margin-bottom:8px;"></h6>
                <p style="font-size:0.875rem;color:var(--gray-400);margin:0;">
                    Ce burger est temporairement en rupture de stock.<br>
                    Revenez bientôt ou commandez un autre burger !
                </p>
            </div>
            <div class="modal-footer" style="justify-content:center;gap:10px;padding-bottom:20px;border:none;">
                <button type="button" class="btn-isi-outline" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> Fermer
                </button>
                <a href="{{ route('catalogue.index') }}" class="btn-isi-yellow">
                    <i class="bi bi-grid-3x3-gap-fill"></i> Voir d'autres burgers
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
