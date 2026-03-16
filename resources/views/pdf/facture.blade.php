<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #1A1A1A;
            margin: 0;
            padding: 20px;
        }
        .header {
            background-color: #1A1A1A;
            color: #FFFFFF;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #D4530A;
            letter-spacing: 2px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #CCCCCC;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            background-color: #D4530A;
            color: #FFFFFF;
            padding: 6px 12px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .info-grid {
            width: 100%;
        }
        .info-grid td {
            padding: 4px 8px;
            font-size: 12px;
        }
        .info-label {
            color: #666666;
            width: 40%;
        }
        .info-value {
            font-weight: bold;
        }
        table.produits {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        table.produits th {
            background-color: #1A1A1A;
            color: #FFFFFF;
            padding: 8px 10px;
            text-align: left;
            font-size: 12px;
        }
        table.produits td {
            padding: 8px 10px;
            border-bottom: 1px solid #E0E0E0;
            font-size: 12px;
        }
        table.produits tr:nth-child(even) td {
            background-color: #F5F5F5;
        }
        .total-row td {
            background-color: #D4530A !important;
            color: #FFFFFF;
            font-weight: bold;
            font-size: 14px;
            padding: 10px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #999999;
            border-top: 1px solid #E0E0E0;
            padding-top: 15px;
        }
        .badge {
            background-color: #2E7D32;
            color: #FFFFFF;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>ISI BURGER</h1>
        <p>Le meilleur burger de Dakar</p>
    </div>

    <div class="section">
        <div class="section-title">FACTURE</div>
        <table class="info-grid">
            <tr>
                <td class="info-label">Numéro de facture</td>
                <td class="info-value">#{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td class="info-label">Date</td>
                <td class="info-value">{{ now()->format('d/m/Y à H:i') }}</td>
            </tr>
            <tr>
                <td class="info-label">Statut</td>
                <td class="info-value">
                    <span class="badge">Prête</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">CLIENT</div>
        <table class="info-grid">
            <tr>
                <td class="info-label">Nom</td>
                <td class="info-value">{{ $commande->user->name }}</td>
            </tr>
            <tr>
                <td class="info-label">Email</td>
                <td class="info-value">{{ $commande->user->email }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">DÉTAIL DE LA COMMANDE</div>
        <table class="produits">
            <thead>
                <tr>
                    <th>Burger</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commande->produits as $produit)
                <tr>
                    <td>{{ $produit->nom }}</td>
                    <td>{{ number_format($produit->pivot->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $produit->pivot->quantite }}</td>
                    <td>{{ number_format($produit->pivot->prix_unitaire * $produit->pivot->quantite, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">TOTAL</td>
                    <td>{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Merci de votre confiance chez ISI BURGER</p>
        <p>Ce document est une facture officielle — conservez-le précieusement.</p>
    </div>

</body>
</html>
