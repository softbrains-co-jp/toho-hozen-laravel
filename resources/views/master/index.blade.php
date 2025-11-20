<x-app-layout>
    <div class="tw:bg-pink01 tw:h-screen tw:p-2 tw:flex tw:flex-col" x-data="masterForm()">
        <x-page-title>{{ $title }}</x-page-title>
        <div class="tw:mb-[20px]">
            <x-button.gray><a href="{{ route('master.add', ['kind' => $kind]) }}">新規作成</a></x-button.gray>
        </div>
        <div class="tw:grow tw:overflow-y-scroll">
            <table class="hozen-table tw:w-full">
                <colgroup>
                    <col class="tw:w-[100px]">
                    <col>
                    <col class="tw:w-[100px]">
                    <col class="tw:w-[250px]">
                </colgroup>
                <thead class="tw:sticky tw:top-0">
                    <tr>
                        <th>コード</th>
                        <th>名称</th>
                        <th>ID(並び順)</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->sort }}</td>
                            <td>
                                <div class="tw:flex tw:justify-center tw:gap-x-[10px]">
                                    <a href="{{ route('master.edit', ['kind' => $kind, 'id' => $item->id]) }}"><x-button.gray>編集</x-button.gray></a>
                                    <x-button.gray x-on:click="deleteMaster({{ $item->id }})">削除</x-button.gray>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <form method="post" action="{{ route('master.delete', ['kind' => $kind]) }}" x-ref="delete_form">
            @csrf
            <input type="hidden" name="id" x-ref="delete_id">
        </form>
    </div>
</x-app-layout>
<script>
    function masterForm() {
        return {
            deleteMaster(id) {
                console.log(id);
                if (confirm('本当に削除しますか？')) {
                    this.$refs.delete_id.value = id;
                    this.$refs.delete_form.submit();
                }
            }
        }
    }
</script>

