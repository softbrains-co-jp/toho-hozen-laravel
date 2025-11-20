<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
        $id = $this->input('id') ?? 0;
        $table = $this->input('table');

        return [
            'code' => [
                "unique:{$table},code,{$id},id"
            ],
            'sort' => [
                'integer',
            ],
        ];
    }

    public function attributes() {
        return [
            'code' => 'コード',
            'sort' => 'ID(並び順)	',
        ];
    }
}
