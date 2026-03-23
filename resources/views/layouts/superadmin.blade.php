<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER — Administration</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --blue-900: #0a2a6e;
            --blue-800: #0d3a9e;
            --yellow: #ffc107;
            --gold: #f59e0b;
            --danger: #dc2626;
            --danger-light: #fee2e2;
            --success: #16a34a;
            --success-light: #dcfce7;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-400: #9ca3af;
            --gray-700: #374151;
            --gray-900: #111827;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f3f4f6; }

        .sa-navbar {
            background: linear-gradient(90deg, #1a1a2e, #16213e);
            border-bottom: 3px solid var(--yellow);
            padding: 0.75rem 0;
        }
        .sa-brand {
            display: flex; align-items: center; gap: 12px; text-decoration: none;
        }
        .sa-brand-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; color: #1a1a2e;
        }
        .sa-brand-name { font-size: 1.1rem; font-weight: 800; color: white; display: block; }
        .sa-brand-sub  { font-size: 0.65rem; color: rgba(255,255,255,0.4); display: block; }

        .sa-user-btn {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            color: white;
            border-radius: 10px;
            padding: 7px 14px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex; align-items: center; gap: 8px;
        }
        .sa-avatar {
            width: 30px; height: 30px; border-radius: 8px;
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            color: #1a1a2e;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem; font-weight: 800;
        }

        .alert-isi {
            border: none; border-radius: 12px; font-size: 0.875rem;
            font-weight: 600; display: flex; align-items: center;
            gap: 10px; padding: 12px 16px;
        }
        .alert-isi-success { background: var(--success-light); color: var(--success); border-left: 4px solid var(--success); }
        .alert-isi-danger  { background: var(--danger-light);  color: var(--danger);  border-left: 4px solid var(--danger); }

        .btn-isi-yellow {
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            color: var(--blue-900); border: none; border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800;
            padding: 10px 20px; font-size: 0.875rem; transition: all 0.25s;
            display: inline-flex; align-items: center; gap: 7px;
            text-decoration: none;
        }
        .btn-isi-outline {
            background: transparent; border: 2px solid var(--gray-200);
            color: var(--gray-700); border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
            padding: 9px 18px; font-size: 0.875rem; transition: all 0.25s;
            display: inline-flex; align-items: center; gap: 7px;
            text-decoration: none;
        }
        .page-header-isi {
            display: flex; justify-content: space-between;
            align-items: flex-start; margin-bottom: 28px;
        }
        .page-title-isi {
            font-size: 1.6rem; font-weight: 800; color: var(--gray-900);
            margin: 0 0 4px; letter-spacing: -0.5px;
            display: flex; align-items: center; gap: 10px;
        }
        .page-title-isi i { color: var(--yellow); }
        .page-subtitle-isi { font-size: 0.875rem; color: var(--gray-400); margin: 0; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .footer-sa {
            background: #1a1a2e;
            border-top: 3px solid var(--yellow);
            color: rgba(255,255,255,0.4);
            padding: 14px 0;
            margin-top: 60px;
            font-size: 0.78rem;
            text-align: center;
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="sa-navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('superadmin.users.index') }}" class="sa-brand">
            <div class="sa-brand-icon"><i class="bi bi-shield-lock-fill"></i></div>
            <div>
                <span class="sa-brand-name">ISI BURGER</span>
                <span class="sa-brand-sub">Espace Administrateur</span>
            </div>
        </a>
        <div class="dropdown">
            <button class="sa-user-btn dropdown-toggle" data-bs-toggle="dropdown">
                <div class="sa-avatar">AD</div>
                <span>{{ Auth::user()->name }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="border-radius:12px;border:none;box-shadow:0 10px 40px rgba(0,0,0,0.15);padding:8px;">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item" style="border-radius:8px;color:#dc2626;font-weight:600;">
                            <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- ALERTS --}}
<div class="container mt-3">
    @if(session('success'))
        <div class="alert-isi alert-isi-success alert-dismissible fade show mb-3">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-isi alert-isi-danger alert-dismissible fade show mb-3">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

{{-- CONTENT --}}
<main class="container my-4">
    @yield('content')
</main>

<footer class="footer-sa">
    © {{ date('Y') }} ISI BURGER — Espace Administration
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
