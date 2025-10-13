@props([
    'type' => 'text',
    'name' => '',
    'palceholder' => '',
    'after_label' => '',
    'is_error' => false,
])
<input type="{{ $type }}" name="{{ $name }}"
    {{ $attributes->merge(['class' => 'tw:input tw:input-bordered tw:h-[1.8em] tw:px-[4px] tw:w-full tw:bg-white tw:read-only:bg-gray-100' . ($is_error ? ' !tw:bg-red-100 ' : '') . ($after_label ? ' tw:inline-block ' : ''),]) }}
    placeholder="{{ $palceholder }}">
@if ($after_label)
    {{ $after_label}}
@endif
