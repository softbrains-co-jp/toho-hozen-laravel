<x-popup-layout>
    <div class="tw:p-[30px] tw:bg-pink01 tw:min-h-screen tw:p-2 tw:flex tw:flex-col" x-data="queryForm()">
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
                <div class="tw:h-[400px] tw:p-2 tw:bg-white tw:overflow-y-auto">
                    <ul>
                        @foreach ($maintenance_columns as $column)
                            <li
                                class="tw:cursor-pointer tw:px-1"
                                @click="selectColumn(@js($column->name), @js($maintenance_column_labels[$column->name] ?? $column->comment))"
                                :class="{ 'tw:bg-yellow-200': selectedColumn === @js($column->name) }"
                            >[{{ $column->name }}] {{ $maintenance_column_labels[$column->name] ?? $column->comment }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tw:w-[120px] tw:pt-[40px] tw:flex tw:flex-col tw:gap-y-[15px] tw:items-center">
                <x-button.gray class="tw:w-[100px] tw:h-[30px]" @click="addColumn()">追加</x-button.gray>
                <x-button.gray class="tw:w-[100px] tw:h-[30px]" @click="removeDisplayColumn()">削除</x-button.gray>
                <x-button.gray class="tw:w-[100px] tw:h-[30px]">条件</x-button.gray>
                <x-button.gray class="tw:w-[100px] tw:h-[30px]" @click="moveDisplayColumnToTop()"><i class="fa-solid fa-angles-up"></i></x-button.gray>
                <x-button.gray class="tw:w-[100px] tw:h-[30px]" @click="moveDisplayColumnUp()"><i class="fa-solid fa-angle-up"></i></x-button.gray>
                <x-button.gray class="tw:w-[100px] tw:h-[30px]" @click="moveDisplayColumnDown()"><i class="fa-solid fa-angle-down"></i></x-button.gray>
                <x-button.gray class="tw:w-[100px] tw:h-[30px]" @click="moveDisplayColumnToBottom()"><i class="fa-solid fa-angles-down"></i></x-button.gray>
            </div>
            <div class="tw:w-[500px]">
                <div class="tw:h-[30px] tw:px-[10px] tw:leading-[30px] tw:bg-pink02">
                     表示項目
                </div>
                <div class="tw:h-[400px] tw:p-2 tw:bg-white tw:overflow-y-auto">
                    <ul>
                        <template x-for="column in displayColumns" :key="column.name">
                            <li
                                class="tw:cursor-pointer tw:px-1"
                                @click="selectDisplayColumn(column.name)"
                                :class="{ 'tw:bg-yellow-200': selectedDisplayColumn === column.name }"
                                x-text="`[${column.name}] ${column.label ?? ''}`"
                            ></li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tw:mt-[20px]">
            <div class="tw:flex tw:bg-pink02">
                <div class="tw:w-[400px] tw:h-[30px] tw:pl-2 tw:leading-[30px] tw:border tw:border-gray-400">項目名</div>
                <div class="tw:h-[30px] tw:leading-[30px] tw:flex-1 tw:border-r tw:border-y tw:border-gray-400">検索条件</div>
                <div class="tw:w-[80px] tw:h-[30px] tw:leading-[30px] tw:border-r tw:border-y tw:border-gray-400"></div>
            </div>
            <div class="tw:flex">
                <div class="tw:w-[400px] tw:h-[30px] tw:leading-[30px] tw:pl-2 tw:bg-pink02 tw:border-x tw:border-b tw:border-gray-400">項目名</div>
                <div class="tw:h-[30px] tw:leading-[30px] tw:flex-1 tw:flex tw:border-b tw:border-gray-400">
                    <x-hozen.select name="apply_type" value="" empty=" " :options="[1=>'昇順', 2=>'降順']" class="tw:h-[30px]" />
                    <div class="tw:w-[400px] tw:shrink-0 tw:px-2 tw:bg-gray-200 tw:border-r tw:border-b tw:border-gray-100 tw:flex tw:gap-x-[20px]">
                        <x-forms.checkbox label="NULL" />
                        <x-forms.checkbox label="NOT NULL" />
                        <x-forms.checkbox label="空文字" />
                    </div>
                    <x-hozen.input name="apply_type" value="" empty=" " class="tw:h-[30px]" />
                </div>
                <div class="tw:h-[30px] tw:leading-[30px] tw:w-[80px] tw:border-r tw:border-b tw:border-gray-400">
                    <x-button.gray class="tw:h-[29px] tw:w-full tw:!p-0 tw:!min-w-0 tw:!rounded-none tw:border-0">削除</x-button.gray>
                </div>
            </div>
        </div>
    </div>
</x-popup-layout>
<script>
    function queryForm() {
        return {
            selectedColumn: null,
            selectedColumnLabel: null,
            selectedDisplayColumn: null,
            displayColumns: [],
            selectColumn(column, label) {
                this.selectedColumn = column;
                this.selectedColumnLabel = label;
            },
            addColumn() {
                if (!this.selectedColumn) {
                    return;
                }

                const exists = this.displayColumns.some((column) => column.name === this.selectedColumn);
                if (exists) {
                    this.selectedDisplayColumn = this.selectedColumn;
                    return;
                }

                this.displayColumns.push({
                    name: this.selectedColumn,
                    label: this.selectedColumnLabel,
                });
                this.selectedDisplayColumn = this.selectedColumn;
            },
            selectDisplayColumn(column) {
                this.selectedDisplayColumn = column;
            },
            removeDisplayColumn() {
                const index = this.selectedDisplayColumnIndex();
                if (index === -1) {
                    return;
                }

                this.displayColumns.splice(index, 1);
                this.selectedDisplayColumn = this.displayColumns[index]?.name ?? this.displayColumns[index - 1]?.name ?? null;
            },
            moveDisplayColumnToTop() {
                const index = this.selectedDisplayColumnIndex();
                if (index <= 0) {
                    return;
                }

                const [column] = this.displayColumns.splice(index, 1);
                this.displayColumns.unshift(column);
            },
            moveDisplayColumnUp() {
                const index = this.selectedDisplayColumnIndex();
                if (index <= 0) {
                    return;
                }

                this.swapDisplayColumns(index, index - 1);
            },
            moveDisplayColumnToBottom() {
                const index = this.selectedDisplayColumnIndex();
                if (index === -1 || index === this.displayColumns.length - 1) {
                    return;
                }

                const [column] = this.displayColumns.splice(index, 1);
                this.displayColumns.push(column);
            },
            moveDisplayColumnDown() {
                const index = this.selectedDisplayColumnIndex();
                if (index === -1 || index === this.displayColumns.length - 1) {
                    return;
                }

                this.swapDisplayColumns(index, index + 1);
            },
            selectedDisplayColumnIndex() {
                return this.displayColumns.findIndex((column) => column.name === this.selectedDisplayColumn);
            },
            swapDisplayColumns(from, to) {
                [this.displayColumns[from], this.displayColumns[to]] = [this.displayColumns[to], this.displayColumns[from]];
            },
        }
    }
</script>
