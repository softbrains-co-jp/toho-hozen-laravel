<?php

namespace App\Http\Requests\Import;

use Illuminate\Foundation\Http\FormRequest;

class DailyReportRequest extends FormRequest
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
            'daily_reports' => [
                'required',
                'array'
            ],
            'daily_reports.*' => [
                'file',
            ],
        ];
    }

    public function attributes() {
        return [
            'daily_reports' => '作業日報ファイル',
        ];
    }
}
