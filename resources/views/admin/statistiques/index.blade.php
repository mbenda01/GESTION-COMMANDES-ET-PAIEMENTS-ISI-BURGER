@extends('layouts.app')
@section('title', 'Statistiques')

@section('content')
<h2 class="fw-bold mb-4">📊 Statistiques du jour</h2>

{{-- Cards stats --}}
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="stats-highlight text-center">
            <div style="font-size: 2.5rem; font-weight: bold;">
                {{ $commandesEnCours }}
            </div>
            <div>Commandes en cours</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-highlight text-center">
            <div style="font-size: 2.5rem; font-weight: bold;">
                {{ $commandesValidees }}
            </div>
            <div>Commandes validées</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-highlight text-center">
            <div style="font-size: 2.5rem; font-weight: bold;">
                {{ number_format($recettesJour, 0, ',', ' ') }}
            </div>
            <div>FCFA de recettes</div>
        </div>
    </div>
</div>

{{-- Graphique commandes par mois --}}
<div class="row g-4">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header fw-bold" style="background-color:#1A1A1A;color:#fff;">
                📈 Commandes par mois
            </div>
            <div class="card-body">
                <canvas id="chartCommandes" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Top produits --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-header fw-bold" style="background-color:#1A1A1A;color:#fff;">
                🏆 Top 5 burgers commandés
            </div>
            <div class="card-body">
                <canvas id="chartProduits" height="180"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Commandes par mois
    const labelsCommandes = @json($commandesMois->pluck('mois'));
    const dataCommandes   = @json($commandesMois->pluck('total'));

    new Chart(document.getElementById('chartCommandes'), {
        type: 'bar',
        data: {
            labels: labelsCommandes,
            datasets: [{
                label: 'Commandes',
                data: dataCommandes,
                backgroundColor: '#D4530A',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // Top produits
    const labelsProduits = @json($topProduits->pluck('nom'));
    const dataProduits = @json($topProduits->pluck('total_commande'));

    new Chart(document.getElementById('chartProduits'), {
        type: 'doughnut',
        data: {
            labels: labelsProduits,
            datasets: [{
                data: dataProduits,
                backgroundColor: [
                    '#D4530A','#1A1A1A','#2E7D32','#F57C00','#C0392B'
                ],
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection
