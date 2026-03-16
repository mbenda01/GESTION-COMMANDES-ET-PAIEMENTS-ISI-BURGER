@extends('layouts.app')
@section('title', 'Passer une commande')

@section('content')
<h2 class="fw-bold mb-4">🛒 Passer une commande</h2>

<form method="POST" action="{{ route('commandes.store') }}" id="formCommande">
    @csrf

    <div class="row g-4">
        @forelse($produits as $produit)
        <div class="col-md-3">
            <div class="card h-100" id="card-{{ $produit->id }}">
                <img src="{{ $produit->image ?? 'https://via.placeholder.com/400x200?text=Burger' }}"
                     class="card-img-top"
                     style="height:150px; object-fit:cover;">
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold">{{ $produit->nom }}</h6>
                    <span class="price-amber fw-bold mb-2">
                        {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                    </span>
                    <div class="mt-auto">
                        <label class="form-label" style="font-size:12px;">
                            Quantité (stock: {{ $produit->stock }})
                        </label>
                        <input type="number"
                               name="produits[{{ $loop->index }}][quantite]"
                               value="0"
                               min="0"
                               max="{{ $produit->stock }}"
                               class="form-control form-control-sm qte-input"
                               data-prix="{{ $produit->prix }}"
                               data-id="{{ $produit->id }}"
                               data-index="{{ $loop->index }}">
                        <input type="hidden"
                               name="produits[{{ $loop->index }}][id]"
                               value="{{ $produit->id }}">
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">
            Aucun burger disponible.
        </div>
        @endforelse
    </div>

    {{-- Récapitulatif --}}
    <div class="card mt-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-bold">Total estimé : </span>
                <span class="price-amber fs-4 fw-bold" id="totalEstime">0 FCFA</span>
            </div>
            <button type="submit" class="btn btn-amber btn-lg" id="btnCommander" disabled>
                ✅ Confirmer la commande
            </button>
        </div>
    </div>

</form>

<script>
document.querySelectorAll('.qte-input').forEach(input => {
    input.addEventListener('input', recalcul);
});

function recalcul() {
    let total = 0;
    let hasItem = false;

    document.querySelectorAll('.qte-input').forEach(input => {
        const qte = parseInt(input.value) || 0;
        const prix = parseFloat(input.dataset.prix);
        const id = input.dataset.id;
        const card = document.getElementById('card-' + id);

        if (qte > 0) {
            total += qte * prix;
            hasItem = true;
            card.style.border = '2px solid #D4530A';
        } else {
            card.style.border = '';
        }
    });

    document.getElementById('totalEstime').textContent =
        total.toLocaleString('fr-FR') + ' FCFA';
    document.getElementById('btnCommander').disabled = !hasItem;
}
</script>
@endsection
