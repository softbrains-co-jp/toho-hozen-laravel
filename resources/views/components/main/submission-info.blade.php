@props([
    'maintenance' => null,
])
<div {{ $attributes }} >
    ■申請情報
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
                    申請種別
                </th>
                <td colspan="5">
                    <x-forms.select name="apply_type" value="{{ old('apply_type', $maintenance->apply_type) }}" empty=" " :options="$applies" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    追加申請依頼日
                </th>
                <td>
                    <x-forms.input-date name="add_order_date" :value="old('add_order_date', $maintenance->add_order_date)" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    追加申請回答日
                </th>
                <td>
                    <x-forms.input-date name="add_receive_date" :value="old('add_receive_date', $maintenance->add_receive_date)" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    追加申請図面受領日
                </th>
                <td>
                    <x-forms.input-date name="add_design_receive_date" :value="old('add_design_receive_date', $maintenance->add_design_receive_date)" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    竣工報告依頼日
                </th>
                <td>
                    <x-forms.input-date name="complete_order_date" :value="old('complete_order_date', $maintenance->complete_order_date)" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    竣工届受理日
                </th>
                <td colspan="3">
                    <x-forms.input-date name="complete_receive_date" :value="old('complete_receive_date', $maintenance->complete_receive_date)" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    解除申請依頼日
                </th>
                <td>
                    <x-forms.input-date name="cancel_order_date" :value="old('cancel_order_date', $maintenance->cancel_order_date)" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    解除竣工届受領日
                </th>
                <td>
                    <x-forms.input-date name="cancel_report_receive_date" :value="old('cancel_report_receive_date', $maintenance->cancel_report_receive_date)" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    解除申請図面受領日
                </th>
                <td>
                    <x-forms.input-date name="cancel_design_receive_date" :value="old('cancel_design_receive_date', $maintenance->cancel_design_receive_date)" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    申請備考
                </th>
                <td colspan="5">
                    <x-forms.textarea name="apply_notes" rows="2">{{ old('apply_notes', $maintenance->apply_notes) }}</x-forms.textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>
