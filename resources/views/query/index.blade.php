<x-popup-layout>
    <div class="tw:p-[30px] tw:bg-pink01 tw:min-h-screen tw:p-2 tw:flex tw:flex-col" x-data="deleteForm()">
        <x-page-title>クエリ作成機能</x-page-title>
        <div class="tw:p-[10px] tw:mb-[20px] tw:flex tw:justify-between tw:gap-x-[10px] tw:bg-pink02">
            <div class="tw:flex tw:items-center tw:gap-x-[10px]">
                <div>クエリ名</div>
                <x-hozen.select name="" value=""  class="tw:!w-[300px]" :options="['1' => 'aaaa']" />
            </div>
            <div class="tw:flex tw:items-center tw:gap-x-[10px]">
                <x-button.gray>保存</x-button.gray>
                <x-button.gray>削除</x-button.gray>
                <x-button.gray>クリア</x-button.gray>
            </div>
        </div>
        <div class="tw:flex tw:gap-x-[30px]">
            <div class="tw:flex-1">
                <div class="tw:h-[30px] tw:px-[10px] tw:leading-[30px] tw:bg-pink02">
                    保守管理
                </div>
                <div>
                    <ul>
                        @foreach ($maintenance_columns as $column)
                            <li>{{ $column->name }}]{{ $column->comment }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-popup-layout>
