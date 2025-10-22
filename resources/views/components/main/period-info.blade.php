@props([
    'maintenance' => null,
])
<div {{ $attributes }} >
    ■工期情報
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
                    仮工期（自）
                </th>
                <td>
                    <x-forms.input type="date" name="t_term_start_date" value="{{ old('t_term_start_date', $maintenance->t_term_start_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    仮工期（至）
                </th>
                <td>
                    <x-forms.input type="date" name="t_term_end_date" value="{{ old('t_term_end_date', $maintenance->t_term_end_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    仮工期変更後（自）
                </th>
                <td>
                    <x-forms.input type="date" name="t_term2_start_date" value="{{ old('t_term2_start_date', $maintenance->t_term2_start_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    仮工期変更後（至）
                </th>
                <td>
                    <x-forms.input type="date" name="t_term2_end_date" value="{{ old('t_term2_end_date', $maintenance->t_term2_end_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    仮工期変更後（自）
                </th>
                <td colspan="3">
                    <x-forms.textarea name="t_term_notes" rows="2">{{ old('t_term_notes', $maintenance->t_term_notes) }}</x-forms.textarea>
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    本工期（自）
                </th>
                <td>
                    <x-forms.input type="date" name="term_start_date" value="{{ old('term_start_date', $maintenance->term_start_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    本工期（至）
                </th>
                <td>
                    <x-forms.input type="date" name="term_end_date" value="{{ old('term_end_date', $maintenance->term_end_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    仮工期変更後（自）
                </th>
                <td>
                    <x-forms.input type="date" name="term2_start_date" value="{{ old('term2_start_date', $maintenance->term2_start_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    仮工期変更後（至）
                </th>
                <td>
                    <x-forms.input type="date" name="term2_end_date" value="{{ old('term2_end_date', $maintenance->term2_end_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    仮工期変更後（自）
                </th>
                <td colspan="3">
                    <x-forms.textarea name="term_notes" rows="2">{{ old('term_notes', $maintenance->term_notes) }}</x-forms.textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>
