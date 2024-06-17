<?php

namespace App\Http\Requests\v1\sites;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSitesRequest extends FormRequest
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
                'location' => ['required', 'string',  ],
                'description' => ['nullable', 'string',  ],
                'date_of_create' => ['nullable', 'string',  ],
                'date_of_service' => ['nullable', 'string',  ],
                'images' => ['required', '',  ],
            ];
        }

        public function messages()
        {
            return [
                'name.required' => ':attribute est obligatoire!',
                'name.unique'   => ':attribute existe déjà.',
                'location.required' => ':attribute est obligatoire!',
                'location.unique'   => ':attribute existe déjà.',
                'image.required' => ':attribute est obligatoire!',
                'image.unique'   => ':attribute existe déjà.',
                'date_of_create.required' => ':attribute est obligatoire!',
                'date_of_create.unique'   => ':attribute existe déjà.',
                'date_of_service.required' => ':attribute est obligatoire!',
                'date_of_service.unique'   => ':attribute existe déjà.',
            ];
        }

        public function attributes()
        {
            return [
                'name' => 'Le nom du site ',
                'location' => 'La localisation',
                'images' => 'L\'images du site',
                'date_of_service' => 'La date de mise en service',
                'date_of_create' => 'La date de creation',
            ];
        }
    }
