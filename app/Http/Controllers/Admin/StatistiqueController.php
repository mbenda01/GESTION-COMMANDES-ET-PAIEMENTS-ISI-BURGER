<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Paiement;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    public function index()
    {
        // ── Cards du jour ──────────────────────────────
        $commandesEnCours = Commande::whereDate('created_at', today())
            ->whereIn('statut', ['en_attente', 'en_preparation', 'prete'])
            ->count();

        $commandesValidees = Commande::whereDate('created_at', today())
            ->where('statut', 'payee')
            ->count();

        $recettesJour = Paiement::whereDate('date_paiement', today())
            ->sum('montant');

        // ── Commandes par mois (12 derniers mois) ──────
        $commandesMois = Commande::selectRaw(
                "TO_CHAR(created_at, 'YYYY-MM') as mois, COUNT(*) as total"
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // ── Top 5 produits les plus commandés ──────────
        $topProduits = DB::table('commande_produit')
            ->join('produits', 'produits.id', '=', 'commande_produit.produit_id')
            ->select(
                'produits.nom',
                DB::raw('SUM(commande_produit.quantite) as total_commande')
            )
            ->groupBy('produits.id', 'produits.nom')
            ->orderByDesc('total_commande')
            ->limit(5)
            ->get();

        return view('admin.statistiques.index', compact(
            'commandesEnCours',
            'commandesValidees',
            'recettesJour',
            'commandesMois',
            'topProduits'
        ));
    }
}
