<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStatutRequest;
use App\Models\Commande;
use App\Notifications\CommandePreteNotification;

class CommandeAdminController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['user', 'produits', 'paiement'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.commandes.index', compact('commandes'));
    }

    public function show(Commande $commande)
    {
        $commande->load(['user', 'produits', 'paiement', 'historique']);
        return view('admin.commandes.show', compact('commande'));
    }

    public function updateStatut(UpdateStatutRequest $request, Commande $commande)
    {
    $commande->update(['statut' => $request->validated()['statut']]);

    \App\Models\CommandeStatut::create([
        'commande_id' => $commande->id,
        'statut'      => $request->validated()['statut'],
    ]);

    if ($request->validated()['statut'] === 'prete') {
        $commande->user->notify(new CommandePreteNotification($commande));
    }

    return redirect()->route('admin.commandes.show', $commande)
        ->with('success', 'Statut mis à jour avec succès.');
}

    public function destroy(Commande $commande)
    {
        $commande->update(['statut' => 'annulee']);

        \App\Models\CommandeStatut::create([
            'commande_id' => $commande->id,
            'statut'      => 'annulee',
        ]);

        return redirect()->route('admin.commandes.index')
            ->with('success', 'Commande annulée avec succès.');
    }
}
