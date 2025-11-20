<x-app-layout>
    <div class="tw:bg-pink01 tw:h-screen tw:p-2 tw:flex tw:flex-col">
        <x-page-title>{{ $title }}</x-page-title>
        <x-error-message :errors="$errors" />
        <form method="post">
            @csrf
            <table class="hozen-table tw:w-full">
                <colgroup>
                    <col class="tw:w-[150px]">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th>コード</th>
                        <td>
                            <x-forms.input type="text" name="code" value="{{ old('code', $data->code) }}" class="tw:!w-[100px]" required />
                        </td>
                    </tr>
                    <tr>
                        <th>名称</th>
                        <td>
                            <x-forms.input type="text" name="name" value="{{ old('name', $data->name) }}" required />
                        </td>
                    </tr>
                    <tr>
                        <th>ID(並び順)</th>
                        <td>
                            <x-forms.input type="text" name="sort" value="{{ old('sort', $data->sort) }}" class="tw:!w-[100px]" required />
                        </td>
                    </tr>
                </tbody>
            <table>
            <div class="tw:mt-[20px] tw:flex tw:gap-x-[20px] tw:justify-center">
                <x-button.gray type="submit">更新</x-button.gray>
                <a href="{{ route('master.index', ['kind' => $kind]) }}"><x-button.gray>キャンセル</x-button.gray></a>
            </div>
            <input type="hidden" name="id" value="{{ $data->id }}">
            <input type="hidden" name="table" value="{{ $data->getTable() }}">
        </form>
    </div>
</x-app-layout>
