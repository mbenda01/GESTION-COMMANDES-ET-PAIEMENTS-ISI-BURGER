<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaiementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'montant' => ['required', 'numeric', 'min:0'],
            'mode'    => ['required', 'in:especes'],
        ];
    }

    public function messages(): array
    {
        return [
            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric'  => 'Le montant doit être un nombre.',
            'montant.min'      => 'Le montant ne peut pas être négatif.',
            'mode.required'    => 'Le mode de paiement est obligatoire.',
            'mode.in'          => 'Seul le paiement en espèces est accepté.',
        ];
    }
}
