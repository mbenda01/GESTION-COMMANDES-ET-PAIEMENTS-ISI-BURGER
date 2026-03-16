<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CommandeConfirmeeNotification extends Notification
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
            ->subject('✅ Confirmation de votre commande #' . $this->commande->id)
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Votre commande a bien été reçue et est en cours de traitement.')
            ->line('**Numéro de commande :** #' . $this->commande->id)
            ->line('**Montant total :** ' . number_format($this->commande->montant_total, 0, ',', ' ') . ' FCFA')
            ->line('**Statut :** En attente')
            ->action('Voir ma commande', url('/mes-commandes/' . $this->commande->id))
            ->line('Merci de votre confiance chez ISI BURGER !');
    }
}
