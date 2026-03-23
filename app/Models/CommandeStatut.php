<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeStatut extends Model
{
    public $timestamps = false;

    protected $fillable = ['commande_id', 'statut'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
