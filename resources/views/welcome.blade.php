<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER — Le meilleur burger de Dakar</title>

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
            --gray-50:  #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-400: #9ca3af;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;
            --success:  #16a34a;
            --danger:   #dc2626;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
        }

        html { scroll-behavior: smooth; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-10px); }
        }

        .navbar-welcome {
            background: linear-gradient(90deg, var(--blue-900) 0%, #0f1e4a 100%);
            border-bottom: 3px solid var(--yellow);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
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

        .nav-link-w {
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

        .nav-link-w:hover {
            background: rgba(255,255,255,0.1);
            color: var(--yellow) !important;
        }

        .btn-nav-login {
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            color: var(--blue-900) !important;
            font-weight: 800 !important;
            border-radius: 10px !important;
            padding: 8px 18px !important;
            font-size: 0.88rem !important;
            box-shadow: 0 4px 12px rgba(255,193,7,0.35);
            transition: all 0.25s !important;
        }

        .btn-nav-login:hover {
            background: linear-gradient(135deg, var(--yellow-dark), #d97706) !important;
            transform: translateY(-1px);
            color: var(--blue-900) !important;
        }

        .hero-section {
            background: linear-gradient(160deg, var(--blue-900) 0%, #0f1e4a 55%, var(--blue-800) 100%);
            position: relative;
            overflow: hidden;
            padding: 80px 0;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: rgba(255,193,7,0.05);
            top: -200px;
            right: -150px;
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            color: var(--blue-900);
            font-size: 0.75rem;
            font-weight: 800;
            padding: 6px 16px;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 20px;
            animation: fadeInUp 0.5s ease both;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 20px;
            animation: fadeInUp 0.6s ease both;
        }

        .hero-title span { color: var(--yellow); }

        .hero-sub {
            font-size: 1rem;
            color: rgba(255,255,255,0.65);
            line-height: 1.7;
            margin-bottom: 32px;
            max-width: 480px;
            animation: fadeInUp 0.7s ease both;
        }

        .hero-btns {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease both;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            color: var(--blue-900);
            font-weight: 800;
            font-size: 1rem;
            padding: 14px 28px;
            border-radius: 14px;
            border: none;
            box-shadow: 0 6px 20px rgba(255,193,7,0.4);
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(255,193,7,0.5);
            background: linear-gradient(135deg, var(--yellow-dark), #d97706);
            color: var(--blue-900);
        }

        .btn-hero-outline {
            background: transparent;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            padding: 14px 28px;
            border-radius: 14px;
            border: 2px solid rgba(255,255,255,0.3);
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-hero-outline:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.6);
            color: white;
            transform: translateY(-2px);
        }

        .hero-emoji {
            font-size: 9rem;
            animation: float 3s ease-in-out infinite;
            display: block;
            text-align: center;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-top: 32px;
            animation: fadeInUp 0.9s ease both;
        }

        .hero-stat-item {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            backdrop-filter: blur(8px);
            transition: all 0.25s;
        }

        .hero-stat-item:hover {
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,193,7,0.2);
        }

        .hsi-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .hsi-yellow { background: rgba(255,193,7,0.2); color: var(--yellow); }
        .hsi-green  { background: rgba(22,163,74,0.2); color: #4ade80; }
        .hsi-blue   { background: rgba(13,110,253,0.2); color: #60a5fa; }
        .hsi-red    { background: rgba(220,38,38,0.2); color: #f87171; }

        .hsi-num {
            font-size: 1.3rem;
            font-weight: 800;
            color: white;
            display: block;
            line-height: 1;
        }

        .hsi-lbl {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.5);
            font-weight: 500;
            display: block;
            margin-top: 2px;
        }

        .features-section {
            background: white;
            padding: 80px 0;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--blue-light);
            color: var(--blue);
            font-size: 0.72rem;
            font-weight: 800;
            padding: 5px 14px;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 12px;
        }

        .section-title-main {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gray-900);
            letter-spacing: -0.5px;
            margin-bottom: 12px;
        }

        .section-sub {
            font-size: 0.95rem;
            color: var(--gray-400);
            line-height: 1.7;
            max-width: 500px;
        }

        .feature-card {
            background: var(--gray-50);
            border-radius: 18px;
            padding: 28px;
            border: 1.5px solid var(--gray-100);
            transition: all 0.3s ease;
            height: 100%;
            animation: fadeInUp 0.5s ease both;
        }

        .feature-card:hover {
            border-color: var(--yellow);
            box-shadow: 0 8px 28px rgba(10,42,110,0.1);
            transform: translateY(-4px);
            background: white;
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 18px;
        }

        .fi-yellow { background: linear-gradient(135deg, var(--yellow), var(--gold)); color: var(--blue-900); }
        .fi-blue   { background: linear-gradient(135deg, var(--blue-900), var(--blue-800)); color: white; }
        .fi-green  { background: linear-gradient(135deg, #16a34a, #166534); color: white; }
        .fi-orange { background: linear-gradient(135deg, #e65100, #f57c00); color: white; }

        .feature-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 8px;
        }

        .feature-desc {
            font-size: 0.875rem;
            color: var(--gray-400);
            line-height: 1.7;
            margin: 0;
        }

        .cta-section {
            background: linear-gradient(135deg, var(--blue-900) 0%, #0f1e4a 100%);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        .cta-content { position: relative; z-index: 2; text-align: center; }

        .cta-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
            margin-bottom: 14px;
        }

        .cta-title span { color: var(--yellow); }

        .cta-sub {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.6);
            margin-bottom: 32px;
            line-height: 1.7;
        }

        .footer-welcome {
            background: linear-gradient(160deg, var(--blue-900) 0%, #0f1e4a 100%);
            border-top: 3px solid var(--yellow);
            color: white;
            padding: 48px 0 24px;
        }

        .footer-brand-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--blue-900);
            margin-bottom: 14px;
        }

        .footer-links { list-style: none; padding: 0; margin: 0; }
        .footer-links li { margin-bottom: 8px; }
        .footer-links a {
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .footer-links a:hover { color: var(--yellow); transform: translateX(4px); }

        .footer-contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255,255,255,0.55);
            font-size: 0.875rem;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .footer-contact-item i { color: var(--yellow); }

        .social-links { display: flex; gap: 10px; margin-top: 14px; }
        .social-link {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.65);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.25s;
            font-size: 1rem;
            border: 1px solid rgba(255,255,255,0.08);
        }
        .social-link:hover {
            background: var(--yellow);
            color: var(--blue-900);
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 2rem; }
            .hero-stats { grid-template-columns: 1fr 1fr; }
            .hero-emoji { font-size: 6rem; }
        }
    </style>
</head>
<body>

{{-- ── NAVBAR ── --}}
<nav class="navbar-welcome">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('catalogue.index') }}"
               class="d-flex align-items-center gap-2 text-decoration-none">
                <div class="brand-icon">
                    <i class="bi bi-egg-fried"></i>
                </div>
                <div>
                    <span style="font-size:1.2rem;font-weight:800;color:white;display:block;letter-spacing:-0.3px;">
                        ISI BURGER
                    </span>
                    <span style="font-size:0.65rem;color:rgba(255,255,255,0.45);display:block;font-weight:500;">
                        Restaurant · Dakar, Sénégal
                    </span>
                </div>
            </a>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('catalogue.index') }}" class="nav-link-w d-none d-md-flex">
                    <i class="bi bi-grid-3x3-gap-fill"></i> Catalogue
                </a>
                <a href="{{ route('commandes.index') }}" class="nav-link-w d-none d-md-flex">
                    <i class="bi bi-bag-fill"></i> Mes commandes
                </a>
                <a href="{{ route('login') }}" class="nav-link-w btn-nav-login">
                    <i class="bi bi-shield-lock-fill"></i> Espace Gestionnaire
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- ── HERO ── --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div style="position:relative;z-index:2;">
                    <div class="hero-badge">
                        <i class="bi bi-star-fill"></i> #1 Burger à Dakar
                    </div>
                    <h1 class="hero-title">
                        Le meilleur burger<br>
                        de <span>Dakar</span> vous attend
                    </h1>
                    <p class="hero-sub">
                        Commandez vos burgers préférés sans créer de compte.
                        Livraison rapide, ingrédients frais, saveurs authentiques.
                    </p>
                    <div class="hero-btns">
                        <a href="{{ route('catalogue.index') }}" class="btn-hero-primary">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                            Voir le catalogue
                        </a>
                        <a href="{{ route('commandes.create') }}" class="btn-hero-outline">
                            <i class="bi bi-cart-plus-fill"></i>
                            Commander maintenant
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat-item">
                            <div class="hsi-icon hsi-yellow">
                                <i class="bi bi-egg-fried"></i>
                            </div>
                            <div>
                                <span class="hsi-num">10+</span>
                                <span class="hsi-lbl">Burgers au menu</span>
                            </div>
                        </div>
                        <div class="hero-stat-item">
                            <div class="hsi-icon hsi-green">
                                <i class="bi bi-lightning-charge-fill"></i>
                            </div>
                            <div>
                                <span class="hsi-num">30 min</span>
                                <span class="hsi-lbl">Préparation rapide</span>
                            </div>
                        </div>
                        <div class="hero-stat-item">
                            <div class="hsi-icon hsi-blue">
                                <i class="bi bi-truck"></i>
                            </div>
                            <div>
                                <span class="hsi-num">Livraison</span>
                                <span class="hsi-lbl">Incluse</span>
                            </div>
                        </div>
                        <div class="hero-stat-item">
                            <div class="hsi-icon hsi-red">
                                <i class="bi bi-heart-fill"></i>
                            </div>
                            <div>
                                <span class="hsi-num">100%</span>
                                <span class="hsi-lbl">Satisfaction client</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 text-center" style="position:relative;z-index:2;">
                <span class="hero-emoji">🍔</span>
                <div style="margin-top:20px;display:inline-flex;align-items:center;gap:10px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);border-radius:14px;padding:14px 22px;backdrop-filter:blur(8px);">
                    <i class="bi bi-shield-check-fill" style="color:var(--yellow);font-size:1.3rem;"></i>
                    <div style="text-align:left;">
                        <div style="font-size:0.88rem;font-weight:800;color:white;">Commande sans compte</div>
                        <div style="font-size:0.72rem;color:rgba(255,255,255,0.5);">Juste votre nom et adresse</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── FEATURES ── --}}
