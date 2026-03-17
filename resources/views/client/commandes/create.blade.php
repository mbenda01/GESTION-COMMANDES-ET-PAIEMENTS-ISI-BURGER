@extends('layouts.app')

@section('title', 'Passer une commande')

@section('content')

@push('styles')
<style>
    .commande-hero {
        background: linear-gradient(135deg, var(--blue-900) 0%, #0f1e4a 100%);
        border-radius: 20px;
        padding: 32px 40px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .commande-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 40px 40px;
    }

    .commande-hero-content { position: relative; z-index: 2; }

    .commande-hero-title {
        font-size: 1.6rem;
        font-weight: 800;
        color: white;
        margin: 0 0 6px;
        letter-spacing: -0.4px;
    }

    .commande-hero-sub {
        font-size: 0.875rem;
        color: rgba(255,255,255,0.6);
        margin: 0;
    }

    .commande-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }

    .burger-select-card {
        background: white;
        border-radius: 14px;
        border: 2px solid var(--gray-100);
        overflow: hidden;
        transition: all 0.3s;
        animation: fadeInUp 0.4s ease both;
    }

    .burger-select-card:hover {
        border-color: var(--yellow);
        box-shadow: 0 6px 20px rgba(10,42,110,0.1);
    }

    .burger-select-card.selected {
        border-color: var(--yellow);
        box-shadow: 0 4px 16px rgba(255,193,7,0.3);
        background: #fffef5;
    }

    .burger-select-inner {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px 16px;
    }

    .burger-select-img {
        width: 72px;
        height: 72px;
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .burger-select-info { flex: 1; }

    .burger-select-name {
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--blue-900);
        margin: 0 0 3px;
    }

    .burger-select-desc {
        font-size: 0.75rem;
        color: var(--gray-400);
        margin: 0 0 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 240px;
    }

    .burger-select-price {
        font-size: 0.9rem;
        font-weight: 800;
        color: var(--blue-900);
    }

    .qte-control {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .qte-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 2px solid var(--gray-200);
        background: white;
        color: var(--gray-700);
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        line-height: 1;
    }

    .qte-btn:hover {
        border-color: var(--blue);
        color: var(--blue);
        background: var(--blue-light);
    }

    .qte-btn.plus:hover {
        border-color: var(--yellow);
        color: var(--blue-900);
        background: #fff8e1;
    }

    .qte-input {
        width: 48px;
        height: 32px;
        border: 2px solid var(--gray-200);
        border-radius: 8px;
        text-align: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--gray-900);
        outline: none;
        transition: border-color 0.2s;
    }

    .qte-input:focus { border-color: var(--blue); }

    .panier-card {
        background: white;
        border-radius: 18px;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        position: sticky;
        top: 20px;
        overflow: hidden;
    }

    .panier-header {
        background: linear-gradient(135deg, var(--blue-900), var(--blue-800));
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .panier-header-icon {
        width: 38px;
        height: 38px;
        background: rgba(255,193,7,0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: var(--yellow);
    }

    .panier-header-title {
        font-size: 1rem;
        font-weight: 800;
        color: white;
        margin: 0;
    }

    .panier-header-sub {
        font-size: 0.72rem;
        color: rgba(255,255,255,0.5);
        display: block;
    }

    .panier-body { padding: 16px 20px; }

    .panier-empty {
        text-align: center;
        padding: 32px 16px;
        color: var(--gray-400);
        font-size: 0.875rem;
        font-weight: 500;
    }

    .panier-empty i {
        font-size: 2.5rem;
        margin-bottom: 10px;
        display: block;
        color: var(--gray-300);
    }

    .panier-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid var(--gray-100);
        animation: fadeInUp 0.3s ease;
    }

    .panier-item:last-child { border-bottom: none; }

    .panier-item-name {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    .panier-item-qte {
        font-size: 0.72rem;
        color: var(--gray-400);
        font-weight: 500;
    }

    .panier-item-price {
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--blue-900);
        white-space: nowrap;
    }

    .panier-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0 0;
        margin-top: 8px;
        border-top: 2px solid var(--gray-100);
    }

    .panier-total-label {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--gray-700);
    }

    .panier-total-amount {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--blue-900);
    }

    .btn-valider {
        width: 100%;
        margin-top: 16px;
        padding: 14px;
        background: linear-gradient(135deg, var(--yellow), var(--gold));
        color: var(--blue-900);
        border: none;
        border-radius: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.95rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 16px rgba(255,193,7,0.4);
    }

    .btn-valider:hover:not(:disabled) {
        background: linear-gradient(135deg, var(--yellow-dark), #d97706);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(255,193,7,0.5);
    }

    .btn-valider:disabled {
        background: var(--gray-200);
        color: var(--gray-400);
        box-shadow: none;
        cursor: not-allowed;
    }

    .modal-isi .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 24px 80px rgba(0,0,0,0.2);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .modal-isi .modal-header {
        background: linear-gradient(135deg, var(--blue-900), var(--blue-800));
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 20px 24px;
        border: none;
    }

    .modal-isi .modal-title {
        font-weight: 800;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-isi .modal-title i { color: var(--yellow); }
    .modal-isi .btn-close { filter: invert(1); }
    .modal-isi .modal-body { padding: 24px; }
    .modal-isi .modal-footer { padding: 16px 24px 20px; border: none; }

    .modal-form-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--gray-700);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .modal-form-label i { color: var(--blue); }

    .modal-form-control {
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.875rem;
        padding: 10px 14px;
        transition: all 0.25s;
        width: 100%;
        outline: none;
    }

    .modal-form-control:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
    }

    .modal-form-control.is-invalid { border-color: var(--danger); }

    .modal-info-banner {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: var(--blue-light);
        color: var(--blue);
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.82rem;
        font-weight: 600;
        margin-bottom: 20px;
        border: 1px solid rgba(13,110,253,0.15);
    }

    .modal-info-banner i { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }

    @media (max-width: 992px) {
        .commande-layout { grid-template-columns: 1fr; }
        .panier-card { position: static; }
    }
