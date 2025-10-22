@props([
    'maintenance' => null,
])
<div {{ $attributes }} >
    ■工事情報
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
                    KDDI依頼日
                </th>
                <td>
                    <x-forms.input type="date" name="kddi_oder_date" value="{{ old('kddi_oder_date', $maintenance->kddi_oder_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    工事完了報告日
                </th>
                <td>
                    <x-forms.input type="date" name="report_date" value="{{ old('report_date', $maintenance->report_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    工事報告日
                </th>
                <td>
                    <x-forms.input type="date" name="work_report_date" value="{{ old('work_report_date', $maintenance->work_report_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
            </tr>
        </tbody>
    </table>
    【調査関連】
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
                    調査付託日
                </th>
                <td colspan="5">
                    <x-forms.input type="date" name="conduct_commit_date" value="{{ old('conduct_commit_date', $maintenance->conduct_commit_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    現場調査予定日
                </th>
                <td>
                    <x-forms.input type="date" name="conduct_plan_date" value="{{ old('conduct_plan_date', $maintenance->conduct_plan_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    現場調査予定時間
                </th>
                <td>
                    <x-forms.select name="conduct_time_cd" value="{{ old('conduct_time_cd', $maintenance->conduct_time_cd) }}" empty=" " :options="$time_cds" />
                </td>
                <th class="tw:w-[15%]">
                    調査作業員名
                </th>
                <td>
                    <x-forms.input type="text" name="conduct_member_name" value="{{ old('conduct_member_name', $maintenance->conduct_member_name) }}" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    調査作業開始時間
                </th>
                <td>
                    <x-forms.input type="time" name="conduct_start_datetime" value="{{ old('conduct_start_datetime', $maintenance->conduct_start_datetime) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    調査開始受信者
                </th>
                <td colspan="3">
                    <x-forms.select name="conduct_start_mcd" value="{{ old('conduct_start_mcd', $maintenance->conduct_start_mcd) }}" empty=" " :options="$members" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    調査作業終了時間
                </th>
                <td>
                    <x-forms.input type="time" name="conduct_end_datetime" value="{{ old('conduct_end_datetime', $maintenance->conduct_end_datetime) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    調査終了受信者
                </th>
                <td colspan="3">
                    <x-forms.select name="conduct_end_mcd" value="{{ old('conduct_end_mcd', $maintenance->conduct_end_mcd) }}" empty=" " :options="$members" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    現場調査実施日
                </th>
                <td>
                    <x-forms.input type="date" name="conduct_action_date" value="{{ old('conduct_action_date', $maintenance->conduct_action_date) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    調査報告日
                </th>
                <td colspan="3">
                    <x-forms.input type="date" name="conduct_report_date" value="{{ old('conduct_report_date', $maintenance->conduct_report_date) }}" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    建柱確認日1
                </th>
                <td>
                    <x-forms.input type="date" name="check1_date" value="{{ old('check1_date', $maintenance->check1_date) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    建柱確認日2
                </th>
                <td>
                    <x-forms.input type="date" name="check2_date" value="{{ old('check2_date', $maintenance->check2_date) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    建柱確認日3
                </th>
                <td>
                    <x-forms.input type="date" name="check3_date" value="{{ old('check3_date', $maintenance->check3_date) }}" class="tw:!w-[200px]" />
                </td>
            </tr>
        </tbody>
    </table>
    【仮移設関連】
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
                    仮移設予定日
                </th>
                <td>
                    <x-forms.input type="date" name="t_setup_plan_date" value="{{ old('t_setup_plan_date', $maintenance->t_setup_plan_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    仮移設予定時間
                </th>
                <td>
                    <x-forms.select name="t_setup_plan_time_cd" value="{{ old('t_setup_plan_time_cd', $maintenance->t_setup_plan_time_cd) }}" empty=" " :options="$time_cds" />
                </td>
                <th class="tw:w-[15%]">
                    仮移設作業員名
                </th>
                <td>
                    <x-forms.input type="text" name="t_setup_member_name" value="{{ old('t_setup_member_name', $maintenance->t_setup_member_name) }}" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    仮移設作業開始時間
                </th>
                <td>
                    <x-forms.input type="time" name="t_setup_start_datetime" value="{{ old('t_setup_start_datetime', $maintenance->t_setup_start_datetime) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    仮移設開始受信者
                </th>
                <td colspan="3">
                    <x-forms.select name="t_setup_start_mcd" value="{{ old('t_setup_start_mcd', $maintenance->t_setup_start_mcd) }}" empty=" " :options="$members" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    仮移設作業終了時間
                </th>
                <td>
                    <x-forms.input type="time" name="t_setup_end_datetime" value="{{ old('t_setup_end_datetime', $maintenance->t_setup_end_datetime) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    仮移設終了受信者
                </th>
                <td colspan="3">
                    <x-forms.select name="t_setup_finish_mcd" value="{{ old('t_setup_finish_mcd', $maintenance->t_setup_finish_mcd) }}" empty=" " :options="$members" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    仮移設実施日
                </th>
                <td colspan="5">
                    <x-forms.input type="date" name="t_setup_action_date" value="{{ old('t_setup_action_date', $maintenance->t_setup_action_date) }}" class="tw:!w-[200px]" />
                </td>
            </tr>
        </tbody>
    </table>
    【本工事関連】
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
                    工事付託日
                </th>
                <td colspan="5">
                    <x-forms.input type="date" name="commit_date" value="{{ old('commit_date', $maintenance->commit_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    作業予定日
                </th>
                <td>
                    <x-forms.input type="date" name="work_plan_date" value="{{ old('work_plan_date', $maintenance->work_plan_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    作業予定時間
                </th>
                <td>
                    <x-forms.select name="work_plan_time_cd" value="{{ old('work_plan_time_cd', $maintenance->work_plan_time_cd) }}" empty=" " :options="$time_cds" />
                </td>
                <th class="tw:w-[15%]">
                    本移設作業員名
                </th>
                <td>
                    <x-forms.input type="text" name="setup_member_name" value="{{ old('setup_member_name', $maintenance->setup_member_name) }}" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    作業開始時間
                </th>
                <td>
                    <x-forms.input type="time" name="work_start_datetime" value="{{ old('work_start_datetime', $maintenance->work_start_datetime) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    本移設開始受信者
                </th>
                <td colspan="3">
                    <x-forms.select name="setup_start_mcd" value="{{ old('setup_start_mcd', $maintenance->setup_start_mcd) }}" empty=" " :options="$members" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    作業終了時間
                </th>
                <td>
                    <x-forms.input type="time" name="work_end_datetime" value="{{ old('work_end_datetime', $maintenance->work_end_datetime) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    本移設終了受信者
                </th>
                <td colspan="3">
                    <x-forms.select name="setup_finish_mcd" value="{{ old('setup_finish_mcd', $maintenance->setup_finish_mcd) }}" empty=" " :options="$members" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    作業実施日
                </th>
                <td colspan="5">
                    <x-forms.input type="date" name="work_action_date" value="{{ old('work_action_date', $maintenance->work_action_date) }}" class="tw:!w-[200px]" />
                </td>
            </tr>
        </tbody>
    </table>
    <table class="hozen-table tw:w-full tw:mb-[10px]">
        <colgroup>
            <col>
            <col>
            <col>
            <col>
        </colgroup>
        <tbody>
            <tr>
                <th class="tw:w-[15%]">
                    KDDI確認依頼日
                </th>
                <td>
                    <x-forms.input type="date" name="kddi_check_date" value="{{ old('kddi_check_date', $maintenance->kddi_check_date?->format('Y-m-d')) }}" class="tw:!w-[200px]" />
                </td>
                <th class="tw:w-[15%]">
                    KDDI報告種別
                </th>
                <td>
                    <x-forms.select name="kddi_report_type" value="{{ old('kddi_report_type', $maintenance->kddi_report_type) }}" empty=" " :options="$kddi_reports" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[15%]">
                    KDDI報告内容
                </th>
                <td colspan="5">
                    <x-forms.textarea name="kddi_report_notes" rows="2">{{ old('kddi_report_notes', $maintenance->kddi_report_notes) }}</x-forms.textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>
