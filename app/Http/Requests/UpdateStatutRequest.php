<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'statut' => ['required', 'in:en_attente,en_preparation,prete,payee,annulee'],
        ];
    }

    public function messages(): array
    {
        return [
            'statut.required' => 'Le statut est obligatoire.',
            'statut.in'       => 'Le statut sélectionné est invalide.',
        ];
    }
}