</style>
@endpush

<div class="commande-hero">
    <div class="commande-hero-content">
        <h1 class="commande-hero-title">
            <i class="bi bi-cart-plus-fill me-2" style="color: var(--yellow);"></i>
            Passer une commande
        </h1>
        <p class="commande-hero-sub">
            Sélectionnez vos burgers, ajustez les quantités et validez
        </p>
    </div>
</div>

<form method="POST" action="{{ route('commandes.store') }}" id="formCommande">
@csrf

<input type="hidden" name="prenom"  id="hidden_prenom">
<input type="hidden" name="nom"     id="hidden_nom">
<input type="hidden" name="email"   id="hidden_email">
<input type="hidden" name="adresse" id="hidden_adresse">

<div class="commande-layout">

    {{-- ── BURGERS ── --}}
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="page-title-isi" style="font-size: 1.1rem;">
                <i class="bi bi-egg-fried"></i> Nos burgers
            </h2>
            <small style="color: var(--gray-400); font-size: 0.82rem; font-weight: 500;">
                {{ $produits->count() }} burger(s) disponible(s)
            </small>
        </div>

        <div class="d-flex flex-column gap-3">
            @forelse($produits as $index => $produit)
            <div class="burger-select-card" id="card-{{ $produit->id }}">
                <div class="burger-select-inner">
                    <img
                        src="{{ $produit->image ?? 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=200' }}"
                        alt="{{ $produit->nom }}"
                        class="burger-select-img">

                    <div class="burger-select-info">
                        <h6 class="burger-select-name">{{ $produit->nom }}</h6>
                        <p class="burger-select-desc">{{ $produit->description }}</p>
                        <span class="burger-select-price">
                            {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                        </span>
                    </div>

                    <div class="qte-control">
                        <input type="hidden"
                               name="produits[{{ $index }}][id]"
                               value="{{ $produit->id }}">

                        <button type="button"
                                class="qte-btn minus"
                                onclick="changeQte({{ $produit->id }}, {{ $produit->prix }}, -1, {{ $produit->stock }})">
                            <i class="bi bi-dash"></i>
                        </button>

                        <input type="number"
                               name="produits[{{ $index }}][quantite]"
                               id="qte-{{ $produit->id }}"
                               value="0"
                               min="0"
                               max="{{ $produit->stock }}"
                               class="qte-input"
                               data-prix="{{ $produit->prix }}"
                               data-id="{{ $produit->id }}"
                               data-nom="{{ $produit->nom }}"
                               data-stock="{{ $produit->stock }}"
                               readonly>

                        <button type="button"
                                class="qte-btn plus"
                                onclick="changeQte({{ $produit->id }}, {{ $produit->prix }}, 1, {{ $produit->stock }})">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state-isi">
                <div class="empty-icon-isi"><i class="bi bi-egg-fried"></i></div>
                <h3>Aucun burger disponible</h3>
                <p>Revenez plus tard !</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ── PANIER ── --}}
    <div>
        <div class="panier-card">
            <div class="panier-header">
                <div class="panier-header-icon">
                    <i class="bi bi-cart-fill"></i>
                </div>
                <div>
                    <h6 class="panier-header-title">Mon panier</h6>
                    <span class="panier-header-sub" id="panier-count">0 article(s)</span>
                </div>
            </div>

            <div class="panier-body">
                <div id="panier-items">
                    <div class="panier-empty" id="panier-vide">
                        <i class="bi bi-cart-x"></i>
                        Votre panier est vide
                    </div>
                </div>

                <div class="panier-total-row" id="panier-total-row" style="display:none;">
                    <span class="panier-total-label">Total estimé</span>
                    <span class="panier-total-amount" id="panier-total">0 FCFA</span>
                </div>

                <button type="button"
                        class="btn-valider"
                        id="btnValider"
                        disabled
                        onclick="ouvrirModal()">
                    <i class="bi bi-check-circle-fill"></i>
                    Valider ma commande
                </button>

                <a href="{{ route('catalogue.index') }}"
                   class="btn-isi-outline w-100 mt-2 text-decoration-none"
                   style="justify-content: center;">
                    <i class="bi bi-arrow-left"></i>
                    Continuer mes achats
                </a>
            </div>
        </div>
    </div>

