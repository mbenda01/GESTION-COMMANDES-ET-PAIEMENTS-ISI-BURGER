<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::where('archive', false)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('admin.produits.index', compact('produits'));
    }

    public function create()
    {
        return view('admin.produits.create');
    }

    public function store(StoreProduitRequest $request)
    {
        $data = $request->validated();
        $data['bloque'] = isset($data['stock']) && $data['stock'] <= 0;

        $data['image'] = $this->handleImage($request, null);
        unset($data['image_url'], $data['image_file']);

        Produit::create($data);

        return redirect()->route('admin.produits.index')
            ->with('success', 'Burger ajouté avec succès.');
    }

    public function show(Produit $produit)
    {
        return view('admin.produits.show', compact('produit'));
    }

    public function edit(Produit $produit)
    {
        return view('admin.produits.edit', compact('produit'));
    }

    public function update(UpdateProduitRequest $request, Produit $produit)
    {
        $data = $request->validated();
        $data['bloque'] = isset($data['stock']) && $data['stock'] <= 0;
        $imageResult = $this->handleImage($request, $produit->image);
        if ($imageResult !== null) {
            $data['image'] = $imageResult;
        }

        unset($data['image_url'], $data['image_file']);

        $produit->update($data);

        return redirect()->route('admin.produits.index')
            ->with('success', 'Burger mis à jour avec succès.');
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('admin.produits.index')
            ->with('success', 'Burger supprimé avec succès.');
    }

    public function toggleArchive(Produit $produit)
    {
        $produit->update(['archive' => !$produit->archive]);
        $message = $produit->archive ? 'Burger archivé.' : 'Burger désarchivé.';
        return redirect()->route('admin.produits.index')
            ->with('success', $message);
    }

    public function updateStock(Request $request, Produit $produit)
    {
        $request->validate([
            'action'   => ['required', 'in:ajouter,diminuer,definir'],
            'quantite' => ['required', 'integer', 'min:0'],
        ]);

        $quantite = (int) $request->quantite;

        switch ($request->action) {
            case 'ajouter':
                $nouveauStock = $produit->stock + $quantite;
                break;
            case 'diminuer':
                $nouveauStock = max(0, $produit->stock - $quantite);
                break;
            case 'definir':
                $nouveauStock = $quantite;
                break;
            default:
                $nouveauStock = $produit->stock;
        }

        $produit->update([
            'stock'  => $nouveauStock,
            'bloque' => $nouveauStock <= 0,
        ]);

        $msg = $nouveauStock <= 0
            ? 'Stock mis à jour — produit bloqué (rupture).'
            : 'Stock mis à jour avec succès.';

        return redirect()->route('admin.produits.index')
            ->with('success', $msg);
    }
    private function handleImage($request, ?string $current): ?string
    {
        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            if ($current && str_starts_with($current, '/storage/')) {
                $path = str_replace('/storage/', 'public/', $current);
                \Storage::delete($path);
            }
            $path = $request->file('image_file')->store('produits', 'public');
            return '/storage/' . $path;
        }

        if ($request->filled('image_url')) {
            return $request->input('image_url');
        }

        return $current;
    }
}
