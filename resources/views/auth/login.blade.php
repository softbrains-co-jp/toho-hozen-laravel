<x-guest-layout title="システム管理ログイン">
    <div class="tw:py-[30px]">
        <img src="/images/logo.png" class="tw:m-auto">
    </div>
    <div class="tw:text-center">
        <div class="tw:inline-block" >
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <table class="hozen-table">
                    <tr>
                        <th class="tw:w-[130px] tw:text-right">ログインID</th>
                        <td class="tw:w-[300px]">
                            <x-input type="text" name="login_id" class="tw:input tw:text-[12pt]" required />
                        </td>
                    </tr>
                    <tr>
                        <th class="tw:w-[130px] tw:text-right">パスワード</th>
                        <td class="tw:w-[300px]">
                            <x-input type="password" name="password" class="tw:input tw:text-[12pt]" required />
                        </td>
                    </tr>
                </table>
                <div class="tw:pt-[20px]">
                    <x-button.gray type="submit">ログイン</x-button.gray>
                </div>
            </form>
            <div class="tw:pt-[20px]">
                総合TOPへ戻る
            </div>
        </div>
    </div>
</x-guest-layout>
