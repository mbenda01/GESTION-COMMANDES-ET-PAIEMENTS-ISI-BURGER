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
        $nomClient = $this->commande->nom_complet_client;

        return (new MailMessage)
            ->subject('✅ Confirmation de votre commande #' . str_pad($this->commande->id, 5, '0', STR_PAD_LEFT))
            ->greeting('Bonjour ' . $nomClient . ' !')
            ->line('Votre commande a bien été reçue et est en cours de traitement.')
            ->line('**Numéro de commande :** #' . str_pad($this->commande->id, 5, '0', STR_PAD_LEFT))
            ->line('**Montant total :** ' . number_format($this->commande->montant_total, 0, ',', ' ') . ' FCFA')
            ->line('**Adresse de livraison :** ' . $this->commande->adresse_livraison)
            ->line('**Statut :** En attente de préparation')
            ->line('Nous vous enverrons un email dès que votre commande sera prête.')
            ->salutation('Merci de votre confiance — ISI BURGER 🍔');
    }
}
