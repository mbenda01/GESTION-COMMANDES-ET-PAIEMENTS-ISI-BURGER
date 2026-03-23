@extends('layouts.superadmin')

@section('content')

<div style="display:flex;align-items:center;gap:8px;margin-bottom:24px;font-size:0.85rem;">
    <a href="{{ route('superadmin.users.index') }}" style="color:#0d6efd;text-decoration:none;font-weight:600;">
        <i class="bi bi-people-fill"></i> Utilisateurs
    </a>
    <span style="color:#d1d5db;">/</span>
    <span style="color:#9ca3af;">Ajouter</span>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div style="background:white;border-radius:20px;border:1.5px solid #f3f4f6;box-shadow:0 4px 20px rgba(0,0,0,0.06);overflow:hidden;">
            <div style="background:linear-gradient(90deg,#1a1a2e,#16213e);padding:20px 28px;">
                <h5 style="margin:0;font-size:1rem;font-weight:800;color:white;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-person-plus-fill" style="color:#ffc107;"></i>
                    Ajouter un utilisateur
                </h5>
            </div>
            <div style="padding:28px;">
                <form method="POST" action="{{ route('superadmin.users.store') }}">
                    @csrf

                    @foreach([
                        ['name'=>'name',  'label'=>'Nom complet',  'icon'=>'bi-person',   'type'=>'text',  'placeholder'=>'Ex: Amadou Diallo'],
                        ['name'=>'email', 'label'=>'Email',         'icon'=>'bi-envelope', 'type'=>'email', 'placeholder'=>'email@exemple.com'],
                    ] as $field)
                    <div style="margin-bottom:20px;">
                        <label style="font-size:0.82rem;font-weight:700;color:#374151;margin-bottom:7px;display:flex;align-items:center;gap:6px;">
                            <i class="bi {{ $field['icon'] }}" style="color:#0d6efd;"></i>
                            {{ $field['label'] }} <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                               value="{{ old($field['name']) }}"
                               placeholder="{{ $field['placeholder'] }}"
                               style="width:100%;padding:11px 14px;border:2px solid #e5e7eb;border-radius:11px;font-family:'Plus Jakarta Sans',sans-serif;font-size:0.875rem;outline:none;"
                               required>
                        @error($field['name'])
                            <div style="font-size:0.78rem;color:#dc2626;font-weight:600;margin-top:5px;">{{ $message }}</div>
                        @enderror
                    </div>
                    @endforeach

                    <div style="margin-bottom:20px;">
                        <label style="font-size:0.82rem;font-weight:700;color:#374151;margin-bottom:7px;display:flex;align-items:center;gap:6px;">
                            <i class="bi bi-shield" style="color:#0d6efd;"></i> Rôle <span style="color:#dc2626;">*</span>
                        </label>
                        <select name="role" style="width:100%;padding:11px 14px;border:2px solid #e5e7eb;border-radius:11px;font-family:'Plus Jakarta Sans',sans-serif;font-size:0.875rem;outline:none;background:white;cursor:pointer;" required>
                            <option value="">-- Choisir --</option>
                            <option value="Client"       {{ old('role')==='Client'       ? 'selected' : '' }}>Client</option>
                            <option value="Gestionnaire" {{ old('role')==='Gestionnaire' ? 'selected' : '' }}>Gestionnaire</option>
                        </select>
                        @error('role')
                            <div style="font-size:0.78rem;color:#dc2626;font-weight:600;margin-top:5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    @foreach([
                        ['name'=>'password',              'label'=>'Mot de passe',         'placeholder'=>'Minimum 8 caractères'],
                        ['name'=>'password_confirmation', 'label'=>'Confirmer le mot de passe','placeholder'=>'Répétez le mot de passe'],
                    ] as $field)
                    <div style="margin-bottom:20px;">
                        <label style="font-size:0.82rem;font-weight:700;color:#374151;margin-bottom:7px;display:flex;align-items:center;gap:6px;">
                            <i class="bi bi-lock" style="color:#0d6efd;"></i>
                            {{ $field['label'] }} <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="password" name="{{ $field['name'] }}"
                               placeholder="{{ $field['placeholder'] }}"
                               style="width:100%;padding:11px 14px;border:2px solid #e5e7eb;border-radius:11px;font-family:'Plus Jakarta Sans',sans-serif;font-size:0.875rem;outline:none;"
                               required>
                        @error($field['name'])
                            <div style="font-size:0.78rem;color:#dc2626;font-weight:600;margin-top:5px;">{{ $message }}</div>
                        @enderror
                    </div>
                    @endforeach

                    <div style="display:flex;justify-content:flex-end;gap:12px;padding-top:20px;border-top:1.5px solid #f3f4f6;">
                        <a href="{{ route('superadmin.users.index') }}" class="btn-isi-outline">
                            <i class="bi bi-x-lg"></i> Annuler
                        </a>
                        <button type="submit" class="btn-isi-yellow">
                            <i class="bi bi-check-lg"></i> Créer l'utilisateur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
