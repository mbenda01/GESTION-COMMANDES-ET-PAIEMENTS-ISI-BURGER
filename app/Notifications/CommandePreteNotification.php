<?php

namespace App\Notifications;

use App\Models\Commande;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CommandePreteNotification extends Notification
{
    use Queueable;

    public function __construct(public Commande $commande) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $commande = $this->commande->load(['produits', 'paiement']);

        $pdf = Pdf::loadView('pdf.facture', compact('commande'))
                  ->setPaper('a4', 'portrait');

        $nomFichier = 'facture-commande-' . str_pad($commande->id, 5, '0', STR_PAD_LEFT) . '.pdf';

        $nomClient = $commande->nom_complet_client;

        return (new MailMessage)
            ->subject('🍔 Votre commande #' . str_pad($commande->id, 5, '0', STR_PAD_LEFT) . ' est prête !')
            ->greeting('Bonjour ' . $nomClient . ' !')
            ->line('Bonne nouvelle ! Votre commande est prête et vous attend.')
            ->line('**Numéro de commande :** #' . str_pad($commande->id, 5, '0', STR_PAD_LEFT))
            ->line('**Montant total :** ' . number_format($commande->montant_total, 0, ',', ' ') . ' FCFA')
            ->line('**Adresse de livraison :** ' . $commande->adresse_livraison)
            ->line('Votre facture est disponible en pièce jointe.')
            ->attachData($pdf->output(), $nomFichier, [
                'mime' => 'application/pdf',
            ])
            ->salutation('Merci de votre confiance — ISI BURGER 🍔');
    }
}