</div>
</form>

{{-- ── MODAL INFOS CLIENT ── --}}
<div class="modal fade modal-isi" id="modalInfosClient"
     tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-person-fill"></i>
                    Vos informations de livraison
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="modal-info-banner">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>
                        Ces informations nous permettent de vous livrer et de vous envoyer
                        la confirmation par email. Aucun compte requis.
                    </span>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="modal-form-label" for="m_prenom">
                            <i class="bi bi-person"></i> Prénom <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="m_prenom" class="modal-form-control"
                               placeholder="Ex: Amadou"
                               value="{{ $infosClient['prenom'] ?? '' }}">
                        <div class="invalid-feedback d-block" id="err_prenom" style="display:none !important;"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="modal-form-label" for="m_nom">
                            <i class="bi bi-person"></i> Nom <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="m_nom" class="modal-form-control"
                               placeholder="Ex: Diallo"
                               value="{{ $infosClient['nom'] ?? '' }}">
                        <div class="invalid-feedback d-block" id="err_nom" style="display:none !important;"></div>
                    </div>
                    <div class="col-12">
                        <label class="modal-form-label" for="m_email">
                            <i class="bi bi-envelope"></i> Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" id="m_email" class="modal-form-control"
                               placeholder="Ex: amadou@email.com"
                               value="{{ $infosClient['email'] ?? '' }}">
                        <div class="invalid-feedback d-block" id="err_email" style="display:none !important;"></div>
                    </div>
                    <div class="col-12">
                        <label class="modal-form-label" for="m_adresse">
                            <i class="bi bi-geo-alt"></i> Adresse de livraison <span class="text-danger">*</span>
                        </label>
                        <textarea id="m_adresse" class="modal-form-control" rows="3"
                                  placeholder="Ex: 15 Avenue Léopold Sédar Senghor, Dakar">{{ $infosClient['adresse'] ?? '' }}</textarea>
                        <div class="invalid-feedback d-block" id="err_adresse" style="display:none !important;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex gap-2 justify-content-end">
                <button type="button" class="btn-isi-outline" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> Annuler
                </button>
                <button type="button" class="btn-isi-yellow" onclick="confirmerCommande()">
                    <i class="bi bi-check-circle-fill"></i>
                    Confirmer ma commande
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let panier = {};

    function changeQte(id, prix, delta, stock) {
        const input = document.getElementById('qte-' + id);
        let qte = parseInt(input.value) || 0;
        qte = Math.max(0, Math.min(stock, qte + delta));
        input.value = qte;
        const card = document.getElementById('card-' + id);
        if (qte > 0) {
            card.classList.add('selected');
            panier[id] = { nom: input.dataset.nom, prix: parseFloat(prix), qte };
        } else {
            card.classList.remove('selected');
            delete panier[id];
        }
        updatePanier();
    }

    function updatePanier() {
        const items    = document.getElementById('panier-items');
        const vide     = document.getElementById('panier-vide');
        const totalEl  = document.getElementById('panier-total');
        const totalRow = document.getElementById('panier-total-row');
        const countEl  = document.getElementById('panier-count');
        const btnVal   = document.getElementById('btnValider');
        const keys     = Object.keys(panier);

        if (keys.length === 0) {
            vide.style.display = 'block';
            totalRow.style.display = 'none';
            btnVal.disabled = true;
            countEl.textContent = '0 article(s)';
            items.innerHTML = '';
            items.appendChild(vide);
            return;
        }

        vide.style.display = 'none';
        totalRow.style.display = 'flex';
        btnVal.disabled = false;

        let total = 0, count = 0, html = '';
        keys.forEach(id => {
            const item = panier[id];
            const sous = item.prix * item.qte;
            total += sous;
            count += item.qte;
            html += `<div class="panier-item">
                <div>
                    <div class="panier-item-name">${item.nom}</div>
                    <div class="panier-item-qte">× ${item.qte}</div>
                </div>
                <div class="panier-item-price">${sous.toLocaleString('fr-FR')} FCFA</div>
            </div>`;
        });

        items.innerHTML = html;
        totalEl.textContent = total.toLocaleString('fr-FR') + ' FCFA';
        countEl.textContent = count + ' article(s)';
    }

    function ouvrirModal() {
        new bootstrap.Modal(document.getElementById('modalInfosClient')).show();
    }

    function confirmerCommande() {
        const prenom  = document.getElementById('m_prenom').value.trim();
        const nom     = document.getElementById('m_nom').value.trim();
        const email   = document.getElementById('m_email').value.trim();
        const adresse = document.getElementById('m_adresse').value.trim();
        let valide    = true;

        [['m_prenom', prenom, 'err_prenom', 'Le prénom est requis.'],
         ['m_nom', nom, 'err_nom', 'Le nom est requis.'],
         ['m_email', email, 'err_email', 'Un email valide est requis.'],
         ['m_adresse', adresse, 'err_adresse', "L'adresse est requise."]
        ].forEach(([fieldId, val, errId, msg]) => {
            const field = document.getElementById(fieldId);
            const err   = document.getElementById(errId);
            const invalid = !val || (fieldId === 'm_email' && !val.includes('@'));
            field.classList.toggle('is-invalid', invalid);
            err.textContent = invalid ? msg : '';
            err.style.setProperty('display', invalid ? 'block' : 'none', 'important');
            if (invalid) valide = false;
        });

        if (!valide) return;

        document.getElementById('hidden_prenom').value  = prenom;
        document.getElementById('hidden_nom').value     = nom;
        document.getElementById('hidden_email').value   = email;
        document.getElementById('hidden_adresse').value = adresse;
        document.getElementById('formCommande').submit();
    }

    // Pré-sélection depuis URL ?produit=ID
    const urlParams = new URLSearchParams(window.location.search);
    const produitId = urlParams.get('produit');
    if (produitId) {
        const input = document.getElementById('qte-' + produitId);
        if (input) {
            const stock = parseInt(input.dataset.stock);
            if (stock > 0) {
                changeQte(parseInt(produitId), parseFloat(input.dataset.prix), 1, stock);
                document.getElementById('card-' + produitId)
                    ?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }
</script>
@endpush

@endsection
