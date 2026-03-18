<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER — @yield('title', 'Accueil')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --blue-900: #0a2a6e;
            --blue-800: #0d3a9e;
            --blue:     #0d6efd;
            --blue-light: #e8f0fe;
            --yellow:   #ffc107;
            --yellow-dark: #e6a800;
            --gold:     #f59e0b;
            --white:    #ffffff;
            --gray-50:  #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-400: #9ca3af;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;
            --success:  #16a34a;
            --success-light: #dcfce7;
            --danger:   #dc2626;
            --danger-light: #fee2e2;
            --warning:  #d97706;
            --warning-light: #fef3c7;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-900);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .fade-in { animation: fadeInUp 0.4s ease both; }

        .navbar-isi {
            background: linear-gradient(90deg, var(--blue-900) 0%, #0f1e4a 100%);
            border-bottom: 3px solid var(--yellow);
            padding: 0.75rem 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .navbar-brand-isi {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--blue-900);
            box-shadow: 0 4px 12px rgba(255,193,7,0.4);
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 1.3rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.3px;
            display: block;
            line-height: 1.1;
        }

        .brand-sub {
            font-size: 0.65rem;
            color: rgba(255,255,255,0.5);
            font-weight: 500;
            display: block;
        }

        .nav-link-isi {
            color: rgba(255,255,255,0.75) !important;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 8px 14px !important;
            border-radius: 8px;
            transition: all 0.25s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link-isi:hover,
        .nav-link-isi.active {
            background: rgba(255,255,255,0.1);
            color: var(--yellow) !important;
        }

        .nav-link-isi i { font-size: 1rem; }

        .btn-login-nav {
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            color: var(--blue-900) !important;
            font-weight: 800 !important;
            border-radius: 10px !important;
            padding: 8px 18px !important;
            font-size: 0.88rem !important;
            box-shadow: 0 4px 12px rgba(255,193,7,0.35);
            transition: all 0.25s !important;
        }

        .btn-login-nav:hover {
            background: linear-gradient(135deg, var(--yellow-dark), #d97706) !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(255,193,7,0.45) !important;
        }

        .user-dropdown-btn {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            color: white !important;
            border-radius: 10px;
            padding: 7px 14px !important;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s;
        }

        .user-dropdown-btn:hover {
            background: rgba(255,255,255,0.15);
        }

        .user-avatar-sm {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            color: var(--blue-900);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .dropdown-menu-dark-isi {
            background: #0f1e4a;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            min-width: 200px;
        }

        .dropdown-menu-dark-isi .dropdown-item {
            color: rgba(255,255,255,0.75);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .dropdown-menu-dark-isi .dropdown-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .dropdown-menu-dark-isi .dropdown-item.text-danger-soft {
            color: #f87171;
        }

        .dropdown-menu-dark-isi .dropdown-item.text-danger-soft:hover {
            background: rgba(220,38,38,0.2);
            color: #fca5a5;
        }

        .dropdown-menu-dark-isi .dropdown-divider {
            border-color: rgba(255,255,255,0.1);
            margin: 6px 0;
        }

        .role-badge-nav {
            font-size: 0.65rem;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 999px;
            background: rgba(255,193,7,0.2);
            color: var(--yellow);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ── ALERTS ── */
        .alert-isi {
            border: none;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            animation: fadeInUp 0.3s ease;
        }

        .alert-isi-success {
            background: var(--success-light);
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        .alert-isi-danger {
            background: var(--danger-light);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        .alert-isi-info {
            background: var(--blue-light);
            color: var(--blue);
            border-left: 4px solid var(--blue);
        }

        .alert-isi-warning {
            background: var(--warning-light);
            color: var(--warning);
            border-left: 4px solid var(--warning);
        }

        .card-isi {
            background: white;
            border-radius: 16px;
            border: 1.5px solid var(--gray-100);
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }

        .card-isi:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(10,42,110,0.12);
        }

        .badge-statut {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 800;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .badge-en_attente     { background: #fff3e0; color: #e65100; }
        .badge-en_preparation { background: #fff8e1; color: #f57c00; }
        .badge-prete          { background: var(--success-light); color: var(--success); }
        .badge-payee          { background: #e8f5e9; color: #2e7d32; }
        .badge-annulee        { background: var(--danger-light); color: var(--danger); }

        .btn-isi-primary {
            background: linear-gradient(135deg, var(--blue-900), var(--blue-800));
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            padding: 10px 20px;
            font-size: 0.875rem;
            transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(10,42,110,0.25);
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .btn-isi-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(10,42,110,0.35);
            color: white;
        }

        .btn-isi-yellow {
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            color: var(--blue-900);
            border: none;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            padding: 10px 20px;
            font-size: 0.875rem;
            transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(255,193,7,0.35);
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .btn-isi-yellow:hover {
            background: linear-gradient(135deg, var(--yellow-dark), #d97706);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255,193,7,0.45);
            color: var(--blue-900);
        }

        .btn-isi-outline {
            background: transparent;
            border: 2px solid var(--gray-200);
            color: var(--gray-700);
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            padding: 9px 18px;
            font-size: 0.875rem;
            transition: all 0.25s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .btn-isi-outline:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-light);
        }

        .page-header-isi {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
        }

        .page-title-isi {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--gray-900);
            margin: 0 0 4px;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-title-isi i { color: var(--yellow); }

        .page-subtitle-isi {
            font-size: 0.875rem;
            color: var(--gray-400);
            margin: 0;
            font-weight: 400;
        }

        .table-isi {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .table-isi thead tr {
            background: linear-gradient(90deg, var(--blue-900), #0f1e4a);
        }

        .table-isi thead th {
            padding: 13px 16px;
            font-size: 0.72rem;
            font-weight: 800;
            color: rgba(255,255,255,0.8);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            text-align: left;
            white-space: nowrap;
        }

        .table-isi tbody tr {
            border-bottom: 1px solid var(--gray-100);
            transition: background 0.15s;
        }

        .table-isi tbody tr:last-child { border-bottom: none; }
        .table-isi tbody tr:hover { background: var(--gray-50); }

        .table-isi tbody td {
            padding: 13px 16px;
            font-size: 0.85rem;
            vertical-align: middle;
        }

        .table-wrapper-isi {
            background: white;
            border-radius: 16px;
            border: 1.5px solid var(--gray-100);
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .pagination-isi {
            display: flex;
            gap: 6px;
            align-items: center;
            justify-content: center;
            margin-top: 24px;
        }

        .pagination-isi .page-link {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 2px solid var(--gray-200);
            background: white;
            color: var(--gray-700);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            text-decoration: none;
        }

        .pagination-isi .page-link:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-light);
        }

        .pagination-isi .page-item.active .page-link {
            background: linear-gradient(135deg, var(--blue-900), var(--blue-800));
            border-color: var(--blue-900);
            color: white;
            box-shadow: 0 4px 10px rgba(10,42,110,0.25);
        }

        .pagination-isi .page-item.disabled .page-link {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .footer-isi {
            background: linear-gradient(160deg, var(--blue-900) 0%, #0f1e4a 100%);
            border-top: 3px solid var(--yellow);
            color: white;
            padding: 16px 0;
            margin-top: 60px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .footer-isi .brand-name-footer {
            color: var(--yellow);
            font-weight: 800;
            font-size: 1rem;
        }

        .footer-isi .footer-copy {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.45);
        }

        .price-isi {
            color: var(--blue-900);
            font-weight: 800;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .stock-ok      { background: var(--success-light); color: var(--success); }
        .stock-faible  { background: var(--warning-light); color: var(--warning); }
        .stock-rupture { background: var(--danger-light);  color: var(--danger); }

        .modal-isi .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 24px 80px rgba(0,0,0,0.2);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .modal-isi .modal-header {
            background: linear-gradient(135deg, var(--blue-900), var(--blue-800));
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 20px 24px;
            border: none;
        }

        .modal-isi .modal-title {
            font-weight: 800;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-isi .modal-title i { color: var(--yellow); }
        .modal-isi .btn-close { filter: invert(1); }
        .modal-isi .modal-body { padding: 24px; }
        .modal-isi .modal-footer { padding: 16px 24px 20px; border: none; }

        .form-label-isi {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--gray-700);
            margin-bottom: 6px;
        }

        .form-control-isi {
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            padding: 10px 14px;
            transition: all 0.25s;
        }

        .form-control-isi:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
        }

        .empty-state-isi {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-icon-isi {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, var(--blue-light), #fff8e1);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--blue);
            margin: 0 auto 20px;
        }

        .empty-state-isi h3 {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 8px;
        }

        .empty-state-isi p {
            color: var(--gray-400);
            font-size: 0.875rem;
            margin-bottom: 20px;
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- ── NAVBAR ── --}}
<nav class="navbar navbar-expand-lg navbar-isi">
    <div class="container">
        <a class="navbar-brand-isi" href="{{ route('catalogue.index') }}">
            <div class="brand-icon">
                <i class="bi bi-egg-fried"></i>
            </div>
            <div>
                <span class="brand-name">ISI BURGER</span>
                <span class="brand-sub">Restaurant · Dakar</span>
            </div>
        </a>

        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav"
                style="color: white;">
            <i class="bi bi-list" style="font-size: 1.5rem;"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto ms-4 gap-1">

                {{-- ✅ Catalogue : toujours visible pour tout le monde --}}
                <li class="nav-item">
                    <a class="nav-link-isi {{ request()->routeIs('catalogue.*') ? 'active' : '' }}"
                       href="{{ route('catalogue.index') }}">
                        <i class="bi bi-grid-3x3-gap-fill"></i> Catalogue
                    </a>
                </li>

                {{-- Mes commandes : visible uniquement pour les clients (non gestionnaire) --}}
                @if(!auth()->check() || !auth()->user()->hasRole('Gestionnaire'))
                <li class="nav-item">
                    <a class="nav-link-isi {{ request()->routeIs('commandes.*') ? 'active' : '' }}"
                       href="{{ route('commandes.index') }}">
                        <i class="bi bi-bag-fill"></i> Mes commandes
                    </a>
                </li>
                @endif

                {{-- Menu Gestionnaire : visible uniquement si connecté avec rôle Gestionnaire --}}
                @auth
                    @role('Gestionnaire')
                    <li class="nav-item">
                        <a class="nav-link-isi {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-isi {{ request()->routeIs('admin.produits.*') ? 'active' : '' }}"
                           href="{{ route('admin.produits.index') }}">
                            <i class="bi bi-box-seam-fill"></i> Produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-isi {{ request()->routeIs('admin.commandes.*') ? 'active' : '' }}"
                           href="{{ route('admin.commandes.index') }}">
                            <i class="bi bi-receipt"></i> Commandes
                        </a>
                    </li>
                    @endrole
                @endauth

            </ul>

            <ul class="navbar-nav ms-auto align-items-center gap-2">
                @auth
                    <li class="nav-item dropdown">
                        <button class="user-dropdown-btn dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark-isi">
                            <li>
                                <span class="dropdown-item-text d-flex align-items-center gap-2 pb-1">
                                    <span class="role-badge-nav">
                                        {{ Auth::user()->getRoleNames()->first() }}
                                    </span>
                                    <small style="color: rgba(255,255,255,0.45); font-size: 0.72rem;">
                                        {{ Auth::user()->email }}
                                    </small>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @role('Gestionnaire')
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            @endrole
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger-soft">
                                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link-isi btn-login-nav">
                            <i class="bi bi-shield-lock-fill"></i> Espace Gestionnaire
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- ── ALERTS ── --}}
<div class="container mt-3">
    @if(session('success'))
        <div class="alert-isi alert-isi-success alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-isi alert-isi-danger alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert-isi alert-isi-info alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-info-circle-fill fs-5"></i>
            <span>{{ session('info') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert-isi alert-isi-warning alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-exclamation-circle-fill fs-5"></i>
            <span>{{ session('warning') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

{{-- ── CONTENT ── --}}
<main class="container my-4 fade-in">
    @yield('content')
</main>

{{-- ── FOOTER ── --}}
<footer class="footer-isi">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <div class="brand-icon" style="width:32px; height:32px; font-size:1rem;">
                    <i class="bi bi-egg-fried"></i>
                </div>
                <span class="brand-name-footer">ISI BURGER</span>
            </div>
            <span class="footer-copy">
                © {{ date('Y') }} ISI BURGER — Tous droits réservés
            </span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
