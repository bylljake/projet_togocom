<?php

namespace App\Http\Requests\v1\equipement;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipementsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string',  'max:155'],
            'type' => ['required', 'string',  ],
            'description' => ['nullable', 'string',  ],
            'superficie' => ['nullable', 'numeric',  ],
            'quantity' => ['required', 'string',  ],
            'sites_id' => ['required', '',  ],
            'images' => ['required', '',  ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute est obligatoire!',
            'name.unique'   => ':attribute existe déjà.',
            'type.required' => ':attribute est obligatoire!',
            'type.unique'   => ':attribute existe déjà.',
            'image.required' => ':attribute est obligatoire!',
            'image.unique'   => ':attribute existe déjà.',
            'quantity.required' => ':attribute est obligatoire!',
            'quantity.unique'   => ':attribute existe déjà.',
            'sites_id.required' => ':attribute est obligatoire!',
            'sites_id.unique'   => ':attribute existe déjà.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Le nom d\'equipement ',
            'type' => 'Le type',
            'images' => 'L\'images du site',
            'quantity' => 'Quantité',
            'site_id' => 'Le site ',
        ];
    }
}
