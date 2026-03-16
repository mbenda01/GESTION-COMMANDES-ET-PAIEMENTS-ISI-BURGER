@extends('layouts.app')
@section('title', 'Modifier un burger')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="d-flex align-items-center mb-4 gap-3">
            <a href="{{ route('admin.produits.index') }}" class="btn btn-outline-dark-custom">
                ← Retour
            </a>
            <h2 class="fw-bold mb-0">Modifier : {{ $produit->nom }}</h2>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.produits.update', $produit) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nom du burger</label>
                        <input type="text" name="nom"
                               value="{{ old('nom', $produit->nom) }}"
                               class="form-control @error('nom') is-invalid @enderror" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Prix (FCFA)</label>
                        <input type="number" name="prix"
                               value="{{ old('prix', $produit->prix) }}"
                               class="form-control @error('prix') is-invalid @enderror"
                               min="0" step="50" required>
                        @error('prix')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $produit->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">URL de l'image</label>
                        <input type="url" name="image"
                               value="{{ old('image', $produit->image) }}"
                               class="form-control @error('image') is-invalid @enderror"
                               id="imageUrl">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <img id="previewImg"
                                 src="{{ $produit->image }}"
                                 alt="Aperçu"
                                 style="height:120px; object-fit:cover; border-radius:8px; border:1px solid #E0E0E0; {{ $produit->image ? '' : 'display:none;' }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Stock</label>
                        <input type="number" name="stock"
                               value="{{ old('stock', $produit->stock) }}"
                               class="form-control @error('stock') is-invalid @enderror"
                               min="0" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="archive" value="1"
                               class="form-check-input" id="archive"
                               {{ old('archive', $produit->archive) ? 'checked' : '' }}>
                        <label class="form-check-label" for="archive">
                            Archiver ce burger (ne sera plus visible dans le catalogue)
                        </label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-amber btn-lg">
                            💾 Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
document.getElementById('imageUrl').addEventListener('input', function() {
    document.getElementById('previewImg').src = this.value;
});
</script>
@endsection
