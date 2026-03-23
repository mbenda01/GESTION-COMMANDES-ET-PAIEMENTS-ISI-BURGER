<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use App\Notifications\CommandeConfirmeeNotification;
use App\Notifications\NouvelleCommandeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeClientController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['produits', 'paiement'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('client.commandes.index', compact('commandes'));
    }

    public function create()
    {
        $produits = Produit::disponible()->orderBy('nom')->get();
        return view('client.commandes.create', compact('produits'));
    }

    public function saveInfos(Request $request)
    {
        $request->validate([
            'prenom'   => ['required', 'string', 'max:100'],
            'nom'      => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:255'],
            'adresse'  => ['required', 'string', 'max:500'],
        ]);

        session(['client_infos' => [
            'prenom'  => $request->prenom,
            'nom'     => $request->nom,
            'email'   => $request->email,
            'adresse' => $request->adresse,
        ]]);

        return response()->json(['success' => true]);
    }
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour passer une commande.');
        }

        $produitsFiltres = collect($request->input('produits', []))
            ->filter(fn($ligne) => isset($ligne['quantite']) && (int)$ligne['quantite'] > 0)
            ->values()
            ->toArray();

        $request->merge(['produits' => $produitsFiltres]);

        $request->validate([
            'produits'            => ['required', 'array', 'min:1'],
            'produits.*.id'       => ['required', 'exists:produits,id'],
            'produits.*.quantite' => ['required', 'integer', 'min:1'],
        ]);

        $montantTotal = 0;
        $lignes = [];

        foreach ($request->produits as $ligne) {
            $produit = Produit::findOrFail($ligne['id']);

            if (!$produit->estDisponible()) {
                return back()->with('error', "Le burger \"{$produit->nom}\" n'est plus disponible.");
            }

            if ($produit->stock < $ligne['quantite']) {
                return back()->with('error', "Stock insuffisant pour le burger \"{$produit->nom}\" (stock : {$produit->stock}).");
            }

            $montantTotal += $produit->prix * $ligne['quantite'];
            $lignes[] = [
                'produit'       => $produit,
                'quantite'      => $ligne['quantite'],
                'prix_unitaire' => $produit->prix,
            ];
        }

        if (empty($lignes)) {
            return back()->with('error', 'Veuillez sélectionner au moins un burger.');
        }

        $user = Auth::user();

        $commande = Commande::create([
            'user_id'           => $user->id,
            'nom_client'        => $user->name,
            'prenom_client'     => $user->name,
            'email_client'      => $user->email,
            'adresse_livraison' => $request->adresse ?? 'Non spécifiée',
            'statut'            => 'en_attente',
            'montant_total'     => $montantTotal,
        ]);
        \App\Models\CommandeStatut::create([
            'commande_id' => $commande->id,
            'statut'      => 'en_attente',
        ]);

        foreach ($lignes as $ligne) {
            $commande->produits()->attach($ligne['produit']->id, [
                'quantite'      => $ligne['quantite'],
                'prix_unitaire' => $ligne['prix_unitaire'],
            ]);

            $nouveauStock = $ligne['produit']->stock - $ligne['quantite'];
            $ligne['produit']->update([
                'stock'  => $nouveauStock,
                'bloque' => $nouveauStock <= 0,
            ]);
        }

        try {
            $user->notify(new CommandeConfirmeeNotification($commande));

            $gestionnaires = User::role('Gestionnaire')->get();

            if ($gestionnaires->isEmpty()) {
                \Log::warning('Aucun gestionnaire trouvé pour la notification commande #' . $commande->id);
            }

            foreach ($gestionnaires as $gestionnaire) {
                $gestionnaire->notify(new NouvelleCommandeNotification($commande));
            }

        } catch (\Exception $e) {
            \Log::error('Erreur notification commande #' . $commande->id . ' : ' . $e->getMessage());
        }

        return redirect()->route('commandes.index')
            ->with('success', 'Commande passée avec succès !');
    }

    public function show(Commande $commande)
    {
        if ($commande->user_id !== Auth::id()) {
            abort(403);
        }

        $commande->load(['produits', 'paiement', 'historique']);
        return view('client.commandes.show', compact('commande'));
    }
}
