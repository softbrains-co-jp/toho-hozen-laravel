<x-app-layout>
    <div class="tw:bg-pink01 tw:min-h-screen tw:p-2 tw:flex tw:flex-col" x-data="deleteForm()">
        <x-page-title>帳票インポート</x-page-title>
        <div class="tw:border tw:border-b tw:border-gray-400 tw:p-2 tw:mb-[20px] tw:flex tw:justify-center">
            <div class="tw:w-[60%]">
                作業日報ファイルリスト
                <div class="tw:border tw:border-b tw:border-gray-400 tw:p-2 tw:mb-[20px] tw:h-[100px] tw:bg-[#c1edf59e] tw:flex tw:justify-center">
                    <div class="tw:text-center">
                        <x-icon.cloud-arrow-up class="tw:w-[50px] tw:text-gray-500"/>
                        参照
                    </div>
                </div>
                <x-forms.multi-upload />
            </div>
        </div>
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
