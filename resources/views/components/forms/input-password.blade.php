@props([
    'name' => '',
    'placeholder' => '',
    'is_error' => false,
])
<div x-data="{ show: false }"
    @class([
        'tw:relative tw:inline-flex tw:items-center tw:h-[1.8em] tw:bg-transparent',
        'tw:w-full' => !$attributes->has('class') || !str_contains($attributes->get('class'), 'tw:w-'),
        $attributes->get('class'),
    ])
>
    <input :type="show ? 'text' : 'password'" name="{{ $name }}"
        class="tw:input tw:px-[4px] tw:h-full tw:m-0 tw:bg-white {{ ($is_error ? ' !tw:bg-red-100 ' : '') }}" placeholder="{{ $placeholder }}"
        {{ $attributes->except('class') }}
    >
    <button type="button" @click="show = !show" class="tw:absolute tw:right-[3px] tw:top-[1px] tw:bottom-[1px] tw:px-[6px] tw:text-gray-500 tw:cursor-pointer hover:tw:text-gray-700 tw:bg-transparent tw:border-none tw:flex tw:items-center tw:rounded tw:z-[10]">
        {{-- 目のアイコン（表示時） --}}
        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="tw:h-4 tw:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        {{-- 目に斜線アイコン（非表示時） --}}
        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="tw:h-4 tw:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        </svg>
    </button>
</div>
{{-- {{ $attributes->merge(['class' => 'tw:input tw:input-bordered tw:h-[1.8em] tw:px-[4px] tw:pr-[28px] tw:w-full tw:bg-white tw:read-only:bg-gray-100' . ($is_error ? ' !tw:bg-red-100 ' : '') . ($after_label ? ' tw:inline-block ' : ''),]) }} --}}
