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
                    <x-hozen.select name="apply_type" value="{{ old('apply_type', $maintenance->apply_type) }}" empty=" " :options="$applies" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    申請備考
                </th>
                <td colspan="5">
                    <x-hozen.textarea name="apply_notes" rows="8">{{ old('apply_notes', $maintenance->apply_notes) }}</x-forms.textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>
