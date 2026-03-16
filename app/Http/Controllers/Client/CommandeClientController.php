<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommandeRequest;
use App\Models\Commande;
use App\Models\Produit;
use App\Notifications\CommandeConfirmeeNotification;
use App\Notifications\NouvelleCommandeNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommandeClientController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['produits', 'paiement'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('client.commandes.index', compact('commandes'));
    }

    public function create()
    {
        $produits = Produit::disponible()->orderBy('nom')->get();
        return view('client.commandes.create', compact('produits'));
    }

    public function store(StoreCommandeRequest $request)
    {
        $montantTotal = 0;
        $lignes = [];

        foreach ($request->validated()['produits'] as $ligne) {
            $produit = Produit::findOrFail($ligne['id']);

            if ($produit->stock < $ligne['quantite']) {
                return back()->with('error',
                    "Stock insuffisant pour le burger : {$produit->nom}."
                );
            }

            $montantTotal += $produit->prix * $ligne['quantite'];
            $lignes[] = [
                'produit'    => $produit,
                'quantite'   => $ligne['quantite'],
                'prix_unitaire' => $produit->prix,
            ];
        }

        // Créer la commande
        $commande = Commande::create([
            'user_id'       => Auth::id(),
            'statut'        => 'en_attente',
            'montant_total' => $montantTotal,
        ]);

        // Attacher les produits + décrémenter le stock
        foreach ($lignes as $ligne) {
            $commande->produits()->attach($ligne['produit']->id, [
                'quantite'      => $ligne['quantite'],
                'prix_unitaire' => $ligne['prix_unitaire'],
            ]);

            $ligne['produit']->decrement('stock', $ligne['quantite']);
        }

        // Notifications
        Auth::user()->notify(new CommandeConfirmeeNotification($commande));

        $gestionnaires = User::role('Gestionnaire')->get();
        foreach ($gestionnaires as $gestionnaire) {
            $gestionnaire->notify(new NouvelleCommandeNotification($commande));
        }

        return redirect()->route('commandes.index')
            ->with('success', 'Commande passée avec succès ! Vous recevrez un email de confirmation.');
    }

    public function show(Commande $commande)
    {
        if ($commande->user_id !== Auth::id()) {
            abort(403);
        }

        $commande->load(['produits', 'paiement']);
        return view('client.commandes.show', compact('commande'));
    }
}
