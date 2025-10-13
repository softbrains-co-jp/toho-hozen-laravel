@livewireScripts
<x-app-layout :code="$code">
    <form method="post" action="{{ route('main.post', [$code]) }}"  x-data="mainForm()" x-ref="form">
        <input type="hidden" name="key_cd" value="{{ $maintenance->toh_cd }}">
        @csrf
        <div class="tw:grid tw:grid-rows-[1fr_100px] tw:gap-[10px] tw:h-screen">
            <div class="tw:rows-start-1 tw:rows-end-2 tw:bg-pink01 tw:p-2">
                <x-error-message :errors="$errors" />
                <x-flash-message />
                <x-page-title>保守管理表</x-page-title>
                ■基本情報
                <table class="hozen-table tw:w-full">
                    <colgroup>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th class="tw:w-[15%]">
                                KDDI管理番号
                            </th>
                            <td>
                                <x-input type="text" name="kddi_cd" value="{{ old('kddi_cd', $maintenance->kddi_cd) }}" maxlength="20" required />
                            </td>
                            <th class="tw:w-[15%]">
                                TOH管理番号
                            </th>
                            <td>
                                <x-input type="text" name="toh_cd" value="{{ old('toh_cd', $maintenance->toh_cd) }}" maxlength="20" required />
                            </td>
                            <th class="tw:w-[15%]">
                                関連番号
                            </th>
                            <td>
                                <x-input type="text" name="relation_cd" maxlength="20" value="{{ old('relation_cd', $maintenance->relation_cd) }}" />
                            </td>
                        </tr>
                    <tr>
                        <th class="tw:w-[15%]">
                            支社
                        </th>
                        <td colspan="5">
                            <x-select name="branch_cd" value="{{ old('branch_cd', $maintenance->branch_cd) }}" empty=" " :options="$branches" />
                        </td>
                    </tr>
                    <tr>
                        <th class="tw:w-[15%]">
                            移設種別
                        </th>
                        <td>
                            <x-select name="setup_cd" value="{{ old('setup_cd', $maintenance->setup_cd) }}" empty=" " :options="$setups" />
                        </td>
                        <th class="tw:w-[15%]">
                            依頼種別
                        </th>
                        <td>
                            <x-select name="request_cd" value="{{ old('request_cd', $maintenance->request_cd) }}" empty=" " :options="$requests" />
                        </td>
                        <th class="tw:w-[15%]">
                            契約種別
                        </th>
                        <td>
                            <x-input type="text" name="contract_type" value="{{ old('contract_type', $maintenance->contract_type) }}" maxlength="20" />
                        </td>
                    </tr>
                    <tr>
                        <th class="tw:w-[15%]">
                            作業内容
                        </th>
                        <td colspan="5">
                            <x-textarea name="work_notes" rows="4">{{ old('work_notes', $maintenance->work_notes) }}</x-textarea>
                        </td>
                    </tr>
                    <tr>
                        <th class="tw:w-[15%]">
                            指示内容
                        </th>
                        <td colspan="5">
                            <x-textarea name="order_notes" rows="4">{{ old('order_notes', $maintenance->order_notes) }}</x-textarea>
                        </td>
                    </tr>
                    <tr>
                        <th class="tw:w-[15%]">
                            現場住所
                        </th>
                        <td colspan="5">
                            <x-input type="text" name="work_address" value="{{ old('work_address', $maintenance->work_address) }}" maxlength="120" />
                        </td>
                    </tr>
                    <tr>
                        <th class="tw:w-[15%]">
                            電柱番号
                        </th>
                        <td colspan="5">
                            <x-input type="text" name="pole_cd" value="{{ old('pole_cd', $maintenance->pole_cd) }}" maxlength="50" class="tw:!w-[600px]" />
                        </td>
                    </tr>
                    <tr>
                        <th class="tw:w-[15%]">
                            道路種別
                        </th>
                        <td>
                            <x-select name="road_cd" value="{{ old('road_cd', $maintenance->road_cd) }}" empty=" " :options="$roads" />
                        </td>
                        <th class="tw:w-[15%]">
                            工事進捗ステータス
                        </th>
                        <td>
                            <x-select name="status_cd" value="{{ old('status_cd', $maintenance->status_cd) }}" empty=" " :options="$status" />
                        </td>
                        <th class="tw:w-[15%]">
                            KDDI精算月
                        </th>
                        <td>
                            <x-input type="text" name="kddi_month" value="{{ old('kddi_month', $maintenance->kddi_month) }}" maxlength="20" />
                        </td>
                    </tr>
                    <tr>
                        <th class="tw:w-[15%]">
                            施工業者
                        </th>
                        <td colspan="5">
                            <x-select name="trader_cd" value="{{ old('trader_cd', $maintenance->trader_cd) }}" empty=" " :options="$traders" />
                        </td>
                    </tr>
                    <tr>
                        <th class="tw:w-[15%]">
                            チェック日
                        </th>
                        <td>
                            <x-input type="date" id="check_date" name="check_date" value="{{ old('check_date', $maintenance->check_date?->format('Y-m-d')) }}" size="20" maxlength="10" />
                        </td>
                        <th class="tw:w-[15%]">
                            チェック者
                        </th>
                        <td colspan="3">
                            <x-select name="check_mcd" value="{{ old('check_mcd', $maintenance->check_mcd) }}" empty=" " :options="$members" />
                        </td>
                    </tr>
                    <tr>
                        <th class="tw:w-[15%]">
                            チェック内容
                        </td>
                        <td colspan="5">
                            <x-textarea name="check_notes" rows="2">{{ old('check_notes', $maintenance->check_notes) }}</x-textarea>
                        </td>
                    </tr>
                    <tr>
                        <th class="tw:w-[15%]">
                            備考
                        </th>
                        <td colspan="5">
                            <x-textarea name="notes" rows="4">{{ old('notes', $maintenance->notes) }}</x-textarea>
                        </td>
                    </tr>
                    <tr>
                        <th class="tw:w-[15%]">
                            対応履歴
                        </th>
                        <td colspan="5">
                            <x-textarea name="history_notes" rows="4">{{ old('history_notes', $maintenance->history_notes) }}</x-textarea>
                        </td>
                    </tr>
                </tbody></table>
            </div>
            <div class="tw:rows-start-2 tw:rows-end-3 tw:bg-pink01 tw:p-4 tw:flex tw:items-center tw:gap-x-[10px]">
                <div class="">
                    管理番号：<x-input type="text" value="{{ $code }}" class="tw:!w-[300px]" x-ref="search_code" />
                </div>
                <div>
                    <x-button.gray type="button" x-on:click="search()">検　索</x-button.gray>
                </div>
                @if ($code && !$is_exclusion)
                    <div>
                        <x-button.gray type="submit">更　新</x-button.gray>
                    </div>
                @endif
            </div>
        </div>
    </form>
</x-app-layout>
<script>
    function mainForm() {
        return {
            initForm: null,
            isChange: false,
            init() {
                const form = this.$refs.form;
                this.initForm = new FormData(form);

                // 入力・変更を監視
                const checkChange = () => {
                    const current = new FormData(form);
                    this.isChange = JSON.stringify([...this.initForm]) !== JSON.stringify([...current]);
                };

                form.addEventListener('input', checkChange);
                form.addEventListener('change', checkChange);

            },
            search() {
                const search_code = this.$refs.search_code.value;

                if (this.isChange) {
                    if (!confirm('入力内容を破棄して続行しますか？')) {
                        return;
                    }
                }

                window.location.href = '/main/' + search_code;
            },
        }
    }
</script>
