<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        $produits = [
            [
                'nom'         => 'Classic Burger',
                'prix'        => 2500,
                'description' => 'Steak haché, salade, tomate, oignon',
                'stock'       => 20,
                'image'       => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400',
            ],
            [
                'nom'         => 'Double Cheese',
                'prix'        => 3500,
                'description' => 'Double steak, double cheddar, cornichons',
                'stock'       => 15,
                'image'       => 'https://images.unsplash.com/photo-1553979459-d2229ba7433b?w=400',
            ],
            [
                'nom'         => 'Spicy Burger',
                'prix'        => 3000,
                'description' => 'Piment jalapeño, sauce épicée, avocat',
                'stock'       => 10,
                'image'       => 'https://images.unsplash.com/photo-1561758033-d89a9ad46330?w=400',
            ],
            [
                'nom'         => 'Veggie Burger',
                'prix'        => 2800,
                'description' => 'Steak de légumes, hummus, roquette',
                'stock'       => 12,
                'image'       => 'https://images.unsplash.com/photo-1520072959219-c595dc870360?w=400',
            ],
            [
                'nom'         => 'BBQ Burger',
                'prix'        => 3200,
                'description' => 'Sauce BBQ maison, bacon, oignon caramélisé',
                'stock'       => 8,
                'image'       => 'https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?w=400',
            ],
            [
                'nom'         => 'Chicken Burger',
                'prix'        => 2700,
                'description' => 'Escalope de poulet croustillant, mayo',
                'stock'       => 18,
                'image'       => 'https://images.unsplash.com/photo-1606755962773-d324e0a13086?w=400',
            ],
            [
                'nom'         => 'Fish Burger',
                'prix'        => 2600,
                'description' => 'Filet de poisson pané, sauce tartare',
                'stock'       => 10,
                'image'       => 'https://images.unsplash.com/photo-1571091718767-18b5b1457add?w=400',
            ],
            [
                'nom'         => 'Mushroom Burger',
                'prix'        => 3100,
                'description' => 'Champignons sautés, gruyère fondu',
                'stock'       => 14,
                'image'       => 'https://images.unsplash.com/photo-1572802419224-296b0aeee0d9?w=400',
            ],
            [
                'nom'         => 'Bacon Crispy',
                'prix'        => 3400,
                'description' => 'Triple bacon, cheddar, sauce ranch',
                'stock'       => 9,
                'image'       => 'https://images.unsplash.com/photo-1551782450-a2132b4ba21d?w=400',
            ],
            [
                'nom'         => 'ISI Special',
                'prix'        => 4000,
                'description' => 'Notre burger signature — à découvrir !',
                'stock'       => 5,
                'image'       => 'https://images.unsplash.com/photo-1607013251379-e6eecfffe234?w=400',
            ],
        ];

        foreach ($produits as $produit) {
            Produit::firstOrCreate(['nom' => $produit['nom']], $produit);
        }
    }
}
