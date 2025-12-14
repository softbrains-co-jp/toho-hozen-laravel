<?php

namespace App\Http\Requests\Import;

use Illuminate\Foundation\Http\FormRequest;

class RelocationReceptionRequest extends FormRequest
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
            'relocation_receptions' => [
                'required',
                'array'
            ],
            'relocation_receptions.*' => [
                'file',
            ],
        ];
    }

    public function attributes() {
        return [
            'relocation_receptions' => '移設受付データファイル',
        ];
    }
}
