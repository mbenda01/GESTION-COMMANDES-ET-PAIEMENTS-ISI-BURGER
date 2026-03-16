<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Produit;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::orderBy('created_at', 'desc')->paginate(5);
        return view('admin.produits.index', compact('produits'));
    }

    public function create()
    {
        return view('admin.produits.create');
    }

    public function store(StoreProduitRequest $request)
    {
        Produit::create($request->validated());

        return redirect()->route('admin.produits.index')
            ->with('success', 'Burger ajouté avec succès.');
    }

    public function edit(Produit $produit)
    {
        return view('admin.produits.edit', compact('produit'));
    }

    public function update(UpdateProduitRequest $request, Produit $produit)
    {
        $produit->update($request->validated());

        return redirect()->route('admin.produits.index')
            ->with('success', 'Burger mis à jour avec succès.');
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();

        return redirect()->route('admin.produits.index')
            ->with('success', 'Burger supprimé avec succès.');
    }

    public function show(Produit $produit)
    {
        return view('admin.produits.show', compact('produit'));
    }

    public function toggleArchive(Produit $produit)
    {
        $produit->update(['archive' => !$produit->archive]);

        $message = $produit->archive ? 'Burger archivé.' : 'Burger désarchivé.';

        return redirect()->route('admin.produits.index')
            ->with('success', $message);
    }
}
