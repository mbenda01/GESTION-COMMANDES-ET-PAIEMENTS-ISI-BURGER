<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::actif();

        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }

        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        $produits = $query->orderBy('nom')->paginate(6)->withQueryString();

        return view('client.catalogue.index', compact('produits'));
    }

    public function show(Produit $produit)
    {
        return view('client.catalogue.show', compact('produit'));
    }
}
