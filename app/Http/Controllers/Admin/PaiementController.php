<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaiementRequest;
use App\Models\Commande;
use App\Models\Paiement;

class PaiementController extends Controller
{
    public function store(StorePaiementRequest $request, Commande $commande)
    {
        if ($commande->paiement) {
            return redirect()->route('admin.commandes.show', $commande)
                ->with('error', 'Cette commande a déjà été payée.');
        }

        Paiement::create([
            'commande_id'   => $commande->id,
            'montant'       => $request->validated()['montant'],
            'mode'          => $request->validated()['mode'],
            'date_paiement' => now(),
        ]);

        $commande->update(['statut' => 'payee']);

        \App\Models\CommandeStatut::create([
            'commande_id' => $commande->id,
            'statut'      => 'payee',
        ]);

        return redirect()->route('admin.commandes.show', $commande)
            ->with('success', 'Paiement enregistré avec succès.');
    }
}
