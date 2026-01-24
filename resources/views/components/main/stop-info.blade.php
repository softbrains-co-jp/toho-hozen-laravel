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
                    マルチM/C電柱番号
                </th>
                <td>
                    <x-hozen.input type="text" name="mc_pole_cd" value="{{ old('mc_pole_cd', $maintenance->mc_pole_cd) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    マルチM/C開閉有無
                </th>
                <td colspan="3">
                    @if (Auth::user()->role == App\Models\MstUser::ROLE_USER)
                        {{ $maintenance->mc_open_flg == '01' ? '有' : ($maintenance->mc_open_flg == '02' ? '無' : '') }}
                    @else
                        <div class="tw:flex tw:gap-x-[20px]">
                            <x-forms.radio name="mc_open_flg" value="01" label="有" :checked="old('mc_open_flg', $maintenance->mc_open_flg)" />
                            <x-forms.radio name="mc_open_flg" value="02" label="無" :checked="old('mc_open_flg', $maintenance->mc_open_flg)" />
                        </div>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    100M停止時間
                </th>
                <td>
                    <x-hozen.input type="text" name="stop_100m_time" value="{{ old('stop_100m_time', $maintenance->stop_100m_time) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    GE-PON停止時間
                </th>
                <td colspan="3">
                    <x-hozen.input type="text" name="stop_gepon_time" value="{{ old('stop_gepon_time', $maintenance->stop_gepon_time) }}" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    停止番号1
                </th>
                <td>
                    <x-hozen.input type="text" name="stop_no1" value="{{ old('stop_no1', $maintenance->stop_no1) }}" class="tw:!w-[200px]" maxlength="10" />
                </td>
                <th class="tw:w-[15%]">
                    停止番号2
                </th>
                <td>
                    <x-hozen.input type="text" name="stop_no2" value="{{ old('stop_no2', $maintenance->stop_no2) }}" class="tw:!w-[200px]" maxlength="10" />
                </td>
                <th class="tw:w-[15%]">
                    停止番号3
                </th>
                <td>
                    <x-hozen.input type="text" name="stop_no3" value="{{ old('stop_no3', $maintenance->stop_no3) }}" class="tw:!w-[200px]" maxlength="10" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    停止番号4
                </th>
                <td>
                    <x-hozen.input type="text" name="stop_no4" value="{{ old('stop_no4', $maintenance->stop_no4) }}" class="tw:!w-[200px]" maxlength="10" />
                </td>
                <th class="tw:w-[15%]">
                    停止番号5
                </th>
                <td>
                    <x-hozen.input type="text" name="stop_no5" value="{{ old('stop_no5', $maintenance->stop_no5) }}" class="tw:!w-[200px]" maxlength="10" />
                </td>
                <th class="tw:w-[15%]">
                    停止番号6
                </th>
                <td>
                    <x-hozen.input type="text" name="stop_no6" value="{{ old('stop_no6', $maintenance->stop_no6) }}" class="tw:!w-[200px]" maxlength="10" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    停止番号7
                </th>
                <td>
                    <x-hozen.input type="text" name="stop_no7" value="{{ old('stop_no7', $maintenance->stop_no7) }}" class="tw:!w-[200px]" maxlength="10" />
                </td>
                <th class="tw:w-[15%]">
                    停止番号8
                </th>
                <td>
                    <x-hozen.input type="text" name="stop_no8" value="{{ old('stop_no8', $maintenance->stop_no8) }}" class="tw:!w-[200px]" maxlength="10" />
                </td>
                <th class="tw:w-[15%]">
                    停止番号9
                </th>
                <td>
                    <x-hozen.input type="text" name="stop_no9" value="{{ old('stop_no9', $maintenance->stop_no9) }}" class="tw:!w-[200px]" maxlength="10" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    停止番号10
                </th>
                <td>
                    <x-hozen.input type="text" name="stop_no10" value="{{ old('stop_no10', $maintenance->stop_no10) }}" class="tw:!w-[200px]" maxlength="10" />
                </td>
            </tr>
        </tbody>
    </table>
</div>
