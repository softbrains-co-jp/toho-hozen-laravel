<x-app-layout>
    <div class="tw:bg-pink01 tw:min-h-screen tw:p-2 tw:flex tw:flex-col" x-data="deleteForm()">
        <x-page-title>帳票インポート</x-page-title>
        <x-error-message :errors="$errors" />
        <form method="post" action="{{ route('import.daily-report') }}" class="tw:w-full" enctype="multipart/form-data">
            @csrf
            <div class="tw:border tw:border-b tw:border-gray-400 tw:p-2 tw:mb-[20px] tw:flex tw:flex-col tw:items-center tw:py-[20px]">
                <div class="tw:w-[60%]">
                    作業日報ファイルリスト
                    <x-forms.multi-upload
                        name="daily_reports"
                        :allowMimeTypes="[
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ]"
                    />
                </div>
                <x-button.blue type="submit" class="tw:mt-[10px]">作業日報取り込み</x-button.blue>
            </div>
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
