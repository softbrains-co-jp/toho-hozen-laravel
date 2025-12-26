<?php

namespace App\Http\Requests\Report;

use App\Models\Maintenance;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class UpdateRequest extends FormRequest
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
            'user_name' => [
                'exists:mst_member,name',
            ],
        ];
    }

    public function attributes() {
        return [
            'user_name' => 'ログインユーザー',
        ];
    }

    public function messages()
    {
        return [
            'user_name.exists' => '現在の:attributeは、チェック者マスタに登録されていませんので、更新処理を行えません。',
        ];
    }

    /**
     * バリデータにカスタムバリデーションを追加
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $maintenances = $this->input('maintenances', []);

            foreach ($maintenances as $index => $maintenance) {
                $tohCd = $maintenance['toh_cd'] ?? null;

                if ($tohCd && !Maintenance::where('toh_cd', $tohCd)->exists()) {
                    $validator->errors()->add(
                        "maintenances.{$index}.'toh_cd'",
                        "管理番号[{$tohCd}]が見つかりません。"
                    );
                }
            }
        });
    }

    /**
     * バリデーション用のデータを準備
     */
    protected function prepareForValidation(): void
    {
        // ログインユーザーのnameをバリデーション対象に追加
        $this->merge([
            'user_name' => Auth::user()?->name,
        ]);
    }
}
