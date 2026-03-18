@extends('layouts.app')

@section('title', 'Gestion des produits')

@section('content')

@push('styles')
<style>
    .prod-kpi-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }
    .prod-kpi {
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
    .prod-kpi:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
    .prod-kpi-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .kpi-blue   .prod-kpi-icon { background: var(--blue-light); color: var(--blue); }
    .kpi-green  .prod-kpi-icon { background: var(--success-light); color: var(--success); }
    .kpi-orange .prod-kpi-icon { background: #fff8e1; color: var(--gold); }
    .kpi-red    .prod-kpi-icon { background: var(--danger-light); color: var(--danger); }
    .prod-kpi-val {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--gray-900);
        display: block;
        line-height: 1;
    }
    .prod-kpi-lbl {
        font-size: 0.72rem;
        color: var(--gray-400);
        font-weight: 600;
        display: block;
        margin-top: 3px;
    }

    .prod-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        border: 2px solid var(--gray-100);
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        animation: fadeInUp 0.4s ease both;
        display: flex;
        flex-direction: column;
    }
    .prod-card:hover {
        border-color: var(--yellow);
        box-shadow: 0 8px 28px rgba(10,42,110,0.12);
        transform: translateY(-4px);
    }
    .prod-card.archived { opacity: 0.6; }
    .prod-card.blocked  { border-color: var(--danger); }

    .prod-image-wrap {
        position: relative;
        height: 170px;
        overflow: hidden;
    }
    .prod-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s;
    }
    .prod-card:hover .prod-image-wrap img { transform: scale(1.05); }

    .prod-status-badges {
        position: absolute;
        top: 10px;
        left: 10px;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .prod-badge {
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 0.65rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,0.2);
    }
    .prod-badge.actif    { background: rgba(22,163,74,0.9);  color: white; }
    .prod-badge.archive  { background: rgba(107,114,128,0.9);color: white; }
    .prod-badge.bloque   { background: rgba(220,38,38,0.9);  color: white; }

    .stock-badge-img {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 800;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,0.2);
    }
    .stock-badge-img.ok     { background: rgba(22,163,74,0.9);  color: white; }
    .stock-badge-img.faible { background: rgba(245,158,11,0.9); color: white; }
    .stock-badge-img.vide   { background: rgba(220,38,38,0.9);  color: white; }

    .price-img-overlay {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: linear-gradient(135deg, rgba(10,42,110,0.95), rgba(13,110,253,0.85));
        color: white;
        padding: 6px 12px;
        border-radius: 9px;
        border: 1px solid rgba(255,193,7,0.3);
        font-size: 0.92rem;
        font-weight: 800;
    }

    .prod-body { padding: 14px 16px; flex: 1; }
    .prod-name { font-size: 0.98rem; font-weight: 800; color: var(--blue-900); margin-bottom: 4px; }
    .prod-desc {
        font-size: 0.78rem;
        color: var(--gray-400);
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .stock-manager {
        background: var(--gray-50);
        border-radius: 10px;
        padding: 10px 12px;
        border: 1.5px solid var(--gray-100);
        margin-bottom: 10px;
    }
    .stock-manager-label {
        font-size: 0.7rem;
        font-weight: 800;
        color: var(--gray-400);
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .stock-current {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--gray-900);
    }
    .stock-form { display: flex; gap: 6px; align-items: center; }
    .stock-input {
        width: 70px;
        border: 2px solid var(--gray-200);
        border-radius: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 700;
        padding: 6px 8px;
        text-align: center;
        outline: none;
        transition: border-color 0.2s;
    }
    .stock-input:focus { border-color: var(--blue); }
    .stock-action-select {
        flex: 1;
        border: 2px solid var(--gray-200);
        border-radius: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 6px 8px;
        outline: none;
        background: white;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .stock-action-select:focus { border-color: var(--blue); }
    .btn-stock-apply {
        background: var(--blue-light);
        color: var(--blue);
        border: none;
        border-radius: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.75rem;
        font-weight: 800;
        padding: 6px 10px;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-stock-apply:hover { background: var(--blue); color: white; }

    .prod-footer {
        padding: 10px 16px 14px;
        border-top: 1px solid var(--gray-100);
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .btn-action-sm {
        flex: 1;
        min-width: 0;
        border: none;
        border-radius: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 7px 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-edit-sm    { background: var(--blue-light); color: var(--blue); }
    .btn-edit-sm:hover { background: var(--blue); color: white; }
    .btn-archive-sm { background: #fff8e1; color: var(--gold); }
    .btn-archive-sm:hover { background: var(--gold); color: white; }
    .btn-delete-sm  { background: var(--danger-light); color: var(--danger); }
    .btn-delete-sm:hover { background: var(--danger); color: white; }
    .btn-block-sm   { background: #fff3e0; color: #e65100; }
    .btn-block-sm:hover { background: #e65100; color: white; }
    .btn-unblock-sm { background: var(--success-light); color: var(--success); }
    .btn-unblock-sm:hover { background: var(--success); color: white; }

    .modal-delete .modal-content {
        border-radius: 20px;
        border: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
        box-shadow: 0 24px 80px rgba(0,0,0,0.2);
    }
    .modal-delete .modal-header {
        background: linear-gradient(135deg, var(--danger), #b91c1c);
        color: white;
        border-radius: 20px 20px 0 0;
        border: none;
        padding: 18px 24px;
    }
    .modal-delete .modal-title {
        font-weight: 800;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        color: white;
    }
    .modal-delete .btn-close { filter: invert(1); }
</style>
@endpush

{{-- ── KPI ── --}}
@php
    $total    = $produits->total();
    $actifs   = \App\Models\Produit::where('archive', false)->where('bloque', false)->count();
    $faibles  = \App\Models\Produit::where('archive', false)->where('stock', '>', 0)->where('stock', '<=', 5)->count();
    $ruptures = \App\Models\Produit::where('stock', '<=', 0)->count();
@endphp

<div class="prod-kpi-row">
    <div class="prod-kpi kpi-blue">
        <div class="prod-kpi-icon"><i class="bi bi-box-seam-fill"></i></div>
        <div>
            <span class="prod-kpi-val">{{ $total }}</span>
            <span class="prod-kpi-lbl">Total burgers actifs</span>
        </div>
    </div>
    <div class="prod-kpi kpi-green">
        <div class="prod-kpi-icon"><i class="bi bi-check-circle-fill"></i></div>
        <div>
            <span class="prod-kpi-val">{{ $actifs }}</span>
            <span class="prod-kpi-lbl">Disponibles</span>
        </div>
    </div>
    <div class="prod-kpi kpi-orange">
        <div class="prod-kpi-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
        <div>
            <span class="prod-kpi-val">{{ $faibles }}</span>
            <span class="prod-kpi-lbl">Stock faible (≤ 5)</span>
        </div>
    </div>
    <div class="prod-kpi kpi-red">
        <div class="prod-kpi-icon"><i class="bi bi-x-circle-fill"></i></div>
        <div>
            <span class="prod-kpi-val">{{ $ruptures }}</span>
            <span class="prod-kpi-lbl">En rupture</span>
        </div>
    </div>
</div>

{{-- ── HEADER ── --}}
<div class="page-header-isi">
    <div>
        <h2 class="page-title-isi">
            <i class="bi bi-box-seam-fill"></i> Gestion des burgers
        </h2>
        <p class="page-subtitle-isi">
            {{ $produits->total() }} burger(s) actif(s) — Page {{ $produits->currentPage() }}/{{ $produits->lastPage() }}
        </p>
    </div>
    <a href="{{ route('admin.produits.create') }}" class="btn-isi-yellow">
        <i class="bi bi-plus-lg"></i> Ajouter un burger
    </a>
</div>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
    <h3 style="font-size:1rem;font-weight:800;color:var(--gray-900);
               display:flex;align-items:center;gap:8px;margin:0;">
        <i class="bi bi-check-circle-fill" style="color:var(--success);"></i>
        Burgers actifs
        <span style="background:var(--success-light);color:var(--success);
                     font-size:0.72rem;padding:2px 10px;border-radius:999px;font-weight:800;">
            {{ $produits->total() }}
        </span>
    </h3>
</div>

<div class="row g-4">
    @forelse($produits as $produit)
    <div class="col-md-4" style="animation-delay: {{ $loop->index * 0.05 }}s">
        <div class="prod-card {{ $produit->bloque ? 'blocked' : '' }}">

            {{-- Image --}}
            <div class="prod-image-wrap">
                <img
                    src="{{ $produit->image ?? 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400' }}"
                    alt="{{ $produit->nom }}"
                    loading="lazy">

                <div class="prod-status-badges">
                    @if($produit->bloque)
                        <span class="prod-badge bloque"><i class="bi bi-slash-circle-fill"></i> Bloqué</span>
                    @else
                        <span class="prod-badge actif"><i class="bi bi-check-circle-fill"></i> Actif</span>
                    @endif
                </div>

                @if($produit->stock <= 0)
                    <span class="stock-badge-img vide">
                        <i class="bi bi-x-circle-fill me-1"></i> Rupture
                    </span>
                @elseif($produit->stock <= 5)
                    <span class="stock-badge-img faible">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $produit->stock }} restants
                    </span>
                @else
                    <span class="stock-badge-img ok">
                        <i class="bi bi-check-circle-fill me-1"></i> {{ $produit->stock }} en stock
                    </span>
                @endif

                <div class="price-img-overlay">
                    {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                </div>
            </div>

            {{-- Body --}}
            <div class="prod-body">
                <h5 class="prod-name">{{ $produit->nom }}</h5>
                <p class="prod-desc">{{ $produit->description }}</p>

                {{-- Gestion stock --}}
                <div class="stock-manager">
                    <div class="stock-manager-label">
                        <span><i class="bi bi-layers-fill me-1"></i> Stock</span>
                        <span class="stock-current
                            {{ $produit->stock <= 0 ? 'text-danger' : ($produit->stock <= 5 ? 'text-warning' : 'text-success') }}">
                            {{ $produit->stock }} unités
                        </span>
                    </div>
                    <form method="POST"
                          action="{{ route('admin.produits.stock', $produit) }}"
                          class="stock-form">
                        @csrf
                        @method('PATCH')
                        <input type="number" name="quantite" class="stock-input"
                               value="1" min="0" required>
                        <select name="action" class="stock-action-select">
                            <option value="ajouter">+ Ajouter</option>
                            <option value="diminuer">− Diminuer</option>
                            <option value="definir">= Définir</option>
                        </select>
                        <button type="submit" class="btn-stock-apply">
                            <i class="bi bi-arrow-repeat"></i> OK
                        </button>
                    </form>
                </div>
            </div>

            {{-- Footer actions --}}
            <div class="prod-footer">
                <a href="{{ route('admin.produits.edit', $produit) }}"
                   class="btn-action-sm btn-edit-sm">
                    <i class="bi bi-pencil-fill"></i> Modifier
                </a>

                {{-- Archiver --}}
                <form method="POST" action="{{ route('admin.produits.archive', $produit) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-action-sm btn-archive-sm" style="width:100%;">
                        <i class="bi bi-archive-fill"></i> Archiver
                    </button>
                </form>

                {{-- Bloquer / Débloquer --}}
                <form method="POST"
                      action="{{ route('admin.produits.stock', $produit) }}"
                      style="flex:1;"
                      id="form-block-{{ $produit->id }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="quantite" value="0" id="block-qty-{{ $produit->id }}">
                    <input type="hidden" name="action" value="definir">
                    @if($produit->bloque)
                        <button type="button"
                                class="btn-action-sm btn-unblock-sm"
                                style="width:100%;"
                                onclick="debloquerProduit({{ $produit->id }})">
                            <i class="bi bi-unlock-fill"></i> Débloquer
                        </button>
                    @else
                        <button type="submit"
                                class="btn-action-sm btn-block-sm"
                                style="width:100%;"
                                onclick="return confirm('Bloquer ce burger ?')">
                            <i class="bi bi-slash-circle-fill"></i> Bloquer
                        </button>
                    @endif
                </form>

                <button type="button"
                        class="btn-action-sm btn-delete-sm"
                        style="width:100%;"
                        onclick="ouvrirModalSuppression({{ $produit->id }}, '{{ addslashes($produit->nom) }}')">
                    <i class="bi bi-trash-fill"></i>
                </button>

                {{-- Formulaire suppression (soumis par le modal) --}}
                <form method="POST"
                      action="{{ route('admin.produits.destroy', $produit) }}"
                      id="form-delete-{{ $produit->id }}"
                      style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state-isi">
            <div class="empty-icon-isi">
                <i class="bi bi-box-seam"></i>
            </div>
            <h3>Aucun produit actif</h3>
            <p>Commencez par ajouter votre premier burger.</p>
            <a href="{{ route('admin.produits.create') }}" class="btn-isi-yellow">
                <i class="bi bi-plus-lg"></i> Ajouter un burger
            </a>
        </div>
    </div>
    @endforelse
</div>

{{-- ── PAGINATION actifs ── --}}
@if($produits->hasPages())
<nav class="mt-4 mb-5">
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

@php $archives = \App\Models\Produit::where('archive', true)->orderBy('updated_at','desc')->get(); @endphp

@if($archives->count() > 0)
<div style="border-top:2px dashed var(--gray-200);padding-top:32px;margin-top:8px;">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h3 style="font-size:1rem;font-weight:800;color:var(--gray-500);
                   display:flex;align-items:center;gap:8px;margin:0;">
            <i class="bi bi-archive-fill" style="color:var(--gold);"></i>
            Produits archivés
            <span style="background:#fff8e1;color:var(--gold);
                         font-size:0.72rem;padding:2px 10px;border-radius:999px;font-weight:800;">
                {{ $archives->count() }}
            </span>
        </h3>
        <small style="color:var(--gray-400);font-size:0.78rem;font-weight:500;">
            <i class="bi bi-eye-slash me-1"></i> Non visibles par les clients
        </small>
    </div>

    <div class="row g-4">
        @foreach($archives as $produit)
        <div class="col-md-4">
            <div class="prod-card archived">
                <div class="prod-image-wrap">
                    <img src="{{ $produit->image ?? 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400' }}"
                         alt="{{ $produit->nom }}" loading="lazy"
                         style="filter:grayscale(0.5);">
                    <div class="prod-status-badges">
                        <span class="prod-badge archive">
                            <i class="bi bi-archive-fill"></i> Archivé
                        </span>
                    </div>
                    <div class="price-img-overlay">
                        {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                    </div>
                </div>

                <div class="prod-body">
                    <h5 class="prod-name" style="color:var(--gray-400);">{{ $produit->nom }}</h5>
                    <p class="prod-desc">{{ $produit->description }}</p>
                </div>

                <div class="prod-footer">
                    {{-- Désarchiver --}}
                    <form method="POST"
                          action="{{ route('admin.produits.archive', $produit) }}"
                          style="flex:2;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-action-sm btn-unblock-sm" style="width:100%;">
                            <i class="bi bi-arrow-counterclockwise"></i> Désarchiver
                        </button>
                    </form>

                    <button type="button"
                            class="btn-action-sm btn-delete-sm"
                            style="flex:1;"
                            onclick="ouvrirModalSuppression({{ $produit->id }}, '{{ addslashes($produit->nom) }}')">
                        <i class="bi bi-trash-fill"></i>
                    </button>

                    <form method="POST"
                          action="{{ route('admin.produits.destroy', $produit) }}"
                          id="form-delete-{{ $produit->id }}"
                          style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif


<div class="modal fade modal-delete" id="modalSuppression" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-trash-fill" style="color:#fca5a5;"></i>
                    Supprimer le burger
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="text-align:center;padding:28px 24px;">
                <div style="width:64px;height:64px;background:var(--danger-light);border-radius:16px;
                            display:flex;align-items:center;justify-content:center;
                            margin:0 auto 16px;font-size:1.8rem;color:var(--danger);">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h6 style="font-size:1rem;font-weight:800;color:var(--gray-900);margin-bottom:8px;">
                    Confirmer la suppression
                </h6>
                <p style="font-size:0.875rem;color:var(--gray-400);margin:0;">
                    Vous allez supprimer définitivement<br>
                    <strong id="nomProduitModal" style="color:var(--danger);"></strong><br>
                    <span style="font-size:0.78rem;">Cette action est irréversible.</span>
                </p>
            </div>
            <div class="modal-footer" style="justify-content:center;gap:10px;padding-bottom:20px;border:none;">
                <button type="button" class="btn-isi-outline" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> Annuler
                </button>
                <button type="button" class="btn-isi-primary"
                        id="btnConfirmerSuppression"
                        style="background:linear-gradient(135deg,var(--danger),#b91c1c);
                               box-shadow:0 4px 14px rgba(220,38,38,0.3);">
                    <i class="bi bi-trash-fill"></i> Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let modalSuppressionInstance = null;
    let formIdASupprimer = null;

    function ouvrirModalSuppression(id, nom) {
        document.querySelectorAll('.modal-backdrop').forEach(e => e.remove());
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';

        formIdASupprimer = id;
        document.getElementById('nomProduitModal').textContent = nom;

        const el = document.getElementById('modalSuppression');
        document.body.appendChild(el);
        el.style.zIndex = '99999';

        modalSuppressionInstance = new bootstrap.Modal(el, {
            backdrop: true,
            keyboard: true,
            focus: true
        });

        modalSuppressionInstance.show();

        setTimeout(() => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.style.zIndex = '99998';
                backdrop.style.opacity = '0.5';
            }
        }, 50);
    }
    document.getElementById('modalSuppression').addEventListener('hidden.bs.modal', function () {
        document.querySelectorAll('.modal-backdrop').forEach(e => e.remove());
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    });

    document.getElementById('btnConfirmerSuppression').addEventListener('click', function () {
        if (formIdASupprimer) {
            document.getElementById('form-delete-' + formIdASupprimer).submit();
        }
    });

    function debloquerProduit(id) {
        const stock = prompt('Nouveau stock pour ce burger ?', '10');
        if (stock === null) return;
        const qty = parseInt(stock) || 0;
        document.getElementById('block-qty-' + id).value = qty;
        document.getElementById('form-block-' + id).submit();
    }
</script>
@endpush

@endsection
