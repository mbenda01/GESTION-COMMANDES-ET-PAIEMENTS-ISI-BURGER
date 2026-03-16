<x-guest-layout>
    <div class="card shadow-sm border-0" style="max-width: 440px; margin: 60px auto;">
        <div class="card-body p-4">

            <div class="text-center mb-4">
                <h2 style="color: #D4530A; font-weight: bold;">🍔 ISI BURGER</h2>
                <p class="text-muted">Connectez-vous à votre compte</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Adresse email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="email@exemple.com" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Mot de passe</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Votre mot de passe" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-amber btn-lg">
                        Se connecter
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('register') }}" class="text-decoration-none" style="color: #D4530A;">
                        Pas encore de compte ? S'inscrire
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
