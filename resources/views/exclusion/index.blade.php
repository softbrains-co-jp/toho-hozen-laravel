<x-app-layout>
    <div class="tw:bg-pink01 tw:h-screen tw:p-2 tw:flex tw:flex-col" x-data="masterForm()">
        <x-page-title>管理番号一覧</x-page-title>
        <div class="tw:grow tw:overflow-y-scroll">
            <table class="hozen-table tw:w-full">
                <colgroup>
                    <col>
                    <col>
                    <col>
                    <col class="tw:w-[100px]">
                </colgroup>
                <thead class="tw:sticky tw:top-0">
                    <tr>
                        <th>管理番号</th>
                        <th>使用ユーザー</th>
                        <th>取得日時</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr>
                            <td>{{ $item->toh_cd }}</td>
                            <td>{{ $item->login_id }}</td>
                            <td>{{ $item->add_datetime?->format('Y/m/d H:i:s') }}</td>
                            <td>
                                <div class="tw:flex tw:justify-center tw:gap-x-[10px]">
                                    <x-button.gray x-on:click="deleteExclusion('{{ $item->toh_cd }}')">解除</x-button.gray>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <form method="post" action="{{ route('exclusion.delete') }}" x-ref="exclusion_form">
            @csrf
            <input type="hidden" name="toh_cd" x-ref="toh_cd">
        </form>
    </div>
</x-app-layout>
<script>
    function masterForm() {
        return {
            deleteExclusion(code) {
                console.log(code);
                if (confirm('本当に解除しますか？')) {
                    this.$refs.toh_cd.value = code;
                    this.$refs.exclusion_form.submit();
                }
            }
        }
    }
</script>

