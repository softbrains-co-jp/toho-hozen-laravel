@props([
    'code' => '',
])
<div class="tw:bg-pink01 tw:p-2 tw:h-full">
    <div class="tw:mb-5">
        <img src="/images/logo.png" class="tw:m-auto">
    </div>
    <div class="tw:border tw:border-gray-300 tw:text-center tw:p-1 tw:mb-5">
        {{ now()->format('Y/m/d') }}
    </div>
    <div class="tw:mb-5">
        <div class="tw:border tw:border-gray-300 tw:border-b-0 tw:text-center tw:p-1 tw:bg-pink02">
            ログインユーザー
        </div>
        <div class="tw:border tw:border-gray-300 tw:text-center tw:p-1">
            {{ $user->id }}：{{ $user->name }}
        </div>
    </div>
    <div class="tw:mb-5">
        <div class="tw:border tw:border-gray-300 tw:border-b-0 tw:text-center tw:p-1 tw:bg-pink02">
            TOH管理番号
        </div>
        <div class="tw:border tw:border-gray-300 tw:text-center tw:p-1 tw:text-red-500">
            {{ $code }}
        </div>
        @if ($code)
            <div class="tw:border tw:border-gray-300 tw:text-center tw:p-1">
                <x-button.gray>解除</x-button.gray>
            </div>
        @endif

    </div>
    <div class="tw:mb-5">
        ■保守管理
        <ul>
            <li>
                <a href="{{ route('main.index') }}">
                    <x-button.gray type="button" class="tw:w-full">保守管理表</x-button.gray>
                </a>
            </li>
        </ul>
    </div>
    <div class="tw:mb-5">
        <ul>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-button.gray type="submit" class="tw:w-full">ログアウト</x-button.gray>
                </form>
            </li>
        </ul>
    </div>
</div>
