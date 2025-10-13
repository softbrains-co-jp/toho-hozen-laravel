<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainRequest extends FormRequest
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
        $code = $this->input('key_cd');

        return [
            'kddi_cd' => [
                'unique:maintenance,kddi_cd,' . $code . ',toh_cd'
            ],
            'toh_cd' => [
                'unique:maintenance,toh_cd,' . $code . ',toh_cd'
            ],
            'check_date' => [
                'nullable',
                'date'
            ]
        ];
    }

    public function attributes() {
        return [
            'kddi_cd' => 'KDDI管理番号',
            'toh_cd' => 'TOH管理番号',
            'check_date' => 'チェック日',
        ];
    }
}
