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
        'bloque',
    ];

    protected $casts = [
        'archive' => 'boolean',
        'bloque'  => 'boolean',
        'prix'    => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (Produit $produit) {
            if ($produit->stock <= 0) {
                $produit->bloque = true;
            }
        });
    }

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_produit')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }

    public function scopeDisponible($query)
    {
        return $query->where('archive', false)
                     ->where('bloque', false)
                     ->where('stock', '>', 0);
    }

    public function scopeActif($query)
    {
        return $query->where('archive', false);
    }

    public function estDisponible(): bool
    {
        return !$this->archive && !$this->bloque && $this->stock > 0;
    }

    public function estEnRupture(): bool
    {
        return $this->stock <= 0;
    }

    public function estStockFaible(): bool
    {
        return $this->stock > 0 && $this->stock <= 5;
    }
}
