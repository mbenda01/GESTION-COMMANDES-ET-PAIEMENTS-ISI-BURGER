@extends('layouts.app')

@section('title', 'Modifier : ' . $produit->nom)

@section('content')

@push('styles')
<style>
    .form-card {
        background: white;
        border-radius: 20px;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .form-card-header {
        background: linear-gradient(90deg, var(--blue-900), #0f1e4a);
        padding: 20px 28px;
    }
    .form-card-header h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        color: white;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-card-header h5 i { color: var(--yellow); }
    .form-card-body { padding: 28px; }

    .form-group-isi { margin-bottom: 20px; }
    .form-label-isi {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--gray-700);
        margin-bottom: 7px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .form-label-isi i { color: var(--blue); }
    .req { color: var(--danger); margin-left: 2px; }

    .form-control-isi {
        width: 100%;
        padding: 11px 14px;
        background: white;
        border: 2px solid var(--gray-200);
        border-radius: 11px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.875rem;
        color: var(--gray-900);
        transition: all 0.25s;
        outline: none;
    }
    .form-control-isi:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
    }
    .form-control-isi.is-invalid { border-color: var(--danger); }
    .form-control-isi.textarea { resize: vertical; min-height: 90px; }

    .invalid-msg {
        font-size: 0.78rem;
        color: var(--danger);
        font-weight: 600;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .preview-box {
        border-radius: 12px;
        overflow: hidden;
        height: 160px;
        margin-top: 10px;
        border: 2px solid var(--gray-200);
    }
    .preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .stock-info-banner {
        background: var(--blue-light);
        border-radius: 12px;
        padding: 14px 18px;
        border: 1.5px solid rgba(13,110,253,0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }
    .stock-info-banner i { color: var(--blue); font-size: 1.2rem; }
    .stock-info-banner .stock-val {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--blue-900);
    }
    .stock-info-banner .stock-lbl {
        font-size: 0.78rem;
        color: var(--blue);
        font-weight: 600;
    }

    .toggle-check {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px 16px;
        background: var(--gray-50);
        border-radius: 11px;
        border: 1.5px solid var(--gray-100);
        cursor: pointer;
    }
    .toggle-check-label {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--gray-700);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .toggle-check-label i { color: var(--gold); }

    .form-check-input-lg {
        width: 44px;
        height: 24px;
        cursor: pointer;
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 20px;
        border-top: 1.5px solid var(--gray-100);
        margin-top: 8px;
    }
</style>
@endpush

{{-- ── BREADCRUMB ── --}}
<div style="display:flex;align-items:center;gap:8px;margin-bottom:24px;font-size:0.85rem;">
    <a href="{{ route('admin.produits.index') }}"
       style="color:var(--blue);text-decoration:none;font-weight:600;display:flex;align-items:center;gap:5px;">
        <i class="bi bi-box-seam-fill"></i> Produits
    </a>
    <span style="color:var(--gray-300);">/</span>
    <span style="color:var(--gray-400);font-weight:500;">Modifier : {{ $produit->nom }}</span>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="form-card-header">
                <h5>
                    <i class="bi bi-pencil-fill"></i>
                    Modifier : {{ $produit->nom }}
                </h5>
            </div>
            <div class="form-card-body">
                <form method="POST" action="{{ route('admin.produits.update', $produit) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        {{-- Nom --}}
                        <div class="col-12">
                            <div class="form-group-isi">
                                <label class="form-label-isi">
                                    <i class="bi bi-egg-fried"></i> Nom du burger <span class="req">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="nom"
                                    value="{{ old('nom', $produit->nom) }}"
                                    class="form-control-isi {{ $errors->has('nom') ? 'is-invalid' : '' }}"
                                    required>
                                @error('nom')
                                    <div class="invalid-msg">
                                        <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Prix --}}
                        <div class="col-md-6">
                            <div class="form-group-isi">
                                <label class="form-label-isi">
                                    <i class="bi bi-coin"></i> Prix (FCFA) <span class="req">*</span>
                                </label>
                                <input
                                    type="number"
                                    name="prix"
                                    value="{{ old('prix', $produit->prix) }}"
                                    class="form-control-isi {{ $errors->has('prix') ? 'is-invalid' : '' }}"
                                    min="0"
                                    step="50"
                                    required>
                                @error('prix')
                                    <div class="invalid-msg">
                                        <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Stock --}}
                        <div class="col-md-6">
                            <div class="form-group-isi">
                                <label class="form-label-isi">
                                    <i class="bi bi-layers-fill"></i> Stock <span class="req">*</span>
                                </label>
                                <div class="stock-info-banner">
                                    <i class="bi bi-layers-fill"></i>
                                    <div>
                                        <span class="stock-val
                                            {{ $produit->stock <= 0 ? 'text-danger' : ($produit->stock <= 5 ? 'text-warning' : '') }}">
                                            {{ $produit->stock }}
                                        </span>
                                        <span class="stock-lbl"> unités actuellement</span>
                                    </div>
                                </div>
                                <input
                                    type="number"
                                    name="stock"
                                    value="{{ old('stock', $produit->stock) }}"
                                    class="form-control-isi {{ $errors->has('stock') ? 'is-invalid' : '' }}"
                                    min="0"
                                    required>
                                @error('stock')
                                    <div class="invalid-msg">
                                        <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="col-12">
                            <div class="form-group-isi">
                                <label class="form-label-isi">
                                    <i class="bi bi-card-text"></i> Description
                                </label>
                                <textarea
                                    name="description"
                                    class="form-control-isi textarea {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description', $produit->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-msg">
                                        <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Image URL --}}
                        <div class="col-12">
                            <div class="form-group-isi">
                                <label class="form-label-isi">
                                    <i class="bi bi-image-fill"></i> URL de l'image
                                </label>
                                <input
                                    type="url"
                                    name="image"
                                    id="imageUrl"
                                    value="{{ old('image', $produit->image) }}"
                                    class="form-control-isi {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                    placeholder="https://exemple.com/burger.jpg">
                                @error('image')
                                    <div class="invalid-msg">
                                        <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                    </div>
                                @enderror
                                @if($produit->image)
                                <div class="preview-box" id="previewBox">
                                    <img id="previewImg" src="{{ $produit->image }}" alt="Aperçu">
                                </div>
                                @else
                                <div class="preview-box" id="previewBox" style="display:none;">
                                    <img id="previewImg" src="" alt="Aperçu">
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Archiver --}}
                        <div class="col-12">
                            <label class="toggle-check">
                                <span class="toggle-check-label">
                                    <i class="bi bi-archive-fill"></i>
                                    Archiver ce burger
                                    <small style="color:var(--gray-400);font-weight:400;font-size:0.78rem;">
                                        (ne sera plus visible dans le catalogue)
                                    </small>
                                </span>
                                <input
                                    type="checkbox"
                                    name="archive"
                                    value="1"
                                    class="form-check-input form-check-input-lg"
                                    {{ old('archive', $produit->archive) ? 'checked' : '' }}>
                            </label>
                        </div>

                    </div>

                    <div class="form-footer">
                        <a href="{{ route('admin.produits.index') }}" class="btn-isi-outline">
                            <i class="bi bi-x-lg"></i> Annuler
                        </a>
                        <button type="submit" class="btn-isi-yellow">
                            <i class="bi bi-check-lg"></i> Mettre à jour
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const imageUrl   = document.getElementById('imageUrl');
    const previewBox = document.getElementById('previewBox');
    const previewImg = document.getElementById('previewImg');

    imageUrl.addEventListener('input', function () {
        const url = this.value.trim();
        if (url) {
            previewImg.src = url;
            previewBox.style.display = 'block';
        } else {
            previewBox.style.display = 'none';
        }
    });
</script>
@endpush

@endsection
