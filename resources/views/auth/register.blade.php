<x-guest-layout>
    <div class="card shadow-sm border-0" style="max-width: 480px; margin: 60px auto;">
        <div class="card-body p-4">

            <div class="text-center mb-4">
                <h2 style="color: #D4530A; font-weight: bold;">🍔 ISI BURGER</h2>
                <p class="text-muted">Créer un compte</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nom --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Nom complet</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Votre nom" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Adresse email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="email@exemple.com" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Rôle --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Je suis</label>
                    <select name="role"
                            class="form-select @error('role') is-invalid @enderror" required>
                        <option value="">-- Choisir --</option>
                        <option value="Client"       {{ old('role') === 'Client'       ? 'selected' : '' }}>Client</option>
                        <option value="Gestionnaire" {{ old('role') === 'Gestionnaire' ? 'selected' : '' }}>Gestionnaire</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Mot de passe</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimum 8 caractères" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirmation --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation"
                           class="form-control" placeholder="Répétez le mot de passe" required>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-amber btn-lg">
                        Créer mon compte
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none" style="color: #D4530A;">
                        Déjà un compte ? Se connecter
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