<section class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-badge">
                <i class="bi bi-lightning-charge-fill"></i> Nos avantages
            </div>
            <h2 class="section-title-main">
                Pourquoi choisir ISI BURGER ?
            </h2>
            <p class="section-sub mx-auto">
                Une expérience simple, rapide et délicieuse.
                Pas besoin de créer un compte pour commander.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-3" style="animation-delay:0.1s;">
                <div class="feature-card">
                    <div class="feature-icon fi-yellow">
                        <i class="bi bi-egg-fried"></i>
                    </div>
                    <h4 class="feature-title">Burgers Premium</h4>
                    <p class="feature-desc">
                        Ingrédients frais sélectionnés chaque jour.
                        Recettes uniques et savoureuses.
                    </p>
                </div>
            </div>
            <div class="col-md-3" style="animation-delay:0.15s;">
                <div class="feature-card">
                    <div class="feature-icon fi-blue">
                        <i class="bi bi-cart-check-fill"></i>
                    </div>
                    <h4 class="feature-title">Sans inscription</h4>
                    <p class="feature-desc">
                        Commandez directement sans créer de compte.
                        Juste votre nom, email et adresse.
                    </p>
                </div>
            </div>
            <div class="col-md-3" style="animation-delay:0.2s;">
                <div class="feature-card">
                    <div class="feature-icon fi-green">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h4 class="feature-title">Livraison rapide</h4>
                    <p class="feature-desc">
                        Votre commande préparée et livrée
                        à votre adresse en un temps record.
                    </p>
                </div>
            </div>
            <div class="col-md-3" style="animation-delay:0.25s;">
                <div class="feature-card">
                    <div class="feature-icon fi-orange">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <h4 class="feature-title">Suivi par email</h4>
                    <p class="feature-desc">
                        Recevez une confirmation et votre facture
                        PDF dès que votre commande est prête.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── CTA ── --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <div class="section-badge mx-auto" style="background:rgba(255,193,7,0.2);color:var(--yellow);margin-bottom:16px;">
                <i class="bi bi-fire"></i> Commander maintenant
            </div>
            <h2 class="cta-title">
                Prêt à déguster un <span>burger</span> ?
            </h2>
            <p class="cta-sub">
                Explorez notre catalogue et passez votre commande en quelques clics.
                Livraison incluse, satisfaction garantie !
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('catalogue.index') }}" class="btn-hero-primary">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                    Voir le catalogue
                </a>
                <a href="{{ route('commandes.create') }}" class="btn-hero-outline">
                    <i class="bi bi-cart-plus-fill"></i>
                    Commander directement
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ── FOOTER ── --}}
<footer class="footer-welcome">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="footer-brand-icon">
                    <i class="bi bi-egg-fried"></i>
                </div>
                <h5 style="font-weight:800;color:white;margin-bottom:8px;">ISI BURGER</h5>
                <p style="color:rgba(255,255,255,0.45);font-size:0.875rem;line-height:1.7;margin-bottom:14px;">
                    Votre restaurant de burgers premium à Dakar.
                    Commandez sans compte, profitez à fond.
                </p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <h6 style="font-weight:800;color:white;margin-bottom:16px;text-transform:uppercase;font-size:0.8rem;letter-spacing:0.5px;">
                    Navigation
                </h6>
                <ul class="footer-links">
                    <li>
                        <a href="{{ route('catalogue.index') }}">
                            <i class="bi bi-chevron-right"></i> Catalogue
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('commandes.create') }}">
                            <i class="bi bi-chevron-right"></i> Commander
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('commandes.index') }}">
                            <i class="bi bi-chevron-right"></i> Mes commandes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">
                            <i class="bi bi-chevron-right"></i> Espace Gestionnaire
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 style="font-weight:800;color:white;margin-bottom:16px;text-transform:uppercase;font-size:0.8rem;letter-spacing:0.5px;">
                    Contact
                </h6>
                <div class="footer-contact-item">
                    <i class="bi bi-geo-alt-fill"></i> Dakar, Sénégal
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-telephone-fill"></i> +221 77 123 45 67
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-envelope-fill"></i> contact@isiburger.com
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-clock-fill"></i> Lun–Sam : 10h – 22h
                </div>
            </div>
        </div>
        <hr style="border-color:rgba(255,255,255,0.1);margin:0 0 20px;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <p style="color:rgba(255,255,255,0.35);font-size:0.78rem;margin:0;">
                © {{ date('Y') }} ISI BURGER — Tous droits réservés
            </p>
            <p style="color:rgba(255,255,255,0.35);font-size:0.78rem;margin:0;">
                Fait avec <i class="bi bi-heart-fill text-danger"></i> à Dakar
            </p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
