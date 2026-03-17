@extends('layouts.guest')

@section('title', 'Connexion Gestionnaire')

@section('auth-title')
    <h1>Connexion</h1>
    <p>Entrez vos identifiants pour accéder à votre espace de gestion</p>
@endsection

@section('content')

@push('styles')
<style>
    .form-group-auth { margin-bottom: 20px; }

    .form-label-auth {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--gray-700);
        margin-bottom: 8px;
    }

    .form-label-auth i { color: var(--blue); font-size: 0.9rem; }

    .input-wrapper-auth { position: relative; }

    .form-control-auth {
        width: 100%;
        padding: 13px 16px;
        background: white;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.95rem;
        color: var(--gray-900);
        transition: all 0.25s;
        outline: none;
    }

    .form-control-auth::placeholder { color: var(--gray-400); }

    .form-control-auth:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 4px rgba(13,110,253,0.1);
    }

    .form-control-auth.is-invalid {
        border-color: var(--danger);
    }

    .form-control-auth.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220,38,38,0.1);
    }

    .form-control-password { padding-right: 50px; }

    .password-toggle-btn {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--gray-400);
        font-size: 1.1rem;
        cursor: pointer;
        padding: 4px;
        line-height: 1;
        transition: color 0.2s;
    }

    .password-toggle-btn:hover { color: var(--blue); }

    .invalid-feedback-auth {
        display: flex;
        align-items: center;
        gap: 5px;
        color: var(--danger);
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 6px;
    }

    .alert-auth-error {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--danger-light);
        color: var(--danger);
        border-radius: 12px;
        padding: 13px 16px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 24px;
        border: 1px solid rgba(220,38,38,0.2);
        animation: fadeInUp 0.3s ease;
    }

    .forgot-link {
        text-align: right;
        margin-bottom: 24px;
        margin-top: -8px;
    }

    .forgot-link a {
        color: var(--blue);
        text-decoration: none;
        font-size: 0.82rem;
        font-weight: 600;
        transition: color 0.2s;
    }

    .forgot-link a:hover {
        color: var(--blue-800);
        text-decoration: underline;
    }

    .btn-submit-auth {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, var(--blue-900), var(--blue-800));
        color: white;
        border: none;
        border-radius: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 6px 20px rgba(10,42,110,0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-submit-auth::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--yellow), var(--gold));
        opacity: 0;
        transition: opacity 0.3s;
    }

    .btn-submit-auth:hover::after { opacity: 1; }

    .btn-submit-auth:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(10,42,110,0.4);
        color: var(--blue-900);
    }

    .btn-submit-auth .btn-inner {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-submit-auth:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .divider-auth {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 24px 0;
    }

    .divider-auth::before,
    .divider-auth::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--gray-200);
    }

    .divider-auth span {
        font-size: 0.75rem;
        color: var(--gray-400);
        font-weight: 600;
        white-space: nowrap;
    }

    .credentials-box {
        background: white;
        border-radius: 14px;
        border: 2px dashed var(--gray-200);
        overflow: hidden;
    }

    .credentials-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 16px;
        background: linear-gradient(135deg, var(--blue-light), #fff8e1);
        border-bottom: 1px solid var(--gray-200);
    }

    .credentials-header i { color: var(--gold); font-size: 1rem; }

    .credentials-header span {
        font-size: 0.78rem;
        font-weight: 800;
        color: var(--gray-700);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .credentials-list {
        padding: 10px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .credential-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        background: var(--gray-50);
        border-radius: 8px;
        border: 1px solid var(--gray-100);
        cursor: pointer;
        transition: all 0.2s;
    }

    .credential-item:hover {
        background: var(--blue-light);
        border-color: var(--blue);
    }

    .cred-avatar {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: linear-gradient(135deg, var(--blue-900), var(--blue-800));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .cred-email {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--gray-900);
        display: block;
    }

    .cred-pass {
        font-size: 0.72rem;
        color: var(--gray-400);
        display: block;
    }

    .spinner-sm {
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
        display: inline-block;
    }

    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush

@if ($errors->any())
    <div class="alert-auth-error">
        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
        <span>{{ $errors->first() }}</span>
    </div>
@endif

@if (session('status'))
    <div class="alert-auth-error" style="background: var(--success-light); color: var(--success); border-color: rgba(22,163,74,0.2);">
        <i class="bi bi-check-circle-fill fs-5"></i>
        <span>{{ session('status') }}</span>
    </div>
@endif

<form method="POST" action="{{ route('login') }}" id="loginForm">
    @csrf

    {{-- Email --}}
    <div class="form-group-auth">
        <label class="form-label-auth" for="email">
            <i class="bi bi-envelope-fill"></i>
            Adresse email
        </label>
        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            class="form-control-auth {{ $errors->has('email') ? 'is-invalid' : '' }}"
            placeholder="admin@isiburger.com"
            required
            autofocus
            autocomplete="email">
        @error('email')
            <div class="invalid-feedback-auth">
                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Mot de passe --}}
    <div class="form-group-auth">
        <label class="form-label-auth" for="password">
            <i class="bi bi-lock-fill"></i>
            Mot de passe
        </label>
        <div class="input-wrapper-auth">
            <input
                type="password"
                id="password"
                name="password"
                class="form-control-auth form-control-password {{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="••••••••"
                required
                autocomplete="current-password">
            <button type="button" class="password-toggle-btn" id="togglePassword">
                <i class="bi bi-eye-fill" id="toggleIcon"></i>
            </button>
        </div>
        @error('password')
            <div class="invalid-feedback-auth">
                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Remember + Forgot --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember"
                   style="font-size: 0.82rem; color: var(--gray-600); font-weight: 500;">
                Se souvenir de moi
            </label>
        </div>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
               style="color: var(--blue); text-decoration: none; font-size: 0.82rem; font-weight: 600;">
                <i class="bi bi-question-circle me-1"></i>Mot de passe oublié ?
            </a>
        @endif
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn-submit-auth" id="btnSubmit">
        <span class="btn-inner">
            <i class="bi bi-box-arrow-in-right"></i>
            Se connecter
        </span>
    </button>

</form>

{{-- Credentials de test --}}
<div class="divider-auth">
    <span>Identifiants de test</span>
</div>

<div class="credentials-box">
    <div class="credentials-header">
        <i class="bi bi-info-circle-fill"></i>
        <span>Comptes disponibles</span>
    </div>
    <div class="credentials-list">
        <div class="credential-item" onclick="fillCredentials('admin@isiburger.com', 'password')">
            <div class="cred-avatar">AD</div>
            <div>
                <span class="cred-email">admin@isiburger.com</span>
                <span class="cred-pass">Mot de passe : password</span>
            </div>
            <i class="bi bi-arrow-right-circle ms-auto" style="color: var(--blue); font-size: 1rem;"></i>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const toggleBtn  = document.getElementById('togglePassword');
    const passInput  = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    toggleBtn.addEventListener('click', function () {
        const isPassword = passInput.type === 'password';
        passInput.type   = isPassword ? 'text' : 'password';
        toggleIcon.className = isPassword ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
    });

    function fillCredentials(email, password) {
        document.getElementById('email').value    = email;
        document.getElementById('password').value = password;
        document.getElementById('email').focus();
    }

    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn  = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<span class="btn-inner">
            <span class="spinner-sm"></span> Connexion en cours...
        </span>`;
    });
</script>
@endpush

@endsection
