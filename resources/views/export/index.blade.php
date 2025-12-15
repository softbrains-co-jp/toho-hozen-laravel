<x-app-layout>
    <div class="tw:bg-pink01 tw:min-h-screen tw:p-2 tw:flex tw:flex-col">
        <x-page-title>帳票エクスポート</x-page-title>
        <x-error-message :errors="$errors" />
        <form method="post" action="{{ route('export.post') }}" class="tw:w-full">
            @csrf
            <div class="tw:flex tw:gap-x-[10px]">
                <div class="tw:flex-1 tw:flex tw:flex-col tw:gap-y-[30px]">
                    <div>
                        <table class="hozen-table tw:w-full">
                            <tr>
                                <th class="tw:w-[200px]">付託日</th>
                                <td>
                                    <x-forms.input-date name="export01_from" :value="old('export01_from')" class="tw:!w-[150px]" />
                                    〜
                                    <x-forms.input-date name="export01_to" :value="old('export01_to')" class="tw:!w-[150px]" />
                                </td>
                            </tr>
                            <tr>
                                <td class="tw:text-center" colspan="2">
                                    <x-button.gray type="submit" name="action" value="export01" class="tw:w-[250px]">付託リスト</x-button.gray>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="hozen-table tw:w-full">
                            <tr>
                                <th class="tw:w-[200px]">保守作業報告日</th>
                                <td>
                                    <x-forms.input-date name="export02" :value="old('export02')" class="tw:!w-[150px]" />
                                </td>
                            </tr>
                            <tr>
                                <td class="tw:text-center" colspan="2">
                                    <div class="tw:flex tw:gap-x-[30px] tw:justify-center">
                                        <x-button.gray type="submit" name="action" value="export02_1" class="tw:w-[250px]">保守作業報告</x-button.gray>
                                        <x-button.gray type="submit" name="action" value="export02_2" class="tw:w-[250px]">位置情報用</x-button.gray>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="hozen-table tw:w-full">
                            <tr>
                                <th class="tw:w-[200px]">期限</th>
                                <td>
                                    <x-forms.input-date name="export03_from" :value="old('export03_from')" class="tw:!w-[150px]" />
                                    〜
                                    <x-forms.input-date name="export03_to" :value="old('export03_to')" class="tw:!w-[150px]" />
                                </td>
                            </tr>
                            <tr>
                                <td class="tw:text-center" colspan="2">
                                    <x-button.gray type="submit" name="action" value="export03" class="tw:w-[250px]">直近工期リスト</x-button.gray>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="hozen-table tw:w-full">
                            <tr>
                                <th class="tw:w-[200px]">作業日報報告日</th>
                                <td>
                                    <x-forms.input-date name="export04" :value="old('export04')" class="tw:!w-[150px]" />
                                </td>
                            </tr>
                            <tr>
                                <td class="tw:text-center" colspan="2">
                                    <x-button.gray type="submit" name="action" value="export04" class="tw:w-[250px]">作業日報（KDDI提出用）</x-button.gray>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="hozen-table tw:w-full">
                            <tr>
                                <td class="tw:text-center" colspan="2">
                                    <x-button.gray type="submit" name="action" value="export05" class="tw:w-[250px]">竣工成果物遅延リスト</x-button.gray>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="hozen-table tw:w-full">
                            <tr>
                                <th class="tw:w-[200px]">チェック日</th>
                                <td>
                                    <x-forms.input-date name="export06" :value="old('export06')" class="tw:!w-[150px]" />
                                </td>
                            </tr>
                            <tr>
                                <td class="tw:text-center" colspan="2">
                                    <x-button.gray type="submit" name="action" value="export06" class="tw:w-[250px]">チェック日リスト</x-button.gray>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="hozen-table tw:w-full">
                            <tr>
                                <th class="tw:w-[200px]">予定日</th>
                                <td>
                                    <x-forms.input-date name="export07" :value="now()->format('Y/m/d')" class="tw:!w-[150px]" />
                                </td>
                            </tr>
                            <tr>
                                <td class="tw:text-center" colspan="2">
                                    <x-button.gray type="submit" name="action" value="export07" class="tw:w-[250px]">保守工事報告リスト</x-button.gray>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tw:flex-1 tw:flex tw:flex-col tw:gap-y-[30px]">
                    <div>
                        <table class="hozen-table tw:w-full">
                            <tr>
                                <th class="tw:w-[200px]">KDDI精算月</th>
                                <td>
                                    <x-forms.input type="text" name="export08" value="{{ old('export08') }}" class="tw:!w-[150px]" />
                                </td>
                            </tr>
                            <tr>
                                <td class="tw:text-center" colspan="2">
                                    <div class="tw:flex tw:gap-x-[30px] tw:justify-center">
                                        <x-button.gray type="submit" name="action" value="export08_1" class="tw:w-[250px]">精算月件数確認リスト</x-button.gray>
                                        <x-button.gray type="submit" name="action" value="export08_2" class="tw:w-[250px]">申請状況確認リスト</x-button.gray>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="hozen-table tw:w-full">
                            <tr>
                                <th class="tw:w-[200px]">KDDI依頼日</th>
                                <td>
                                    <x-forms.input-date name="export09_from" :value="old('export09_from')" class="tw:!w-[150px]" />
                                    〜
                                    <x-forms.input-date name="export09_to" :value="old('export09_to')" class="tw:!w-[150px]" />
                                </td>
                            </tr>
                            <tr>
                                <td class="tw:text-center" colspan="2">
                                    <div class="tw:flex tw:gap-x-[30px] tw:justify-center">
                                        <x-button.gray type="submit" name="action" value="export09_1" class="tw:w-[250px]">未竣工状況確認リスト</x-button.gray>
                                        <x-button.gray type="submit" name="action" value="export09_2" class="tw:w-[250px]">追加・解除申請図書受領確認リスト</x-button.gray>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="hozen-table tw:w-full">
                            <tr>
                                <th class="tw:w-[200px]">チェック者</th>
                                <td>
                                    <x-forms.select name="export10" value="{{ old('export10') }}" empty=" " :options="$members" />
                                </td>
                            </tr>
                            <tr>
                                <td class="tw:text-center" colspan="2">
                                    <x-button.gray type="submit" name="action" value="export10" class="tw:w-[250px]">チェック者確認リスト</x-button.gray>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table class="hozen-table tw:w-full">
                            <tr>
                                <th class="tw:w-[200px]">TOH管理番号</th>
                                <td>
                                    <x-forms.textarea name="export11" rows="6" class="tw:!w-[300px]">{{ old('export11') }}</x-forms.textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="tw:text-center" colspan="2">
                                    <x-button.gray type="submit" name="action" value="export11" class="tw:w-[250px]">竣工成果物受領管理リスト</x-button.gray>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
