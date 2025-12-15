@props([
    'maintenance' => null,
])
<div {{ $attributes }} >
    ■竣工情報
    <table class="hozen-table tw:w-full">
        <colgroup>
            <col>
            <col>
            <col>
            <col>
        </colgroup>
        <tbody>
            <tr>
                <th class="tw:w-[15%]">
                    調査報告書受領日
                </th>
                <td>
                    <x-forms.input-date name="conduct_receive_date" :value="old('conduct_receive_date', $maintenance->conduct_receive_date?->format('Y/m/d'))" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    仮工事報告書受領日
                </th>
                <td>
                    <x-forms.input-date name="t_work_receive_date" :value="old('t_work_receive_date', $maintenance->t_work_receive_date?->format('Y/m/d'))" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    竣工図書受領日
                </th>
                <td>
                    <x-forms.input-date name="complete_design_receive_date" :value="old('complete_design_receive_date', $maintenance->complete_design_receive_date?->format('Y/m/d'))" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    電線設備変更依頼書送信日
                </th>
                <td>
                    <x-forms.input-date name="wire_change_order_date" :value="old('wire_change_order_date', $maintenance->wire_change_order_date)" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    GEMINI修正依頼日
                </th>
                <td colspan="3">
                    <x-forms.input-date name="gemini_order_date" :value="old('gemini_order_date', $maintenance->gemini_order_date)" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    竣工報告日
                </th>
                <td>
                    <x-forms.input-date name="complete_report_date" :value="old('complete_report_date', $maintenance->complete_report_date)" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    竣工処理待ち
                </th>
                <td colspan="3">
                    <input type="hidden" name="complete_stop_flg" value="0">
                    <x-forms.checkbox name="complete_stop_flg" value="1" :checked="old('complete_stop_flg', $maintenance->complete_stop_flg)" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    竣工備考
                </th>
                <td colspan="5">
                    <x-forms.textarea name="complete_notes" rows="2">{{ old('complete_notes', $maintenance->complete_notes) }}</x-forms.textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>
