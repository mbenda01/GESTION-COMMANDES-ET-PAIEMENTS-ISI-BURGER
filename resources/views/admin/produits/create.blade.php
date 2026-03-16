@extends('layouts.app')
@section('title', 'Ajouter un burger')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="d-flex align-items-center mb-4 gap-3">
            <a href="{{ route('admin.produits.index') }}" class="btn btn-outline-dark-custom">
                ← Retour
            </a>
            <h2 class="fw-bold mb-0">Ajouter un burger</h2>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.produits.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nom du burger</label>
                        <input type="text" name="nom" value="{{ old('nom') }}"
                               class="form-control @error('nom') is-invalid @enderror"
                               placeholder="Ex: Classic Burger" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Prix (FCFA)</label>
                        <input type="number" name="prix" value="{{ old('prix') }}"
                               class="form-control @error('prix') is-invalid @enderror"
                               placeholder="Ex: 3500" min="0" step="50" required>
                        @error('prix')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Ingrédients, description...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">URL de l'image</label>
                        <input type="url" name="image" value="{{ old('image') }}"
                               class="form-control @error('image') is-invalid @enderror"
                               placeholder="https://exemple.com/image.jpg"
                               id="imageUrl">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        {{-- Prévisualisation --}}
                        <div class="mt-2" id="previewBox" style="display:none;">
                            <img id="previewImg" src="" alt="Aperçu"
                                 style="height:120px; object-fit:cover; border-radius:8px; border:1px solid #E0E0E0;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Stock initial</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}"
                               class="form-control @error('stock') is-invalid @enderror"
                               min="0" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-amber btn-lg">
                            💾 Enregistrer le burger
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
document.getElementById('imageUrl').addEventListener('input', function() {
    const url = this.value.trim();
    const box = document.getElementById('previewBox');
    const img = document.getElementById('previewImg');
    if (url) {
        img.src = url;
        box.style.display = 'block';
    } else {
        box.style.display = 'none';
    }
});
</script>
@endsection
