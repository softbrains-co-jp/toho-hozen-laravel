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
            {{ $user->login_id }}：{{ $user->name }}
        </div>
    </div>
    <div class="tw:mb-5">
        <div class="tw:border tw:border-gray-300 tw:border-b-0 tw:text-center tw:p-1 tw:bg-pink02">
            TOH管理番号
        </div>
        <div class="tw:border tw:border-gray-300 tw:text-center tw:p-1 tw:text-red-500">
            {{ session('exclusion_toh_cd') }}
        </div>
        @if (session('exclusion_toh_cd'))
            <form method="post" action="{{ route('main.release', ['code' => session('exclusion_toh_cd')]) }}">
                <div class="tw:border tw:border-gray-300 tw:text-center tw:p-1">
                    @csrf
                    @method('PATCH')
                    <x-button.gray type="submit">解除</x-button.gray>
                </div>
            </form>
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
            <li class="tw:mt-[3px]">
                <a href="{{ route('search.index') }}">
                    <x-button.gray type="button" class="tw:w-full">複合条件検索</x-button.gray>
                </a>
            </li>
            <li class="tw:mt-[3px]">
                <a href="{{ route('import.index') }}">
                    <x-button.gray type="button" class="tw:w-full">帳票インポート</x-button.gray>
                </a>
            </li>
            <li class="tw:mt-[3px]">
                <a href="{{ route('export.index') }}">
                    <x-button.gray type="button" class="tw:w-full">帳票エクスポート</x-button.gray>
                </a>
            </li>
            <li class="tw:mt-[3px]">
                <a href="{{ route('maintenance-report.index') }}">
                    <x-button.gray type="button" class="tw:w-full">工事進捗</x-button.gray>
                </a>
            </li>
        </ul>
    </div>
    <div class="tw:mb-5">
        ■マスタ管理
        <ul>
            <li>
                <a href="{{ route('master.index', ['kind' => 'branch']) }}">
                    <x-button.gray type="button" class="tw:w-full">支社</x-button.gray>
                </a>
            </li>
            <li class="tw:mt-[3px]">
                <a href="{{ route('master.index', ['kind' => 'trader']) }}">
                    <x-button.gray type="button" class="tw:w-full">施工業者</x-button.gray>
                </a>
            </li>
            <li class="tw:mt-[3px]">
                <a href="{{ route('master.index', ['kind' => 'request']) }}">
                    <x-button.gray type="button" class="tw:w-full">依頼種別</x-button.gray>
                </a>
            </li>
            <li class="tw:mt-[3px]">
                <a href="{{ route('master.index', ['kind' => 'status']) }}">
                    <x-button.gray type="button" class="tw:w-full">工事進捗ステータス</x-button.gray>
                </a>
            </li>
            <li class="tw:mt-[3px]">
                <a href="{{ route('master.index', ['kind' => 'member']) }}">
                    <x-button.gray type="button" class="tw:w-full">チェック者</x-button.gray>
                </a>
            </li>
            <li class="tw:mt-[3px]">
                <a href="{{ route('master.index', ['kind' => 'setup']) }}">
                    <x-button.gray type="button" class="tw:w-full">移設種別</x-button.gray>
                </a>
            </li>
            <li class="tw:mt-[3px]">
                <a href="{{ route('master.index', ['kind' => 'road']) }}">
                    <x-button.gray type="button" class="tw:w-full">道路種別</x-button.gray>
                </a>
            </li>
            <li class="tw:mt-[3px]">
                <a href="{{ route('master.index', ['kind' => 'apply']) }}">
                    <x-button.gray type="button" class="tw:w-full">申請種別</x-button.gray>
                </a>
            </li>
            <li class="tw:mt-[3px]">
                <a href="{{ route('master.index', ['kind' => 'kddi']) }}">
                    <x-button.gray type="button" class="tw:w-full">KDDI報告種別</x-button.gray>
                </a>
            </li>
        </ul>
    </div>
    <div class="tw:mb-5">
        ■排他処理
        <ul>
            <li>
                <a href="{{ route('exclusion.index') }}">
                    <x-button.gray type="button" class="tw:w-full">管理番号一覧</x-button.gray>
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
