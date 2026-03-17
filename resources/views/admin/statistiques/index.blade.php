@extends('layouts.app')

@section('title', 'Statistiques')

@section('content')

@push('styles')
<style>
    .stats-kpi-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }

    .stats-kpi-card {
        border-radius: 18px;
        padding: 24px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        animation: fadeInUp 0.5s ease both;
    }
    .stats-kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 32px rgba(0,0,0,0.15);
    }
    .stats-kpi-card:nth-child(1) { animation-delay: 0.05s; }
    .stats-kpi-card:nth-child(2) { animation-delay: 0.10s; }
    .stats-kpi-card:nth-child(3) { animation-delay: 0.15s; }

    .skpi-orange { background: linear-gradient(135deg, #e65100, #f57c00); color: white; }
    .skpi-blue   { background: linear-gradient(135deg, var(--blue-900), var(--blue-800)); color: white; }
    .skpi-green  { background: linear-gradient(135deg, #16a34a, #166534); color: white; }

    .skpi-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
        backdrop-filter: blur(8px);
    }

    .skpi-label {
        font-size: 0.78rem;
        font-weight: 600;
        opacity: 0.85;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 6px;
    }

    .skpi-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
        letter-spacing: -1px;
        display: block;
    }

    .skpi-sub {
        font-size: 0.75rem;
        opacity: 0.75;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 6px;
    }

    .skpi-wave {
        position: absolute;
        bottom: -15px;
        right: -15px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
    }
    .skpi-wave::after {
        content: '';
        position: absolute;
        top: 14px;
        left: 14px;
        right: 14px;
        bottom: 14px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
    }

    .charts-row-1 {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .chart-card {
        background: white;
        border-radius: 18px;
        border: 1.5px solid var(--gray-100);
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        overflow: hidden;
        animation: fadeInUp 0.5s ease both;
    }

    .chart-card-header {
        padding: 18px 22px 14px;
        border-bottom: 1.5px solid var(--gray-100);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .chart-card-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--gray-900);
        margin: 0 0 3px;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .chart-card-title i { color: var(--yellow); }

    .chart-card-sub {
        font-size: 0.78rem;
        color: var(--gray-400);
        margin: 0;
        font-weight: 400;
    }

    .chart-card-body { padding: 20px 22px; }

    .top-produits-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .top-produit-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        background: var(--gray-50);
        border-radius: 12px;
        border: 1.5px solid var(--gray-100);
        transition: all 0.2s;
    }

    .top-produit-item:hover {
        border-color: var(--yellow);
        background: #fffdf0;
    }

    .top-rank {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.78rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .rank-1 { background: linear-gradient(135deg, var(--yellow), var(--gold)); color: var(--blue-900); }
    .rank-2 { background: var(--gray-200); color: var(--gray-700); }
    .rank-3 { background: #fde8cc; color: #c2641a; }
    .rank-other { background: var(--gray-100); color: var(--gray-400); }

    .top-produit-name {
        flex: 1;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    .top-produit-bar-wrap {
        width: 80px;
        height: 6px;
        background: var(--gray-100);
        border-radius: 999px;
        overflow: hidden;
    }

    .top-produit-bar {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--yellow), var(--gold));
        animation: growWidth 1.2s cubic-bezier(0.4,0,0.2,1) both;
    }

    @keyframes growWidth { from { width: 0 !important; } }

    .top-produit-count {
        font-size: 0.82rem;
        font-weight: 800;
        color: var(--blue-900);
        white-space: nowrap;
    }

    @media (max-width: 992px) {
        .stats-kpi-grid { grid-template-columns: repeat(2, 1fr); }
        .charts-row-1  { grid-template-columns: 1fr; }
    }

    @media (max-width: 576px) {
        .stats-kpi-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

{{-- ── HEADER ── --}}
<div class="page-header-isi">
    <div>
        <h2 class="page-title-isi">
            <i class="bi bi-bar-chart-fill"></i> Statistiques & Rapports
        </h2>
        <p class="page-subtitle-isi">
            Vue d'ensemble de l'activité — {{ now()->format('d/m/Y') }}
        </p>
    </div>
    <div style="background:linear-gradient(135deg,var(--yellow),var(--gold));color:var(--blue-900);font-size:0.78rem;font-weight:800;padding:8px 16px;border-radius:10px;display:flex;align-items:center;gap:7px;">
        <i class="bi bi-calendar-check-fill"></i>
        Aujourd'hui : {{ now()->translatedFormat('l d F Y') }}
    </div>
</div>

{{-- ── KPI CARDS ── --}}
<div class="stats-kpi-grid">

    <div class="stats-kpi-card skpi-orange">
        <div class="skpi-icon"><i class="bi bi-clock-history"></i></div>
        <div>
            <span class="skpi-label">Commandes en cours</span>
            <span class="skpi-value">{{ $commandesEnCours }}</span>
            <span class="skpi-sub">
                <i class="bi bi-arrow-right-circle-fill"></i>
                En attente + préparation + prêtes
            </span>
        </div>
        <div class="skpi-wave"></div>
    </div>

    <div class="stats-kpi-card skpi-blue">
        <div class="skpi-icon"><i class="bi bi-patch-check-fill"></i></div>
        <div>
            <span class="skpi-label">Commandes validées</span>
            <span class="skpi-value">{{ $commandesValidees }}</span>
            <span class="skpi-sub">
                <i class="bi bi-calendar-day-fill"></i>
                Payées aujourd'hui
            </span>
        </div>
        <div class="skpi-wave"></div>
    </div>

    <div class="stats-kpi-card skpi-green">
        <div class="skpi-icon"><i class="bi bi-coin"></i></div>
        <div>
            <span class="skpi-label">Recettes du jour</span>
            <span class="skpi-value">{{ number_format($recettesJour, 0, ',', ' ') }}</span>
            <span class="skpi-sub">
                <i class="bi bi-currency-exchange"></i>
                FCFA encaissés
            </span>
        </div>
        <div class="skpi-wave"></div>
    </div>

</div>

{{-- ── GRAPHIQUES ── --}}
<div class="charts-row-1">

    {{-- Commandes par mois --}}
    <div class="chart-card" style="animation-delay:0.2s;">
        <div class="chart-card-header">
            <div>
                <h3 class="chart-card-title">
                    <i class="bi bi-bar-chart-line-fill"></i>
                    Commandes par mois
                </h3>
                <p class="chart-card-sub">Évolution sur les 12 derniers mois</p>
            </div>
            <div style="background:var(--blue-light);color:var(--blue);font-size:0.72rem;font-weight:800;padding:4px 12px;border-radius:999px;display:flex;align-items:center;gap:5px;">
                <span style="width:8px;height:8px;border-radius:50%;background:var(--blue);display:inline-block;"></span>
                Commandes
            </div>
        </div>
        <div class="chart-card-body">
            <canvas id="chartCommandes" height="110"></canvas>
        </div>
    </div>

    {{-- Top Produits --}}
    <div class="chart-card" style="animation-delay:0.25s;">
        <div class="chart-card-header">
            <div>
                <h3 class="chart-card-title">
                    <i class="bi bi-trophy-fill"></i>
                    Top 5 burgers
                </h3>
                <p class="chart-card-sub">Les plus commandés</p>
            </div>
        </div>
        <div class="chart-card-body">
            @php $maxTop = $topProduits->max('total_commande') ?: 1; @endphp
            <div class="top-produits-list">
                @forelse($topProduits as $i => $produit)
                <div class="top-produit-item">
                    <div class="top-rank
                        {{ $i === 0 ? 'rank-1' : ($i === 1 ? 'rank-2' : ($i === 2 ? 'rank-3' : 'rank-other')) }}">
                        {{ $i + 1 }}
                    </div>
                    <span class="top-produit-name">{{ $produit->nom }}</span>
                    <div class="top-produit-bar-wrap">
                        <div class="top-produit-bar"
                             style="width:{{ round(($produit->total_commande / $maxTop) * 100) }}%">
                        </div>
                    </div>
                    <span class="top-produit-count">{{ $produit->total_commande }}×</span>
                </div>
                @empty
                <p style="color:var(--gray-400);font-size:0.875rem;text-align:center;">
                    Aucune donnée disponible.
                </p>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- Graphique doughnut --}}
<div class="row g-4">
    <div class="col-md-6">
        <div class="chart-card" style="animation-delay:0.3s;">
            <div class="chart-card-header">
                <div>
                    <h3 class="chart-card-title">
                        <i class="bi bi-pie-chart-fill"></i>
                        Répartition des statuts
                    </h3>
                    <p class="chart-card-sub">Toutes les commandes</p>
                </div>
            </div>
            <div class="chart-card-body">
                <canvas id="chartStatuts" height="180"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="chart-card" style="animation-delay:0.35s;">
            <div class="chart-card-header">
                <div>
                    <h3 class="chart-card-title">
                        <i class="bi bi-graph-up-arrow"></i>
                        Recettes mensuelles
                    </h3>
                    <p class="chart-card-sub">Montants encaissés en FCFA</p>
                </div>
            </div>
            <div class="chart-card-body">
                <canvas id="chartRecettes" height="180"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const labelsCommandes = @json($commandesMois->pluck('mois'));
    const dataCommandes   = @json($commandesMois->pluck('total'));

    new Chart(document.getElementById('chartCommandes'), {
        type: 'bar',
        data: {
            labels: labelsCommandes,
            datasets: [{
                label: 'Commandes',
                data: dataCommandes,
                backgroundColor: 'rgba(13,42,110,0.85)',
                borderRadius: 8,
                borderSkipped: false,
                hoverBackgroundColor: '#ffc107',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { family: 'Plus Jakarta Sans', weight: '600', size: 11 }
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    ticks: { font: { family: 'Plus Jakarta Sans', weight: '600', size: 11 } },
                    grid: { display: false }
                }
            }
        }
    });

    @php
        $statutsData = \App\Models\Commande::selectRaw('statut, COUNT(*) as total')
            ->groupBy('statut')
            ->pluck('total', 'statut');
    @endphp

    const statutLabels = @json($statutsData->keys()->map(fn($s) => str_replace('_', ' ', $s)));
    const statutData   = @json($statutsData->values());
    const statutColors = ['#e65100','#f57c00','#16a34a','#2e7d32','#dc2626'];

    new Chart(document.getElementById('chartStatuts'), {
        type: 'doughnut',
        data: {
            labels: statutLabels,
            datasets: [{
                data: statutData,
                backgroundColor: statutColors,
                borderWidth: 3,
                borderColor: '#fff',
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { family: 'Plus Jakarta Sans', weight: '700', size: 11 },
                        padding: 16,
                        usePointStyle: true,
                        pointStyleWidth: 10,
                    }
                }
            },
            cutout: '65%',
        }
    });

    @php
        $recettesData = \App\Models\Paiement::selectRaw("TO_CHAR(date_paiement, 'YYYY-MM') as mois, SUM(montant) as total")
            ->where('date_paiement', '>=', now()->subMonths(6))
            ->groupBy('mois')
            ->orderBy('mois')
            ->pluck('total', 'mois');
    @endphp

    const recettesLabels = @json($recettesData->keys());
    const recettesValues = @json($recettesData->values());

    new Chart(document.getElementById('chartRecettes'), {
        type: 'line',
        data: {
            labels: recettesLabels,
            datasets: [{
                label: 'Recettes (FCFA)',
                data: recettesValues,
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255,193,7,0.1)',
                borderWidth: 3,
                pointBackgroundColor: '#ffc107',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { family: 'Plus Jakarta Sans', weight: '600', size: 11 },
                        callback: function(v) { return v.toLocaleString('fr-FR') + ' F'; }
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    ticks: { font: { family: 'Plus Jakarta Sans', weight: '600', size: 11 } },
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endpush
@endsection
