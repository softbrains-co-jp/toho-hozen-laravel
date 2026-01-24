<x-app-layout>
    <div class="tw:bg-pink01 tw:min-h-screen tw:p-2 tw:flex tw:flex-col" x-data="deleteForm()">
        <x-page-title>保守作業報告表</x-page-title>
        <form method="get" action="{{ route('report.index') }}">
            <table class="hozen-table tw:w-full">
                <colgroup>
                    <col class="tw:w-[200px]">
                    <col>
                    <col class="tw:w-[200px]">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th>保守作業報告日</th>
                        <td>
                            <x-forms.input-date type="text" name="maintenance_report_date" value="{{ $condition['maintenance_report_date'] ?? '' }}" class="tw:w-[200px]" />
                        </td>
                        <th>施工業者</th>
                        <td>
                            @if (Auth::user()->role == App\Models\MstUser::ROLE_USER)
                                {{ $traders[Auth::user()->trader_cd] ?? '' }}
                            @else
                                <x-forms.select name="trader_cd" value="{{ $condition['trader_cd'] ?? '' }}" empty=" " :options="$traders" />
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>工事内容</th>
                        <td>
                            <x-forms.select name="construction_content" value="{{ $condition['construction_content'] ?? '' }}" empty=" " :options="$construction_content_options" />
                        </td>
                        <th>進捗詳細</th>
                        <td>
                            <x-forms.select name="progress_detail" value="{{ $condition['progress_detail'] ?? '' }}" empty=" " :options="$progress_detail_options" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="tw:mt-[20px] tw:flex tw:gap-x-[20px] tw:justify-center">
                <x-button.gray type="submit" name="action" value="list">表示</x-button.gray>
            </div>
        </form>
        <div class="tw:mt-[20px]">
            <x-error-message :errors="$errors" />
            <form method="post" action="{{ route('report.post', request()->query()) }}">
                @csrf
                <div class="tw:mb-2">
                    <x-button.gray type="submit">進捗更新</x-button.gray>
                </div>
                <table class="hozen-table tw:w-full">
                    <colgroup>
                        <col class="tw:w-[80px]">
                        <col>
                        <col class="tw:w-[100px]">
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <thead class="tw:sticky tw:top-0">
                        <tr>
                            <th>No.</th>
                            <th>管理番号</th>
                            <th>工事内容</th>
                            <th>作業実施班</th>
                            <th>作業員名</th>
                            <th>支社</th>
                            <th>進捗詳細</th>
                            <th colspan="2">開始</th>
                            <th colspan="2">終了</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $row)
                            <tr>
                                <td>{{ $row['no'] }}</td>
                                <td>
                                    <a href="{{ route('main.index', ['code' => $row['kddi_cd']]) }}" class="tw:underline">
                                        {{ $row['kddi_cd'] }}
                                    </a>
                                </td>
                                <td>{{ $row['construction_content'] }}</td>
                                <td>{{ $row['trader_name'] }}</td>
                                <td>{{ $row['member_name'] }}</td>
                                <td>{{ $row['branch_name'] }}</td>
                                <td>
                                    <x-forms.select name="maintenances[{{ $row['no'] }}][progress_detail]" :value="$row['progress_detail']" :options="$progress_detail_options" />
                                    {{ App\Models\Maintenance::TIME_CDS[$row['time_cd']] ?? '' }}
                                    <input type="hidden" name="maintenances[{{ $row['no'] }}][toh_cd]" value="{{ $row['toh_cd'] }}" />
                                    <input type="hidden" name="maintenances[{{ $row['no'] }}][construction_content]" value="{{ $row['construction_content'] }}" />
                                    <input type="hidden" name="maintenances[{{ $row['no'] }}][old_progress_detail]" value="{{ $row['progress_detail'] }}" />
                                </td>
                                <td>{{ $row['start_time'] }}</td>
                                <td>{{ $row['start_member'] }}</td>
                                <td>{{ $row['end_time'] }}</td>
                                <td>{{ $row['end_member'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
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
