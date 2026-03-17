<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\CommandeAdminController;
use App\Http\Controllers\Admin\PaiementController;
use App\Http\Controllers\Admin\StatistiqueController;
use App\Http\Controllers\Client\CatalogueController;
use App\Http\Controllers\Client\CommandeClientController;

Route::get('/', fn() => redirect()->route('catalogue.index'));

// ─── CATALOGUE PUBLIC (accessible sans connexion) ──────────────────────────
Route::get('/catalogue', [CatalogueController::class, 'index'])
    ->name('catalogue.index');

Route::get('/catalogue/{produit}', [CatalogueController::class, 'show'])
    ->name('catalogue.show');

// ─── COMMANDES CLIENT (sans connexion obligatoire) ─────────────────────────
Route::get('/commander', [CommandeClientController::class, 'create'])
    ->name('commandes.create');

Route::post('/commander', [CommandeClientController::class, 'store'])
    ->name('commandes.store');

Route::get('/mes-commandes', [CommandeClientController::class, 'index'])
    ->name('commandes.index');

Route::get('/mes-commandes/{commande}', [CommandeClientController::class, 'show'])
    ->name('commandes.show');

// ─── INFOS CLIENT (collecte nom/prénom/mail/adresse à la 1ère visite) ──────
Route::post('/client/infos', [CommandeClientController::class, 'saveInfos'])
    ->name('client.infos.save');

// ─── GESTIONNAIRE (auth + rôle requis) ────────────────────────────────────
Route::middleware(['auth', 'role:Gestionnaire'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [StatistiqueController::class, 'index'])
            ->name('dashboard');

        // Produits CRUD
        Route::get('/produits', [ProduitController::class, 'index'])
            ->name('produits.index');

        Route::get('/produits/create', [ProduitController::class, 'create'])
            ->name('produits.create');

        Route::post('/produits', [ProduitController::class, 'store'])
            ->name('produits.store');

        Route::get('/produits/{produit}', [ProduitController::class, 'show'])
            ->name('produits.show');

        Route::get('/produits/{produit}/edit', [ProduitController::class, 'edit'])
            ->name('produits.edit');

        Route::put('/produits/{produit}', [ProduitController::class, 'update'])
            ->name('produits.update');

        Route::delete('/produits/{produit}', [ProduitController::class, 'destroy'])
            ->name('produits.destroy');

        Route::patch('/produits/{produit}/archive', [ProduitController::class, 'toggleArchive'])
            ->name('produits.archive');

        Route::patch('/produits/{produit}/stock', [ProduitController::class, 'updateStock'])
            ->name('produits.stock');

        // Commandes
        Route::get('/commandes', [CommandeAdminController::class, 'index'])
            ->name('commandes.index');

        Route::get('/commandes/{commande}', [CommandeAdminController::class, 'show'])
            ->name('commandes.show');

        Route::patch('/commandes/{commande}/statut', [CommandeAdminController::class, 'updateStatut'])
            ->name('commandes.updateStatut');

        Route::delete('/commandes/{commande}', [CommandeAdminController::class, 'destroy'])
            ->name('commandes.destroy');

        // Paiement
        Route::post('/commandes/{commande}/paiement', [PaiementController::class, 'store'])
            ->name('commandes.paiement');
    });

require __DIR__.'/auth.php';
