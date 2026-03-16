<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER — @yield('title', 'Accueil')</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1A1A1A;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#" style="color: #D4530A; font-size: 1.5rem; letter-spacing: 1px;">
            🍔 ISI BURGER
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">

                @role('Gestionnaire')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.produits.*') ? 'active' : '' }}"
                       href="{{ route('admin.produits.index') }}">
                        Produits
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.commandes.*') ? 'active' : '' }}"
                       href="{{ route('admin.commandes.index') }}">
                        Commandes
                    </a>
                </li>
                @endrole

                @role('Client')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('catalogue.*') ? 'active' : '' }}"
                       href="{{ route('catalogue.index') }}">
                        Catalogue
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('commandes.*') ? 'active' : '' }}"
                       href="{{ route('commandes.index') }}">
                        Mes commandes
                    </a>
                </li>
                @endrole

            </ul>

            {{-- USER MENU --}}
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        👤 {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <span class="dropdown-item-text text-muted" style="font-size: 12px;">
                                {{ Auth::user()->getRoleNames()->first() }}
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- MESSAGES FLASH --}}
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

{{-- CONTENU --}}
<main class="container my-4">
    @yield('content')
</main>

{{-- FOOTER --}}
<footer style="background-color: #1A1A1A; color: #FFFFFF;" class="mt-5 py-3">
    <div class="container text-center">
        <span style="color: #D4530A; font-weight: bold;">ISI BURGER</span>
        <span class="text-muted ms-2" style="font-size: 13px;">— Tous droits réservés {{ date('Y') }}</span>
    </div>
</footer>

</body>
</html>
