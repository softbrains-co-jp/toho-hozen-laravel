<x-app-layout>
    <div class="tw:bg-pink01 tw:min-h-screen tw:p-2 tw:flex tw:flex-col">
        <x-page-title>ユーザ{{ $user->exists ? '編集' : '作成' }}</x-page-title>
        <x-error-message :errors="$errors" />
        <form method="post" action="{{ $user->exists ? route('user.edit.post', ['id' => $user->id]) : route('user.add.post') }}" x-ref="form">
            @csrf
            <table class="hozen-table tw:w-full">
                <colgroup>
                    <col class="tw:w-[150px]">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th>ログインID</th>
                        <td>
                            <x-forms.input type="text" name="login_id" value="{{ old('login_id', $user->login_id) }}" class="tw:!w-[300px]" required />
                        </td>
                    </tr>
                    <tr>
                        <th>パスワード</th>
                        <td>
                            <x-forms.input-password name="password" value="{{ old('password') }}" class="tw:!w-[300px]" :required="$user->exists ? false : true" placeholder="{{ $user->exists ? '変更する場合だけ入力してください' : '' }}" />
                        </td>
                    </tr>
                    <tr>
                        <th>名前</th>
                        <td>
                            <x-forms.input type="text" name="name" value="{{ old('name', $user->name) }}" class="tw:!w-[300px]" required />
                        </td>
                    </tr>
                    <tr>
                        <th>メールアドレス</th>
                        <td>
                            <x-forms.input type="text" name="email" value="{{ old('email', $user->email) }}" class="tw:!w-[300px]" required />
                        </td>
                    </tr>
                    <tr>
                        <th>権限</th>
                        <td>
                            <x-forms.select name="role" value="{{ old('role', $user->role) }}" empty=" " :options="App\Models\MstUser::ROLES" />
                        </td>
                    </tr>
                </tbody>
            <table>
            <div class="tw:mt-[20px] tw:flex tw:gap-x-[20px] tw:justify-center">
                <x-button.gray type="submit">更新</x-button.gray>
                <a href="{{ route('user.index') }}"><x-button.gray>キャンセル</x-button.gray></a>
            </div>
            <input type="hidden" name="id" value="{{ $user->id }}">
        </form>
    </div>
</x-app-layout>
