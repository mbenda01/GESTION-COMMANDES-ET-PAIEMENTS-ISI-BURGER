<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommandeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'produits'              => ['required', 'array', 'min:1'],
            'produits.*.id'         => ['required', 'exists:produits,id'],
            'produits.*.quantite'   => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'produits.required'            => 'Veuillez sélectionner au moins un burger.',
            'produits.array'               => 'Format de commande invalide.',
            'produits.min'                 => 'Veuillez sélectionner au moins un burger.',
            'produits.*.id.required'       => 'Produit invalide.',
            'produits.*.id.exists'         => 'Ce produit n\'existe pas.',
            'produits.*.quantite.required' => 'La quantité est obligatoire.',
            'produits.*.quantite.min'      => 'La quantité minimale est 1.',
        ];
    }
}
