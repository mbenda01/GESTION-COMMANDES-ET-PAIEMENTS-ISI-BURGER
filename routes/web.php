<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\CommandeAdminController;
use App\Http\Controllers\Admin\PaiementController;
use App\Http\Controllers\Admin\StatistiqueController;
use App\Http\Controllers\Client\CatalogueController;
use App\Http\Controllers\Client\CommandeClientController;

Route::get('/', fn() => redirect()->route('login'));

// ─── CLIENT ───────────────────────────────────────────────
Route::middleware(['auth', 'role:Client'])->group(function () {

    Route::get('/catalogue', [CatalogueController::class, 'index'])
        ->name('catalogue.index');

    Route::get('/catalogue/{produit}', [CatalogueController::class, 'show'])
        ->name('catalogue.show');

    Route::get('/commander', [CommandeClientController::class, 'create'])
        ->name('commandes.create');

    Route::post('/commander', [CommandeClientController::class, 'store'])
        ->name('commandes.store');

    Route::get('/mes-commandes', [CommandeClientController::class, 'index'])
        ->name('commandes.index');

    Route::get('/mes-commandes/{commande}', [CommandeClientController::class, 'show'])
        ->name('commandes.show');
});

// ─── GESTIONNAIRE ─────────────────────────────────────────
Route::middleware(['auth', 'role:Gestionnaire'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Dashboard stats
    Route::get('/dashboard', [StatistiqueController::class, 'index'])
        ->name('dashboard');

    // Produits CRUD
    Route::resource('produits', ProduitController::class);

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

    Route::patch('produits/{produit}/archive', [ProduitController::class, 'toggleArchive'])
        ->name('admin.produits.archive');
});
