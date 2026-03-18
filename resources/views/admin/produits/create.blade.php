@extends('layouts.app')

@section('title', 'Ajouter un burger')

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
        display: flex;
        align-items: center;
        gap: 12px;
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
        display: none;
        margin-top: 10px;
        border: 2px solid var(--gray-200);
    }
    .preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .preview-box.visible { display: block; }

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

<div style="display:flex;align-items:center;gap:8px;margin-bottom:24px;font-size:0.85rem;">
    <a href="{{ route('admin.produits.index') }}"
       style="color:var(--blue);text-decoration:none;font-weight:600;display:flex;align-items:center;gap:5px;">
        <i class="bi bi-box-seam-fill"></i> Produits
    </a>
    <span style="color:var(--gray-300);">/</span>
    <span style="color:var(--gray-400);font-weight:500;">Ajouter un burger</span>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="form-card-header">
                <h5><i class="bi bi-plus-circle-fill"></i> Ajouter un nouveau burger</h5>
            </div>
            <div class="form-card-body">
                <form method="POST" action="{{ route('admin.produits.store') }}"
                        enctype="multipart/form-data">
                    @csrf

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
                                    value="{{ old('nom') }}"
                                    class="form-control-isi {{ $errors->has('nom') ? 'is-invalid' : '' }}"
                                    placeholder="Ex : Classic Burger"
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
                                    value="{{ old('prix') }}"
                                    class="form-control-isi {{ $errors->has('prix') ? 'is-invalid' : '' }}"
                                    placeholder="Ex : 3500"
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
                                    <i class="bi bi-layers-fill"></i> Stock initial <span class="req">*</span>
                                </label>
                                <input
                                    type="number"
                                    name="stock"
                                    value="{{ old('stock', 0) }}"
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
                                    class="form-control-isi textarea {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                    placeholder="Ingrédients, description du burger...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-msg">
                                        <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="col-12">
                            <div class="form-group-isi">
                                <label class="form-label-isi">
                                    <i class="bi bi-image-fill"></i> Image du burger
                                </label>

                                {{-- Tabs URL / Upload --}}
                                <div style="display:flex;gap:8px;margin-bottom:10px;">
                                    <button type="button" class="tab-img-btn active" id="tabUrl"
                                            onclick="switchTab('url')"
                                            style="flex:1;padding:8px;border-radius:8px;border:2px solid var(--blue);
                                                background:var(--blue-light);color:var(--blue);font-weight:700;
                                                font-family:'Plus Jakarta Sans',sans-serif;font-size:0.82rem;cursor:pointer;">
                                        <i class="bi bi-link-45deg"></i> URL en ligne
                                    </button>
                                    <button type="button" class="tab-img-btn" id="tabFile"
                                            onclick="switchTab('file')"
                                            style="flex:1;padding:8px;border-radius:8px;border:2px solid var(--gray-200);
                                                background:white;color:var(--gray-600);font-weight:700;
                                                font-family:'Plus Jakarta Sans',sans-serif;font-size:0.82rem;cursor:pointer;">
                                        <i class="bi bi-upload"></i> Depuis mon PC
                                    </button>
                                </div>

                                {{-- Zone URL --}}
                                <div id="zoneUrl">
                                    <input type="url" name="image_url" id="imageUrl"
                                        value="{{ old('image_url') }}"
                                        class="form-control-isi {{ $errors->has('image_url') ? 'is-invalid' : '' }}"
                                        placeholder="https://exemple.com/burger.jpg">
                                    @error('image_url')
                                        <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Zone Upload --}}
                                <div id="zoneFile" style="display:none;">
                                    <label for="imageFile"
                                        style="display:flex;flex-direction:column;align-items:center;justify-content:center;
                                                border:2px dashed var(--gray-200);border-radius:12px;padding:28px;
                                                cursor:pointer;transition:all 0.2s;background:var(--gray-50);"
                                        id="dropZone">
                                        <i class="bi bi-cloud-arrow-up-fill"
                                        style="font-size:2rem;color:var(--blue);margin-bottom:8px;"></i>
                                        <span style="font-size:0.85rem;font-weight:700;color:var(--gray-700);">
                                            Cliquez ou glissez une image ici
                                        </span>
                                        <span style="font-size:0.75rem;color:var(--gray-400);margin-top:4px;">
                                            JPG, PNG, WEBP — max 2 Mo
                                        </span>
                                    </label>
                                    <input type="file" name="image_file" id="imageFile"
                                        accept="image/jpeg,image/png,image/jpg,image/webp"
                                        style="display:none;">
                                    @error('image_file')
                                        <div class="invalid-msg"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Aperçu commun --}}
                                <div class="preview-box {{ old('image_url') ? 'visible' : '' }}" id="previewBox"
                                    style="margin-top:10px;">
                                    <img id="previewImg" src="{{ old('image_url', '') }}" alt="Aperçu"
                                        style="width:100%;height:160px;object-fit:cover;border-radius:10px;">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-footer">
                        <a href="{{ route('admin.produits.index') }}" class="btn-isi-outline">
                            <i class="bi bi-x-lg"></i> Annuler
                        </a>
                        <button type="submit" class="btn-isi-yellow">
                            <i class="bi bi-check-lg"></i> Enregistrer le burger
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchTab(tab) {
        const zoneUrl  = document.getElementById('zoneUrl');
        const zoneFile = document.getElementById('zoneFile');
        const tabUrl   = document.getElementById('tabUrl');
        const tabFile  = document.getElementById('tabFile');

        if (tab === 'url') {
            zoneUrl.style.display  = 'block';
            zoneFile.style.display = 'none';
            tabUrl.style.border    = '2px solid var(--blue)';
            tabUrl.style.background = 'var(--blue-light)';
            tabUrl.style.color     = 'var(--blue)';
            tabFile.style.border   = '2px solid var(--gray-200)';
            tabFile.style.background = 'white';
            tabFile.style.color    = 'var(--gray-600)';
        } else {
            zoneUrl.style.display  = 'none';
            zoneFile.style.display = 'block';
            tabFile.style.border   = '2px solid var(--blue)';
            tabFile.style.background = 'var(--blue-light)';
            tabFile.style.color    = 'var(--blue)';
            tabUrl.style.border    = '2px solid var(--gray-200)';
            tabUrl.style.background = 'white';
            tabUrl.style.color     = 'var(--gray-600)';
        }
    }

    document.getElementById('imageUrl')?.addEventListener('input', function () {
        const url = this.value.trim();
        const box = document.getElementById('previewBox');
        const img = document.getElementById('previewImg');
        if (url) {
            img.src = url;
            box.classList.add('visible');
        } else {
            box.classList.remove('visible');
        }
    });

    document.getElementById('imageFile')?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.getElementById('previewImg');
            const box = document.getElementById('previewBox');
            img.src = e.target.result;
            box.classList.add('visible');
        };
        reader.readAsDataURL(file);
    });

    document.getElementById('dropZone')?.addEventListener('click', function () {
        document.getElementById('imageFile').click();
    });

</script>
@endpush

@endsection
