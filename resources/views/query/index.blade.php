<x-popup-layout>
    <div class="tw:p-[30px] tw:bg-pink01 tw:min-h-screen tw:p-2 tw:flex tw:flex-col" x-data="queryForm(@js($query_preset_data), @js($query_column_labels), @js($query_column_meta))">
        <div
            x-show="isProcessing"
            x-cloak
            style="display: none;"
            class="tw:fixed tw:inset-0 tw:z-[100] tw:flex tw:items-center tw:justify-center tw:bg-black/50"
        >
            <div class="tw:bg-white tw:border tw:border-gray-400 tw:px-[40px] tw:py-[30px] tw:text-center tw:text-[14pt]">
                <div>処理中です。</div>
                <div>しばらくお待ちください</div>
            </div>
        </div>
        <x-page-title>クエリ作成機能</x-page-title>
        <form method="post" action="{{ route('query.store') }}" x-ref="saveForm">
            @csrf
            <input type="hidden" name="query_preset_id" :value="selectedPresetId">
            <input type="hidden" name="display_columns" :value="displayColumnsJson()">
            <input type="hidden" name="conditions" :value="conditionsJson()">
            <div class="tw:p-[10px] tw:mb-[20px] tw:flex tw:justify-between tw:gap-x-[10px] tw:bg-pink02">
                <div class="tw:flex tw:items-center tw:gap-x-[10px]">
                    <div>クエリ名</div>
                    <x-hozen.select name="" value="" empty=" " class="tw:!w-[300px]" :options="$query_preset_options" x-model="selectedPresetId" @change="loadSelectedPreset()" />
                </div>
                @if(auth()->user()->role === \App\Models\MstUser::ROLE_ADMIN)
                    <div class="tw:flex tw:items-center tw:gap-x-[10px]">
                        <x-button.gray @click="openSaveModal()">保存</x-button.gray>
                        <x-button.gray @click="deletePreset()">削除</x-button.gray>
                        <x-button.gray @click="clearQuery()">クリア</x-button.gray>
                    </div>
                @endif
            </div>
            <div
                x-show="isSaveModalOpen"
                x-cloak
                style="display: none;"
                class="tw:fixed tw:inset-0 tw:z-50 tw:flex tw:items-center tw:justify-center tw:bg-black/40"
            >
                <div class="tw:w-[420px] tw:bg-white tw:border tw:border-gray-500 tw:p-4">
                    <div class="tw:mb-3 tw:text-[12pt]">クエリ名</div>
                    <x-hozen.input name="name" value="" x-model="presetName" class="tw:!w-full" @keydown.enter.prevent="submitSave()" />
                    <div class="tw:mt-4 tw:flex tw:justify-end tw:gap-x-2">
                        <x-button.gray @click="closeSaveModal()">キャンセル</x-button.gray>
                        <x-button.gray @click="submitSave()">保存</x-button.gray>
                    </div>
                </div>
            </div>
        </form>
        <form method="post" x-ref="deleteForm" class="tw:hidden">
            @csrf
            @method('DELETE')
        </form>
        <div class="tw:flex tw:gap-x-[30px]">

            @if(auth()->user()->role === \App\Models\MstUser::ROLE_ADMIN)            
                <div class="tw:w-[450px]">
                    <div class="tw:h-[30px] tw:px-[10px] tw:leading-[30px] tw:bg-pink02">
                        保守管理
                    </div>
                    <div class="tw:h-[400px] tw:p-2 tw:bg-white tw:overflow-y-auto">
                        <ul>
                            @foreach ($maintenance_columns as $column)
                                <li
                                    class="tw:cursor-pointer tw:px-1"
                                    @click="selectColumn(@js($column->name), @js($maintenance_column_labels[$column->name] ?? $column->comment))"
                                    :class="{ 'tw:bg-red-50': selectedColumn === @js($column->name) }"
                                >[{{ $column->name }}] {{ $maintenance_column_labels[$column->name] ?? $column->comment }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tw:w-[120px] tw:pt-[40px] tw:flex tw:flex-col tw:gap-y-[15px] tw:items-center">
                    <x-button.gray class="tw:w-[100px] tw:h-[30px]" @click="addColumn()">追加</x-button.gray>
                    <x-button.gray class="tw:w-[100px] tw:h-[30px]" @click="removeDisplayColumn()">削除</x-button.gray>
                    <x-button.gray class="tw:w-[100px] tw:h-[30px]" @click="addConditionColumn()">条件</x-button.gray>
                    <x-button.gray class="tw:w-[100px] tw:h-[30px]" @click="moveDisplayColumnToTop()"><i class="fa-solid fa-angles-up"></i></x-button.gray>
                    <x-button.gray class="tw:w-[100px] tw:h-[30px]" @click="moveDisplayColumnUp()"><i class="fa-solid fa-angle-up"></i></x-button.gray>
                    <x-button.gray class="tw:w-[100px] tw:h-[30px]" @click="moveDisplayColumnDown()"><i class="fa-solid fa-angle-down"></i></x-button.gray>
                    <x-button.gray class="tw:w-[100px] tw:h-[30px]" @click="moveDisplayColumnToBottom()"><i class="fa-solid fa-angles-down"></i></x-button.gray>
                </div>
            @endif
            <div class="tw:flex-1">
                <div class="tw:h-[30px] tw:px-[10px] tw:leading-[30px] tw:bg-pink02">
                     表示項目
                </div>
                <div class="tw:h-[400px] tw:p-2 tw:bg-white tw:overflow-y-auto">
                    <ul>
                        <template x-for="column in displayColumns" :key="column.name">
                            <li
                                class="tw:cursor-pointer tw:px-1"
                                @click="selectDisplayColumn(column.name)"
                                :class="{ 'tw:bg-red-50': selectedDisplayColumn === column.name }"
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
                <div class="tw:h-[30px] tw:leading-[30px] tw:px-[5px] tw:flex-1 tw:border-r tw:border-y tw:border-gray-400">検索条件</div>
                @if(auth()->user()->role === \App\Models\MstUser::ROLE_ADMIN)
                    <div class="tw:w-[80px] tw:h-[30px] tw:leading-[30px] tw:border-r tw:border-y tw:border-gray-400"></div>
                @endif
            </div>
            <template x-for="(condition, index) in conditionColumns" :key="condition.id">
                <div class="tw:flex">
                    <div
                        class="tw:w-[400px] tw:h-[30px] tw:leading-[30px] tw:pl-2 tw:bg-pink02 tw:border-x tw:border-b tw:border-gray-400"
                        x-text="`[${condition.name}] ${condition.label ?? ''}`"
                    ></div>
                    <div class="tw:h-[30px] tw:leading-[30px] tw:flex-1 tw:flex tw:border-b tw:border-gray-400">
                        <x-hozen.select name="" value="" empty=" " :options="[1=>'昇順', 2=>'降順']" class="tw:h-[30px] tw:!w-[80px]" x-model="condition.sort" x-bind:name="`conditions[${index}][sort]`" />
                        <div class="tw:w-[350px] tw:shrink-0 tw:px-2 tw:bg-gray-200 tw:border-r tw:border-b tw:border-gray-100 tw:flex tw:gap-x-[16px]">
                            <x-forms.checkbox label="NULL" value="1" x-model="condition.isNull" x-bind:name="`conditions[${index}][is_null]`" />
                            <x-forms.checkbox label="NOT NULL" value="1" x-model="condition.isNotNull" x-bind:name="`conditions[${index}][is_not_null]`" />
                            <x-forms.checkbox label="空文字" value="1" x-show="condition.type !== 'date'" x-model="condition.isEmpty" x-bind:name="`conditions[${index}][is_empty]`" />
                            <x-forms.checkbox label="LIKE" value="1" x-show="condition.type == 'text'" x-model="condition.isLike" x-bind:name="`conditions[${index}][is_like]`" />
                        </div>
                        <x-hozen.input name="" value="" empty=" " class="tw:h-[30px] tw:flex-1" x-show="condition.type !== 'date' && condition.type !== 'master'" x-model="condition.value" x-bind:name="`conditions[${index}][value]`" />
                        <div class="tw:flex tw:items-center tw:gap-x-1 tw:flex-1" x-show="condition.type === 'date'">
                            <x-hozen.input-date value="" class="tw:!h-[30px] tw:flex-1 tw:shrink-0"
                                @change="condition.dateFrom = $event.target.value"
                                x-effect="if ($el._flatpickr) $el._flatpickr.setDate(condition.dateFrom, false)"
                            />
                            <span class="tw:shrink-0 tw:px-1">〜</span>
                            <x-hozen.input-date value="" class="tw:!h-[30px] tw:flex-1 tw:shrink-0"
                                @change="condition.dateTo = $event.target.value"
                                x-effect="if ($el._flatpickr) $el._flatpickr.setDate(condition.dateTo, false)"
                            />
                        </div>
                        <select class="tw:select tw:select-bordered tw:h-[30px] tw:bg-white tw:!pl-[5px] tw:flex-1 tw:text-[0.85rem]" x-show="condition.type === 'master'" x-model="condition.value">
                            <option value=""></option>
                            <template x-for="opt in getMasterOptions(condition.name)" :key="opt.code">
                                <option :value="opt.code" x-text="opt.label"></option>
                            </template>
                        </select>
                        <input type="hidden" x-model="condition.name" x-bind:name="`conditions[${index}][field]`">
                    </div>
                    @if(auth()->user()->role === \App\Models\MstUser::ROLE_ADMIN)
                        <div class="tw:h-[30px] tw:leading-[30px] tw:w-[80px] tw:border-r tw:border-b tw:border-gray-400">
                            <x-button.gray class="tw:h-[29px] tw:w-full tw:!p-0 tw:!min-w-0 tw:!rounded-none tw:border-0" @click="removeConditionColumn(index)">削除</x-button.gray>
                        </div>
                    @endif
                </div>
            </template>
        </div>
        <form method="get" action="{{ route('query.csv') }}" x-ref="csvForm" class="tw:hidden">
            <input type="hidden" name="display_columns" x-ref="csvDisplayColumns">
            <input type="hidden" name="conditions" x-ref="csvConditions">
            <input type="hidden" name="download_token" x-ref="csvDownloadToken">
        </form>
        <div class="tw:mt-[50px] tw:flex tw:justify-center tw:gap-x-[40px]">
            <x-button.blue class="tw:w-[150px] tw:h-[40px]" @click="submitSearch()">検索する</x-button.blue>
            <x-button.gray class="tw:w-[150px] tw:h-[40px]" @click="submitCsv()">CSVで出力</x-button.gray>
        </div>
    </div>
</x-popup-layout>
<script>
    function queryForm(queryPresets, columnLabels, columnMeta) {
        return {
            queryPresets,
            columnLabels,
            columnMeta,
            selectedPresetId: '',
            selectedColumn: null,
            selectedColumnLabel: null,
            selectedDisplayColumn: null,
            isSaveModalOpen: false,
            isProcessing: false,
            presetName: '',
            displayColumns: [],
            conditionColumns: [],
            conditionColumnId: 1,
            selectColumn(column, label) {
                this.selectedColumn = column;
                this.selectedColumnLabel = label;
                this.selectedDisplayColumn = null;
            },
            addColumn() {
                if (!this.selectedColumn) {
                    return;
                }

                const exists = this.displayColumns.some((column) => column.name === this.selectedColumn);
                if (exists) {
                    this.selectedDisplayColumn = null;
                    return;
                }

                this.displayColumns.push({
                    name: this.selectedColumn,
                    label: this.selectedColumnLabel,
                });
                this.selectedDisplayColumn = null;
            },
            addConditionColumn() {
                let name, label;
                if (this.selectedColumn) {
                    name = this.selectedColumn;
                    label = this.selectedColumnLabel;
                } else if (this.selectedDisplayColumn) {
                    const col = this.displayColumns.find(c => c.name === this.selectedDisplayColumn);
                    if (!col) return;
                    name = col.name;
                    label = col.label;
                } else {
                    return;
                }

                this.conditionColumns.push({
                    id: this.conditionColumnId++,
                    name,
                    label,
                    type: this.getColumnType(name),
                    sort: '',
                    value: '',
                    dateFrom: '',
                    dateTo: '',
                    isNull: false,
                    isNotNull: false,
                    isEmpty: false,
                    isLike: false,
                });
            },
            removeConditionColumn(index) {
                this.conditionColumns.splice(index, 1);
            },
            selectDisplayColumn(column) {
                this.selectedDisplayColumn = column;
                const selected = this.displayColumns.find((displayColumn) => displayColumn.name === column);
                if (selected) {
                    this.selectedColumn = selected.name;
                    this.selectedColumnLabel = selected.label;
                }
                this.selectedColumn = null;
                this.selectedColumnLabel = null;
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
            loadSelectedPreset() {
                const preset = this.queryPresets[this.selectedPresetId];
                if (!preset) {
                    this.clearQuery();
                    return;
                }

                this.presetName = preset.name ?? '';
                this.displayColumns = (preset.display_columns ?? [])
                    .map((column) => this.makeColumn(column.field ?? column.name))
                    .filter(Boolean);
                this.conditionColumns = (preset.conditions ?? [])
                    .map((condition) => {
                        const column = this.makeColumn(condition.field ?? condition.name);
                        if (!column) {
                            return null;
                        }

                        const type = this.getColumnType(column.name);

                        return {
                            id: this.conditionColumnId++,
                            name: column.name,
                            label: column.label,
                            type,
                            sort: condition.sort ?? '',
                            value: condition.value ?? '',
                            dateFrom: condition.date_from ?? '',
                            dateTo: condition.date_to ?? '',
                            isNull: this.isTruthy(condition.is_null ?? condition.isNull) || condition.operator === 'null',
                            isNotNull: this.isTruthy(condition.is_not_null ?? condition.isNotNull) || condition.operator === 'not_null',
                            isEmpty: type !== 'date' && (this.isTruthy(condition.is_empty ?? condition.isEmpty) || condition.operator === 'empty'),
                            isLike: type === 'text' && (this.isTruthy(condition.is_like ?? condition.isLike) || condition.operator === 'like'),
                        };
                    })
                    .filter(Boolean);
                this.selectedColumn = null;
                this.selectedColumnLabel = null;
                this.selectedDisplayColumn = this.displayColumns[0]?.name ?? null;
            },
            makeColumn(field) {
                if (!field || !Object.prototype.hasOwnProperty.call(this.columnLabels, field)) {
                    return null;
                }

                return {
                    name: field,
                    label: this.columnLabels[field],
                };
            },
            clearQuery() {
                this.selectedColumn = null;
                this.selectedColumnLabel = null;
                this.selectedDisplayColumn = null;
                this.presetName = '';
                this.displayColumns = [];
                this.conditionColumns = [];
            },
            openSaveModal() {
                this.isSaveModalOpen = true;
                this.$nextTick(() => {
                    const input = this.$el.querySelector('input[name="name"]');
                    input?.focus();
                });
            },
            closeSaveModal() {
                this.isSaveModalOpen = false;
            },
            submitSave() {
                if (!this.presetName.trim()) {
                    return;
                }

                if (this.selectedPresetId && !confirm('選択中のクエリを上書き保存します。よろしいですか？')) {
                    return;
                }

                this.$refs.saveForm.submit();
            },
            displayColumnsJson() {
                return JSON.stringify(this.displayColumns.map((column) => ({
                    field: column.name,
                })));
            },
            conditionsJson() {
                return JSON.stringify(this.conditionColumns.map((condition) => ({
                    field: condition.name,
                    type: condition.type,
                    sort: condition.sort,
                    value: condition.value,
                    date_from: condition.dateFrom,
                    date_to: condition.dateTo,
                    is_null: condition.isNull,
                    is_not_null: condition.isNotNull,
                    is_empty: condition.isEmpty,
                    is_like: condition.isLike,
                })));
            },
            getColumnType(name) {
                return this.columnMeta[name]?.type ?? 'text';
            },
            isTruthy(value) {
                return value === true || value === 1 || value === '1';
            },
            getMasterOptions(name) {
                const options = this.columnMeta[name]?.options ?? {};
                return Object.entries(options).map(([code, label]) => ({ code, label }));
            },
            deletePreset() {
                if (!this.selectedPresetId) {
                    alert('削除するクエリを選択してください。');
                    return;
                }
                if (!confirm('選択中のクエリを削除します。よろしいですか？')) {
                    return;
                }

                this.$refs.deleteForm.action = '{{ url('query') }}/' + this.selectedPresetId;
                this.$refs.deleteForm.submit();
            },
            submitSearch() {
                if (this.displayColumns.length === 0) {
                    alert('出力項目を設定してください。');
                    return;
                }
                const params = new URLSearchParams({
                    display_columns: this.displayColumnsJson(),
                    conditions: this.conditionsJson(),
                });
                window.open(
                    '{{ route('query.search') }}?' + params.toString(),
                    'querySearchResult',
                    'width=1400,height=800,scrollbars=yes,resizable=yes'
                );
            },
            submitCsv() {
                if (this.displayColumns.length === 0) {
                    alert('出力項目を設定してください。');
                    return;
                }
                const hasSortOrder = this.conditionColumns.some(c => c.sort !== '' && c.sort !== null && c.sort !== undefined);
                if (!hasSortOrder) {
                    alert('並び順を指定してください。');
                    return;
                }

                const token = Math.random().toString(36).substring(2);
                this.$refs.csvDisplayColumns.value = this.displayColumnsJson();
                this.$refs.csvConditions.value = this.conditionsJson();
                this.$refs.csvDownloadToken.value = token;
                this.$refs.csvForm.submit();

                this.isProcessing = true;
                const pollInterval = setInterval(() => {
                    if (document.cookie.split(';').some(c => c.trim().startsWith('download_token=' + token))) {
                        clearInterval(pollInterval);
                        this.isProcessing = false;
                        document.cookie = 'download_token=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
                    }
                }, 300);
                setTimeout(() => {
                    clearInterval(pollInterval);
                    this.isProcessing = false;
                }, 60000);
            },
        }
    }
</script>
