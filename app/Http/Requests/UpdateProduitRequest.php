<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom'         => ['required', 'string', 'max:255'],
            'prix'        => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'url', 'max:500'],
            'stock'       => ['required', 'integer', 'min:0'],
            'archive'     => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'   => 'Le nom du produit est obligatoire.',
            'prix.required'  => 'Le prix est obligatoire.',
            'prix.numeric'   => 'Le prix doit être un nombre.',
            'prix.min'       => 'Le prix ne peut pas être négatif.',
            'image.url'      => 'L\'image doit être une URL valide.',
            'stock.required' => 'Le stock est obligatoire.',
            'stock.integer'  => 'Le stock doit être un nombre entier.',
            'stock.min'      => 'Le stock ne peut pas être négatif.',
        ];
    }
}
