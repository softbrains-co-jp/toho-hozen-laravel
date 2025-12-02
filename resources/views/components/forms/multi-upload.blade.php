@props([
    'name' => 'files',
    'maxFileCount' => 0,
    'maxFileSize' => 0,
    'allowMimeTypes' => [],
    'files' => [],
])

<div
    x-data="multiFileUpload({
        name: '{{ $name }}',
        maxFileCount: {{ $maxFileCount }},
        maxFileSize: {{ $maxFileSize }},
        allowMimeTypes: {{ json_encode($allowMimeTypes) }},
        initialFiles: {{ json_encode($files) }}
    })"
    class="tw:w-full tw:multi-file-upload"
>
    <!-- ドロップエリア -->
    <div
        @click="triggerFileInput"
        @drop.prevent="handleDrop($event)"
        @dragover.prevent
        @dragenter.prevent
        class="tw:p-2 tw:bg-[#ecf8fa9e] tw:border tw:border-zinc-300 tw:mb-2 tw:text-center tw:cursor-pointer"
    >
        <x-icon.cloud-arrow-up class="tw:w-[50px] tw:text-gray-500"/>
        <div class="tw:text-[10pt]">参照</div>
    </div>

    <!-- ファイル入力（非表示） -->
    <input
        type="file"
        multiple
        x-ref="fileInput"
        @change="handleFileSelect"
        class="tw:hidden"
    >

    <!-- ファイルリスト -->
    <div class="tw:flex tw:flex-col tw:gap-1">
        <template x-for="(file, index) in files" :key="index">
            <div class="tw:flex tw:items-center tw:px-2 tw:text-[11pt]">
                <div class="tw:w-4">
                    <template x-if="file.type.includes('image')">
                        <i class="far fa-file-image"></i>
                    </template>
                    <template x-if="file.type === 'application/pdf'">
                        <i class="far fa-file-pdf"></i>
                    </template>
                    <template x-if="file.type.includes('excel')">
                        <i class="far fa-file-excel"></i>
                    </template>
                    <template x-if="!['image','pdf','excel'].some(t => file.type.includes(t))">
                        <i class="far fa-file"></i>
                    </template>
                </div>
                <div class="tw:pr-[10px]" x-text="file.name"></div>
                <div class="tw:w-5 tw:text-right">
                    <button type="button" @click="removeFile(index)">
                        <x-icon.trash class="tw:stroke-2 tw:w-[20px] tw:text-red-500"/>
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
function multiFileUpload({ name, maxFileCount, maxFileSize, allowMimeTypes, initialFiles }) {
    return {
        files: initialFiles || [],

        triggerFileInput() {
            this.$refs.fileInput.click();
        },

        handleFileSelect(event) {
            const selectedFiles = Array.from(event.target.files);
            this.addFiles(selectedFiles);
            event.target.value = ''; // 選択リセット
        },

        handleDrop(event) {
            const dtFiles = Array.from(event.dataTransfer.files);
            this.addFiles(dtFiles);
        },

        addFiles(newFiles) {
            newFiles.forEach(file => {
                if (maxFileCount > 0 && this.files.length >= maxFileCount) {
                    alert('これ以上アップロードできません');
                    return;
                }
                if (maxFileSize > 0 && file.size > maxFileSize) {
                    alert(file.name + ' はサイズオーバーです');
                    return;
                }
                if (allowMimeTypes.length > 0 && !allowMimeTypes.includes(file.type)) {
                    alert(file.name + ' はアップロードできません');
                    return;
                }
                this.files.push(file);
            });
        },

        removeFile(index) {
            this.files.splice(index, 1);
        }
    }
}
</script>
