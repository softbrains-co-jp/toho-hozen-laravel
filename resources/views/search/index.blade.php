<x-app-layout>
    <div class="tw:bg-pink01 tw:min-h-screen tw:p-2 tw:flex tw:flex-col" x-data="deleteForm()">
        <x-page-title>複合条件検索</x-page-title>
        <form method="get" action="{{ route('search.index') }}">
            <table class="hozen-table tw:w-full">
                <colgroup>
                    <col class="tw:w-[200px]">
                    <col>
                    <col class="tw:w-[200px]">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th>KDDI管理番号</th>
                        <td>
                            <x-forms.input type="text" name="kddi_cd" value="{{ $condition['kddi_cd'] ?? '' }}" />
                        </td>
                        <th>TOH管理番号</th>
                        <td>
                            <x-forms.input type="text" name="toh_cd" value="{{ $condition['toh_cd'] ?? '' }}" />
                        </td>
                    </tr>
                    <tr>
                        <th>支社</th>
                        <td>
                            <x-forms.select name="branch_cd" value="{{ $condition['branch_cd'] ?? '' }}" empty=" " :options="$branches" />
                        </td>
                        <th>現場住所</th>
                        <td>
                            <x-forms.input type="text" name="work_address" value="{{ $condition['work_address'] ?? '' }}" />
                        </td>
                    </tr>
                    <tr>
                        <th>施工業者</th>
                        <td>
                            <x-forms.select name="trader_cd" value="{{ $condition['trader_cd'] ?? '' }}" empty=" " :options="$traders" />
                        </td>
                        <th>工事進捗ステータス</th>
                        <td>
                            <x-forms.select name="status_cd" value="{{ $condition['status_cd'] ?? '' }}" empty=" " :options="$status" />
                        </td>
                    </tr>
                    <tr>
                        <th>道路種別</th>
                        <td>
                            <x-forms.select name="road_cd" value="{{ $condition['road_cd'] ?? '' }}" empty=" " :options="$roads" />
                        </td>
                        <th>電柱番号</th>
                        <td>
                            <x-forms.input type="text" name="pole_cd" value="{{ $condition['pole_cd'] ?? '' }}" />
                        </td>
                    </tr>
                    <tr>
                        <th>チェック日</th>
                        <td>
                            <x-forms.input type="date" name="check_date_from" value="{{ $condition['check_date_from'] ?? '' }}" class="tw:!w-[120px]" />
                            〜
                            <x-forms.input type="date" name="check_date_to" value="{{ $condition['check_date_to'] ?? '' }}" class="tw:!w-[120px]" />
                        </td>
                        <th>チェック者</th>
                        <td>
                            <x-forms.select name="check_mcd" value="{{ $condition['check_mcd'] ?? '' }}" empty=" " :options="$members" />
                        </td>
                    </tr>
                    <tr>
                        <th>本工期（自）</th>
                        <td>
                            <x-forms.input type="date" name="term_start_date_from" value="{{ $condition['term_start_date_from'] ?? '' }}" class="tw:!w-[120px]" />
                            〜
                            <x-forms.input type="date" name="term_start_date_to" value="{{ $condition['term_start_date_to'] ?? '' }}" class="tw:!w-[120px]" />
                        </td>
                        <th>本工期（至）</th>
                        <td>
                            <x-forms.input type="date" name="term_end_date_from" value="{{ $condition['term_end_date_from'] ?? '' }}" class="tw:!w-[120px]" />
                            〜
                            <x-forms.input type="date" name="term_end_date_to" value="{{ $condition['term_end_date_to'] ?? '' }}" class="tw:!w-[120px]" />
                        </td>
                    </tr>
                    <tr>
                        <th>本工期（自）変更後</th>
                        <td>
                            <x-forms.input type="date" name="term2_start_date_from" value="{{ $condition['term2_start_date_from'] ?? '' }}" class="tw:!w-[120px]" />
                            〜
                            <x-forms.input type="date" name="term2_start_date_to" value="{{ $condition['term2_start_date_to'] ?? '' }}" class="tw:!w-[120px]" />
                        </td>
                        <th>本工期（至）変更後</th>
                        <td>
                            <x-forms.input type="date" name="term2_end_date_from" value="{{ $condition['term2_end_date_from'] ?? '' }}" class="tw:!w-[120px]" />
                            〜
                            <x-forms.input type="date" name="term2_end_date_to" value="{{ $condition['term2_end_date_to'] ?? '' }}" class="tw:!w-[120px]" />
                        </td>
                    </tr>
                    <tr>
                        <th>仮工期（自）</th>
                        <td>
                            <x-forms.input type="date" name="t_term_start_date_from" value="{{ $condition['t_term_start_date_from'] ?? '' }}" class="tw:!w-[120px]" />
                            〜
                            <x-forms.input type="date" name="t_term_start_date_to" value="{{ $condition['t_term_start_date_to'] ?? '' }}" class="tw:!w-[120px]" />
                        </td>
                        <th>仮工期（至）</th>
                        <td>
                            <x-forms.input type="date" name="t_term_end_date_from" value="{{ $condition['t_term_end_date_from'] ?? '' }}" class="tw:!w-[120px]" />
                            〜
                            <x-forms.input type="date" name="t_term_end_date_to" value="{{ $condition['t_term_end_date_to'] ?? '' }}" class="tw:!w-[120px]" />
                        </td>
                    </tr>
                    <tr>
                        <th>仮工期（自）変更後</th>
                        <td>
                            <x-forms.input type="date" name="t_term2_start_date_from" value="{{ $condition['t_term2_start_date_from'] ?? '' }}" class="tw:!w-[120px]" />
                            〜
                            <x-forms.input type="date" name="t_term2_start_date_to" value="{{ $condition['t_term2_start_date_to'] ?? '' }}" class="tw:!w-[120px]" />
                        </td>
                        <th>仮工期（至）変更後</th>
                        <td>
                            <x-forms.input type="date" name="t_term2_end_date_from" value="{{ $condition['t_term2_end_date_from'] ?? '' }}" class="tw:!w-[120px]" />
                            〜
                            <x-forms.input type="date" name="t_term2_end_date_to" value="{{ $condition['t_term2_end_date_to'] ?? '' }}" class="tw:!w-[120px]" />
                        </td>
                    </tr>
                    <tr>
                        <th>KDDI依頼日</th>
                        <td>
                            <x-forms.input type="date" name="kddi_oder_date_from" value="{{ $condition['kddi_oder_date_from'] ?? '' }}" class="tw:!w-[120px]" />
                            〜
                            <x-forms.input type="date" name="kddi_oder_date_to" value="{{ $condition['kddi_oder_date_to'] ?? '' }}" class="tw:!w-[120px]" />
                        </td>
                        <th>工事付託日</th>
                        <td>
                            <x-forms.input type="date" name="commit_date_from" value="{{ $condition['commit_date_from'] ?? '' }}" class="tw:!w-[120px]" />
                            〜
                            <x-forms.input type="date" name="commit_date_to" value="{{ $condition['commit_date_to'] ?? '' }}" class="tw:!w-[120px]" />
                        </td>
                    </tr>
                    <tr>
                        <th>調査付託日</th>
                        <td colspan="3">
                            <x-forms.input type="date" name="conduct_commit_date_from" value="{{ $condition['conduct_commit_date_from'] ?? '' }}" class="tw:!w-[120px]" />
                            〜
                            <x-forms.input type="date" name="conduct_commit_date_to" value="{{ $condition['conduct_commit_date_to'] ?? '' }}" class="tw:!w-[120px]" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="tw:mt-[20px] tw:flex tw:gap-x-[20px] tw:justify-center">
                <x-button.gray type="submit">検索</x-button.gray>
                <x-button.gray type="reset">クリア</x-button.gray>
            </div>
        </form>
        <div class="tw:mt-[20px]">
            <table class="hozen-table tw:w-full">
                <colgroup>
                    <col class="tw:w-[200px]">
                    <col>
                    <col class="tw:w-[100px]">
                    <col class="tw:w-[400px]">
                    <col class="tw:w-[150px]">
                </colgroup>
                <thead class="tw:sticky tw:top-0">
                    <tr>
                        <th>KDDI管理番号</th>
                        <th>現場住所</th>
                        <th>施工業者</th>
                        <th>電柱番号</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr>
                            <td>{{ $item->kddi_cd }}</td>
                            <td>{{ $item->work_address }}</td>
                            <td>{{ $item->trader?->name }}</td>
                            <td>{{ $item->pole_cd }}</td>
                            <td>
                                <div class="tw:flex tw:justify-center tw:gap-x-[10px]">
                                    <a href="{{ route('main.index', ['code' => $item->kddi_cd]) }}"><x-button.gray size="sm">編集</x-button.gray></a>
                                    <x-button.gray size="sm" x-on:click="submitForm('{{ $item->toh_cd }}')">削除</x-button.gray>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <form method="post" action="{{ route('search.delete') }}" x-ref="form">
            @csrf
            <input type="hidden" name="code" x-model="code">
            @foreach(request()->query() as $key => $value)
                <input type="hidden" name="url_query[{{ $key }}]" value="{{ $value }}">
            @endforeach
        </form>
    </div>
</x-app-layout>
<script>
    function deleteForm() {
        return {
            code: '',
            submitForm(code) {
                if (confirm('保守管理表を削除します。\nよろしいですか？')) {
                    this.code = code;
                    this.$nextTick(() => {
                        this.$refs.form.submit();
                    });
                }
            },
        }
    }
</script>
