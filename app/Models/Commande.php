<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class Commande extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'nom_client',
        'prenom_client',
        'email_client',
        'adresse_livraison',
        'statut',
        'montant_total',
    ];

    protected $casts = [
        'montant_total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_produit')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

    public function getNomCompletClientAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }
        return trim($this->prenom_client . ' ' . $this->nom_client);
    }

    public function getEmailClientFinalAttribute(): string
    {
        if ($this->user) {
            return $this->user->email;
        }
        return $this->email_client ?? '';
    }

    public function notifyClient(Notification $notification): void
    {
        if ($this->user) {
            $this->user->notify($notification);
        } elseif ($this->email_client) {
            \Illuminate\Support\Facades\Notification::route('mail', $this->email_client)
                ->notify($notification);
        }
    }

    public function routeNotificationForMail(): string
    {
        return $this->email_client ?? '';
    }

    public function estAnnulable(): bool
    {
        return in_array($this->statut, ['en_attente', 'en_preparation']);
    }

    public function estPayable(): bool
    {
        return $this->statut === 'prete' && !$this->paiement;
    }
    public function historique()
    {
        return $this->hasMany(CommandeStatut::class)->orderBy('created_at', 'asc');
    }
}
