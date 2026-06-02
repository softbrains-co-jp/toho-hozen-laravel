<x-popup-layout>
    <div class="tw:p-[10px] tw:bg-pink01 tw:min-h-screen tw:flex tw:flex-col">
        <x-page-title class="tw:mb-0!">検索結果</x-page-title>


        <div class="tw:flex tw:items-center tw:gap-x-[20px] tw:mb-[10px]">
            <div class="tw:text-[10pt] tw:text-gray-600">
                {{ $records->count() }}件
                @if ($exceeded)
                    <span class="tw:text-red-600 tw:ml-[10px]">（1000件を超えるため先頭1000件を表示しています）</span>
                @endif
            </div>
        </div>
        @if ($records->isEmpty())
            <div class="tw:py-[30px] tw:text-center tw:text-gray-500">該当するデータがありません。</div>
        @else
            <div class="tw:overflow-auto tw:flex-1">
                <table class="hozen-table tw:w-full tw:whitespace-nowrap">
                    <thead class="tw:sticky tw:top-0">
                        <tr>
                            @foreach ($selectColumns as $col)
                                <th>{{ $columnLabels[$col] ?? $col }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $record)
                            <tr>
                                @foreach ($selectColumns as $col)
                                    <td class="tw:h-[25px] tw:leading-[25px]">{{ $record->$col }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-popup-layout>
