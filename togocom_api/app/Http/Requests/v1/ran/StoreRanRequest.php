<?php

namespace App\Http\Requests\v1\rfm;

use Illuminate\Foundation\Http\FormRequest;

class StoreRanRequest extends FormRequest
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
                'pylone_id' => ['required', 'numeric',],
                'bts_id' => ['required', 'numeric',  ],
                'rfm_id' => ['required', 'numeric',  ],
                'user_id' => ['required', 'numeric',  ],
            ];
        }

        public function messages()
        {
            return [
                'pylone_id.required' => ':attribute est obligatoire!',
                'bts_id.required' => ':attribute est obligatoire!',
                'rfm_id.required' => ':attribute est obligatoire!',
                'user_id.required' => ':attribute est obligatoire!',
                
            ];
        }

        public function attributes()
        {
            return [
                'pylone_id' => 'Le pylone',
                'bts_id' => 'BTS',
                'rfm_id' => 'RFM',
                'user_id' => '',
            ];
        }
    }
