@props([
    'maintenance' => null,
])
<div {{ $attributes }} >
    ■停止情報
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
                    回線停止有無
                </th>
                <td>
                    @if (Auth::user()->role == App\Models\MstUser::ROLE_USER)
                        {{ $maintenance->stop_circuit_flg == '01' ? '有' : ($maintenance->stop_circuit_flg == '02' ? '無' : '') }}
                    @else
                        <div class="tw:flex tw:gap-x-[20px]">
                            <x-forms.radio name="stop_circuit_flg" value="01" label="有" :checked="old('stop_circuit_flg', $maintenance->stop_circuit_flg)" />
                            <x-forms.radio name="stop_circuit_flg" value="02" label="無" :checked="old('stop_circuit_flg', $maintenance->stop_circuit_flg)" />
                        </div>
                    @endif
                </td>
                <th class="tw:w-[15%]">
                    停止予定日
                </th>
                <td>
                    <x-forms.input-date name="stop_plan_date" :value="old('stop_plan_date', $maintenance->stop_plan_date?->format('Y/m/d'))" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    停止実施日
                </th>
                <td>
                    <x-hozen.input-date name="stop_action_date" :value="old('stop_action_date', $maintenance->stop_action_date?->format('Y/m/d'))" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    停止情報備考
                </th>
                <td colspan="5">
                    <x-hozen.textarea type="text" name="stop_notes" rows="8">
                        {{ old('stop_notes', $maintenance->stop_notes) }}
                    </x-hozen.textare>
                </td>
            </tr>
        </tbody>
    </table>
</div>
