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
                <th class="tw:w-[20%]">
                    対象ドロップ条数（条）
                </th>
                <td>
                    <x-forms.input type="text" name="object_drop_number" value="{{ old('object_drop_number', $maintenance->object_drop_number) }}" class="tw:!w-[130px]" maxlength="10" />
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
            <col>
            <col>
        </colgroup>
        <tbody>
            <tr>
                <th class="tw:w-[20%]">
                    直線接続キット数（個）
                </th>
                <td>
                    <x-forms.input type="text" name="straight_kit_number" value="{{ old('straight_kit_number', $maintenance->straight_kit_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    単独架設ドロップ（ｍ）
                </th>
                <td>
                    <x-forms.input type="text" name="single_drop_meter" value="{{ old('single_drop_meter', $maintenance->single_drop_meter) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    一束化架設ドロップ（ｍ）
                </th>
                <td>
                    <x-forms.input type="text" name="bundle_drop_meter" value="{{ old('bundle_drop_meter', $maintenance->bundle_drop_meter) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[20%]">
                    メッセン新設（ｍ）
                </th>
                <td>
                    <x-forms.input type="text" name="messen_meter" value="{{ old('messen_meter', $maintenance->messen_meter) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    スパハン新設（ｍ）
                </th>
                <td>
                    <x-forms.input type="text" name="spahan_meter" value="{{ old('spahan_meter', $maintenance->spahan_meter) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    新設間本数（間本）
                </th>
                <td>
                    <x-forms.input type="text" name="add_mahon_number" value="{{ old('add_mahon_number', $maintenance->add_mahon_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[20%]">
                    A装柱新設（個）
                </th>
                <td>
                    <x-forms.input type="text" name="a_pole_number" value="{{ old('a_pole_number', $maintenance->a_pole_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    D,E装柱新設（個）
                </th>
                <td>
                    <x-forms.input type="text" name="de_pole_number" value="{{ old('de_pole_number', $maintenance->de_pole_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    F０．７装柱新設（個）
                </th>
                <td>
                    <x-forms.input type="text" name="f07_pole_number" value="{{ old('f07_pole_number', $maintenance->f07_pole_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[20%]">
                    F０．９装柱新設（個）
                </th>
                <td>
                    <x-forms.input type="text" name="f09_pole_number" value="{{ old('f09_pole_number', $maintenance->f09_pole_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    F１．２装柱新設（個）
                </th>
                <td>
                    <x-forms.input type="text" name="f12_pole_number" value="{{ old('f12_pole_number', $maintenance->f12_pole_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    F１．４装柱新設（個）
                </th>
                <td>
                    <x-forms.input type="text" name="f14_pole_number" value="{{ old('f14_pole_number', $maintenance->f14_pole_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[20%]">
                    自在バンド新設（個）
                </th>
                <td>
                    <x-forms.input type="text" name="band_number" value="{{ old('band_number', $maintenance->band_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    コネクタースリーブ数（個）
                </th>
                <td>
                    <x-forms.input type="text" name="connecter_number" value="{{ old('connecter_number', $maintenance->connecter_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    建築防護管取付（本）
                </th>
                <td>
                    <x-forms.input type="text" name="protect_pipe_number" value="{{ old('protect_pipe_number', $maintenance->protect_pipe_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[20%]">
                    防護カバー取付（本）
                </th>
                <td>
                    <x-forms.input type="text" name="protect_cover_number" value="{{ old('protect_cover_number', $maintenance->protect_cover_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    鳥害対策単独用取付（ｍ）
                </th>
                <td>
                    <x-forms.input type="text" name="bird_single_meter" value="{{ old('bird_single_meter', $maintenance->bird_single_meter) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    鳥害対策メッセン用取付（ｍ）
                </th>
                <td>
                    <x-forms.input type="text" name="bird_messen_meter" value="{{ old('bird_messen_meter', $maintenance->bird_messen_meter) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[20%]">
                    ポート変更（ポート）
                </th>
                <td>
                    <x-forms.input type="text" name="port_change_number" value="{{ old('port_change_number', $maintenance->port_change_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    宅内引留取付（箇所）
                </th>
                <td colspan="3">
                    <x-forms.input type="text" name="house_keep_number" value="{{ old('house_keep_number', $maintenance->house_keep_number) }}" class="tw:!w-[130px]" maxlength="10" />
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
            <col>
            <col>
        </colgroup>
        <tbody>
            <tr>
                <th class="tw:w-[20%]">
                    単独撤去ドロップ（ｍ）
                </th>
                <td>
                    <x-forms.input type="text" name="single_drop_removal_meter" value="{{ old('single_drop_removal_meter', $maintenance->single_drop_removal_meter) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    一束化撤去ドロップ（ｍ）
                </th>
                <td>
                    <x-forms.input type="text" name="bundle_drop_removal_meter" value="{{ old('bundle_drop_removal_meter', $maintenance->bundle_drop_removal_meter) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    メッセン撤去（ｍ）
                </th>
                <td>
                    <x-forms.input type="text" name="messen_removal_meter" value="{{ old('messen_removal_meter', $maintenance->messen_removal_meter) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[20%]">
                    スパハン撤去（ｍ）
                </th>
                <td>
                    <x-forms.input type="text" name="spahan_removal_meter" value="{{ old('spahan_removal_meter', $maintenance->spahan_removal_meter) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    撤去間本数（間本）
                </th>
                <td>
                    <x-forms.input type="text" name="delete_mahon_number" value="{{ old('delete_mahon_number', $maintenance->delete_mahon_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    A,D,E装柱撤去（個）
                </th>
                <td>
                    <x-forms.input type="text" name="ade_pole_removal_number" value="{{ old('ade_pole_removal_number', $maintenance->ade_pole_removal_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[20%]">
                    F装柱撤去（個）
                </th>
                <td>
                    <x-forms.input type="text" name="f_pole_removal_number" value="{{ old('f_pole_removal_number', $maintenance->f_pole_removal_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    自在バンド撤去（個）
                </th>
                <td>
                    <x-forms.input type="text" name="band_removal_number" value="{{ old('band_removal_number', $maintenance->band_removal_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    A,D,建築防護管取外（本）
                </th>
                <td>
                    <x-forms.input type="text" name="protect_pipe_removal_number" value="{{ old('protect_pipe_removal_number', $maintenance->protect_pipe_removal_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[20%]">
                    防護カバー取外（本）
                </th>
                <td>
                    <x-forms.input type="text" name="protect_cover_removal_number" value="{{ old('protect_cover_removal_number', $maintenance->protect_cover_removal_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    鳥害対策単独用取外（ｍ）
                </th>
                <td>
                    <x-forms.input type="text" name="bird_single_removal_number" value="{{ old('bird_single_removal_number', $maintenance->bird_single_removal_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
                <th class="tw:w-[20%]">
                    鳥害対策メッセン用取外（ｍ）
                </th>
                <td>
                    <x-forms.input type="text" name="bird_messen_removal_number" value="{{ old('bird_messen_removal_number', $maintenance->bird_messen_removal_number) }}" class="tw:!w-[130px]" maxlength="10" />
                </td>
            </tr>
            <tr>
                <th class="tw:w-[20%]">
                    宅内引留取外（箇所）
                </th>
                <td colspan="5">
                    <x-forms.input type="text" name="house_keep_removal_number" value="{{ old('house_keep_removal_number', $maintenance->house_keep_removal_number) }}" class="tw:!w-[130px]" maxlength="10" />
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
            <col>
            <col>
        </colgroup>
        <tbody>
            <tr>
                <th class="tw:w-[20%]">
                    申請備考
                </th>
                <td colspan="5">
                    <x-forms.textarea name="calc_notes" rows="2">{{ old('calc_notes', $maintenance->calc_notes) }}</x-forms.textarea>
                </td>
            </tr>
        </tbody>
    </table>
</div>
