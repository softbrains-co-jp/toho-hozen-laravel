@props([
    'maintenance' => null,
])
<div {{ $attributes }} >
    ■集計情報
    <table class="hozen-table tw:w-full tw:mb-[10px]">
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
                    協力会社備考
                </th>
                <td colspan="5">
                    <x-forms.textarea name="calc_notes" rows="16">{{ old('calc_notes', $maintenance->calc_notes) }}</x-forms.textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>
