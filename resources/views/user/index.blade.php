<x-app-layout>
    <div class="tw:bg-pink01 tw:min-h-screen tw:p-2 tw:flex tw:flex-col" x-data="deleteForm()">
        <x-page-title>ユーザ一覧</x-page-title>
        <div class="tw:mt-[20px]">
            <div class="tw:mb-[5px]">
                <a href="{{ route('user.add.index') }}"><x-button.gray>新規作成</x-button.gray></a>
            </div>
            <table class="hozen-table tw:w-full">
                <colgroup>
                    <col class="tw:w-[80px]">
                    <col>
                    <col>
                    <col>
                    <col class="tw:w-[150px]">
                </colgroup>
                <thead class="tw:sticky tw:top-0">
                    <tr>
                        <th>ID</th>
                        <th>ログインID</th>
                        <th>名前</th>
                        <th>メールアドレス</th>
                        <th>権限</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->login_id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ App\Models\MstUser::ROLES[$item->role] ?? '' }}</td>
                            <td>
                                <div class="tw:flex tw:justify-center tw:gap-x-[10px]">
                                    <a href="{{ route('user.edit.index', ['id' => $item->id]) }}"><x-button.gray size="sm">編集</x-button.gray></a>
                                    <x-button.gray size="sm" x-on:click="submitForm('{{ $item->id }}')">削除</x-button.gray>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <form method="post" action="{{ route('user.delete') }}" x-ref="form">
            @csrf
            <input type="hidden" name="id" x-model="id">
            @foreach(request()->query() as $key => $value)
                <input type="hidden" name="url_query[{{ $key }}]" value="{{ $value }}">
            @endforeach
        </form>
    </div>
</x-app-layout>
<script>
    function deleteForm() {
        return {
            id: '',
            submitForm(id) {
                if (confirm('ユーザを削除します。\nよろしいですか？')) {
                    this.id = id;
                    this.$nextTick(() => {
                        this.$refs.form.submit();
                    });
                }
            },
        }
    }
</script>
