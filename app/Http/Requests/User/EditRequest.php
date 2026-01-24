<?php

namespace App\Http\Requests\User;

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
        $id = $this->input('id') ?: 0;

        return [
            'login_id' => [
                "unique:mst_users,login_id,{$id},id"
            ],
            'password' => [
                'required_without:id',
            ],
            'name' => [
                'required'
            ],
            'email' => [
                'required',
                'email',
                "unique:mst_users,email,{$id},id",
            ],
            'role' => [
                'required'
            ],
        ];
    }

    public function attributes() {
        return [
            'login_id' => 'ログインID',
            'password' => 'パスワード',
            'name' => '名前',
            'email' => 'メールアドレス',
            'role' => '権限',
        ];
    }
}
