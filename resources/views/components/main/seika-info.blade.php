@props([
    'maintenance' => null,
    'seika_files' => [],
])
<div {{ $attributes }} >
    ■成果物
    <ul class="tw:list-disc tw:mt-[5px] tw:pl-[30px]">
        @foreach ($seika_files as $seika_file)
            <li class="tw:h-[1.8rem]"><a href="{{ route('main.download', ['code' => $maintenance?->toh_cd, 'filename' => urlencode($seika_file->getFilename())]) }}" class="tw:underline">{{ $seika_file->getFilename() }}</a></li>
        @endforeach
    </ul>
</div>
