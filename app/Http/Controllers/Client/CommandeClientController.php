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
        $infosClient = session('client_infos');

        if (!$infosClient && !Auth::check()) {
            return redirect()->route('catalogue.index')
                ->with('info', 'Veuillez d\'abord passer une commande.');
        }

        if (Auth::check()) {
            $commandes = Commande::with(['produits', 'paiement'])
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(6);
        } else {
            $ids = session('commandes_ids', []);
            $commandes = Commande::with(['produits', 'paiement'])
                ->whereIn('id', $ids)
                ->orderBy('created_at', 'desc')
                ->paginate(6);
        }

        return view('client.commandes.index', compact('commandes'));
    }

    public function create()
    {
        $produits = Produit::disponible()->orderBy('nom')->get();
        $infosClient = session('client_infos');
        return view('client.commandes.create', compact('produits', 'infosClient'));
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
        $request->validate([
            'produits'            => ['required', 'array', 'min:1'],
            'produits.*.id'       => ['required', 'exists:produits,id'],
            'produits.*.quantite' => ['required', 'integer', 'min:1'],
            'prenom'              => ['required', 'string', 'max:100'],
            'nom'                 => ['required', 'string', 'max:100'],
            'email'               => ['required', 'email', 'max:255'],
            'adresse'             => ['required', 'string', 'max:500'],
        ]);

        session(['client_infos' => [
            'prenom'  => $request->prenom,
            'nom'     => $request->nom,
            'email'   => $request->email,
            'adresse' => $request->adresse,
        ]]);

        $montantTotal = 0;
        $lignes = [];

        foreach ($request->produits as $ligne) {
            if ((int)$ligne['quantite'] <= 0) continue;

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

        $userId = Auth::check() ? Auth::id() : null;

        $commande = Commande::create([
            'user_id'          => $userId,
            'nom_client'       => $request->nom,
            'prenom_client'    => $request->prenom,
            'email_client'     => $request->email,
            'adresse_livraison'=> $request->adresse,
            'statut'           => 'en_attente',
            'montant_total'    => $montantTotal,
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

        $ids = session('commandes_ids', []);
        $ids[] = $commande->id;
        session(['commandes_ids' => $ids]);

        try {
            $commande->notifyClient(new CommandeConfirmeeNotification($commande));

            $gestionnaires = User::role('Gestionnaire')->get();
            foreach ($gestionnaires as $gestionnaire) {
                $gestionnaire->notify(new NouvelleCommandeNotification($commande));
            }
        } catch (\Exception $e) {
            \Log::error('Erreur notification commande : ' . $e->getMessage());
        }

        return redirect()->route('commandes.index')
            ->with('success', 'Commande passée avec succès ! Un email de confirmation vous a été envoyé.');
    }

    public function show(Commande $commande)
    {
        $infosClient = session('client_infos');
        $idsSession  = session('commandes_ids', []);

        $autorise = Auth::check()
            ? $commande->user_id === Auth::id()
            : in_array($commande->id, $idsSession);

        if (!$autorise) {
            abort(403);
        }

        $commande->load(['produits', 'paiement']);
        return view('client.commandes.show', compact('commande'));
    }
}
