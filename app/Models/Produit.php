<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prix',
        'description',
        'image',
        'stock',
        'archive',
    ];

    protected $casts = [
        'archive' => 'boolean',
        'prix'    => 'decimal:2',
    ];

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_produit')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }

    public function scopeDisponible($query)
    {
        return $query->where('archive', false)->where('stock', '>', 0);
    }
}
