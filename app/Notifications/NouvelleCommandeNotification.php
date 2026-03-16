<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NouvelleCommandeNotification extends Notification
{
    use Queueable;

    public function __construct(public Commande $commande) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🍔 Nouvelle commande #' . $this->commande->id)
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Une nouvelle commande vient d\'être passée.')
            ->line('**Numéro de commande :** #' . $this->commande->id)
            ->line('**Client :** ' . $this->commande->user->name)
            ->line('**Montant total :** ' . number_format($this->commande->montant_total, 0, ',', ' ') . ' FCFA')
            ->line('**Nombre de burgers :** ' . $this->commande->produits->count())
            ->action('Voir la commande', url('/admin/commandes/' . $this->commande->id))
            ->line('Connectez-vous pour traiter cette commande.');
    }
}
