<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
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
        // dd($this->input('action'));

        return [
            'action' => [
                'required',
                'string'
            ],
            'export01_from' => [
                'nullable',
                'required_if:action,export01',
                'date',
            ],
            'export01_to' => [
                'nullable',
                'required_if:action,export01',
                'date',
            ],
            'export02' => [
                'nullable',
                'required_if:action,export02_1',
                'required_if:action,export02_2',
                'date',
            ],
            'export03_from' => [
                'nullable',
                'required_if:action,export03',
                'date',
            ],
            'export03_to' => [
                'nullable',
                'required_if:action,export03',
                'date',
            ],
            'export04' => [
                'nullable',
                'required_if:action,export04',
                'date',
            ],
            'export06' => [
                'nullable',
                'required_if:action,export06',
                'date',
            ],
            'export07' => [
                'nullable',
                'required_if:action,export07',
                'date',
            ],
            'export08' => [
                'nullable',
                'required_if:action,export08_1',
                'required_if:action,export08_2',
                'date',
            ],
            'export09_from' => [
                'nullable',
                'required_if:action,export09_1',
                'required_if:action,export09_2',
                'date',
            ],
            'export09_to' => [
                'nullable',
                'required_if:action,export09_1',
                'required_if:action,export09_2',
                'date',
            ],
            'export10' => [
                'nullable',
                'required_if:action,export10',
            ],
            'export11' => [
                'nullable',
                'required_if:action,export11',
            ],
        ];
    }

    public function attributes() {
        return [
            'export01_from' => '付託日(From)',
            'export01_to' => '付託日(To)',
            'export02' => '保守作業報告日',
            'export03_from' => '期限(From)',
            'export03_to' => '期限(To)',
            'export04' => '作業日報報告日',
            'export06' => 'チェック日',
            'export07' => '予定日',
            'export08' => 'KDDI精算月',
            'export09_from' => 'KDDI依頼日(From)',
            'export09_to' => 'KDDI依頼日(To)',
            'export10' => 'チェック者',
            'export11' => 'TOH管理番号',
        ];
    }

    public function messages()
    {
        return [
            '*.required_if' => ':attributeを入力してください。',
        ];
    }
}
