<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER — @yield('title', 'Connexion')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --blue-900:   #0a2a6e;
            --blue-800:   #0d3a9e;
            --blue:       #0d6efd;
            --blue-light: #e8f0fe;
            --yellow:     #ffc107;
            --yellow-dark:#e6a800;
            --gold:       #f59e0b;
            --gray-50:    #f9fafb;
            --gray-100:   #f3f4f6;
            --gray-200:   #e5e7eb;
            --gray-400:   #9ca3af;
            --gray-600:   #4b5563;
            --gray-700:   #374151;
            --gray-900:   #111827;
            --danger:     #dc2626;
            --danger-light: #fee2e2;
            --success:    #16a34a;
            --success-light: #dcfce7;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--gray-50);
            min-height: 100vh;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* ── PANNEAU GAUCHE ── */
        .auth-left {
            flex: 1;
            background: linear-gradient(160deg, var(--blue-900) 0%, #0f1e4a 60%, var(--blue-800) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        .deco-circle {
            position: absolute;
            border-radius: 50%;
            background: var(--yellow);
            opacity: 0.06;
        }

        .deco-circle-1 { width: 420px; height: 420px; top: -120px; right: -100px; }
        .deco-circle-2 { width: 260px; height: 260px; bottom: -80px; left: -60px; }
        .deco-circle-3 { width: 160px; height: 160px; top: 50%; left: 40%; opacity: 0.03; }

        .auth-brand {
            position: relative;
            z-index: 2;
            margin-bottom: 48px;
        }

        .auth-brand-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--blue-900);
            box-shadow: 0 8px 24px rgba(255,193,7,0.4);
            margin-bottom: 18px;
        }

        .auth-brand-name {
            font-size: 1.6rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
            display: block;
            line-height: 1.1;
        }

        .auth-brand-sub {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.45);
            display: block;
            margin-top: 4px;
            font-weight: 500;
        }

        .auth-headline {
            position: relative;
            z-index: 2;
            margin-bottom: 44px;
        }

        .auth-headline h2 {
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
            line-height: 1.25;
            letter-spacing: -0.8px;
            margin-bottom: 14px;
        }

        .auth-headline h2 span { color: var(--yellow); }

        .auth-headline p {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.6);
            line-height: 1.7;
            max-width: 360px;
        }

        .auth-stats {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 14px;
            width: 100%;
            max-width: 360px;
        }

        .auth-stat-item {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 14px 18px;
            backdrop-filter: blur(8px);
            transition: all 0.25s;
        }

        .auth-stat-item:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,193,7,0.2);
        }

        .auth-stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .auth-stat-icon.yellow { background: rgba(255,193,7,0.2); color: var(--yellow); }
        .auth-stat-icon.blue   { background: rgba(13,110,253,0.25); color: #60a5fa; }
        .auth-stat-icon.green  { background: rgba(22,163,74,0.2); color: #4ade80; }

        .auth-stat-num {
            font-size: 1.3rem;
            font-weight: 800;
            color: white;
            line-height: 1;
            display: block;
        }

        .auth-stat-label {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.5);
            display: block;
            margin-top: 2px;
            font-weight: 500;
        }

        /* ── PANNEAU DROIT ── */
        .auth-right {
            width: 500px;
            flex-shrink: 0;
            background: var(--gray-50);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px 48px;
            position: relative;
            animation: fadeInUp 0.5s ease;
        }

        .btn-back-auth {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            padding: 8px 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-600);
            cursor: pointer;
            transition: all 0.25s;
            margin-bottom: 36px;
            text-decoration: none;
            width: fit-content;
        }

        .btn-back-auth:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-light);
            transform: translateX(-3px);
        }

        .auth-form-header {
            margin-bottom: 32px;
        }

        .auth-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            color: var(--blue-900);
            font-size: 0.72rem;
            font-weight: 800;
            padding: 4px 14px;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 14px;
        }

        .auth-form-header h1 {
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--gray-900);
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .auth-form-header p {
            font-size: 0.875rem;
            color: var(--gray-400);
            margin: 0;
            font-weight: 400;
        }

        @media (max-width: 900px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; padding: 40px 28px; }
        }

        @media (max-width: 480px) {
            .auth-right { padding: 28px 20px; }
            .auth-form-header h1 { font-size: 1.5rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="auth-container">

    {{-- ── PANNEAU GAUCHE ── --}}
    <div class="auth-left">
        <div class="deco-circle deco-circle-1"></div>
        <div class="deco-circle deco-circle-2"></div>
        <div class="deco-circle deco-circle-3"></div>

        <div class="auth-brand">
            <div class="auth-brand-icon">
                <i class="bi bi-egg-fried"></i>
            </div>
            <span class="auth-brand-name">ISI BURGER</span>
            <span class="auth-brand-sub">Restaurant · Dakar, Sénégal</span>
        </div>

        <div class="auth-headline">
            <h2>
                Gérez votre restaurant<br>
                avec <span>efficacité</span>
            </h2>
            <p>
                Accédez à votre espace de gestion pour suivre
                vos produits, commandes et paiements en temps réel.
            </p>
        </div>

        <div class="auth-stats">
            <div class="auth-stat-item">
                <div class="auth-stat-icon yellow">
                    <i class="bi bi-egg-fried"></i>
                </div>
                <div>
                    <span class="auth-stat-num">10+</span>
                    <span class="auth-stat-label">Burgers au catalogue</span>
                </div>
            </div>
            <div class="auth-stat-item">
                <div class="auth-stat-icon blue">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>
                <div>
                    <span class="auth-stat-num">∞</span>
                    <span class="auth-stat-label">Commandes gérées</span>
                </div>
            </div>
            <div class="auth-stat-item">
                <div class="auth-stat-icon green">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div>
                    <span class="auth-stat-num">100%</span>
                    <span class="auth-stat-label">Suivi en temps réel</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── PANNEAU DROIT ── --}}
    <div class="auth-right">
        <a href="{{ route('catalogue.index') }}" class="btn-back-auth">
            <i class="bi bi-arrow-left"></i>
            Retour au catalogue
        </a>

        <div class="auth-form-header">
            <div class="auth-badge">
                <i class="bi bi-shield-check-fill"></i>
                Espace sécurisé
            </div>
            @yield('auth-title')
        </div>

        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
