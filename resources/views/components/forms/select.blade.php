@props([
    'name' => '',
    'value' => '',
    'empty' => '',
    'options' => [],
    'is_error' => false,
])
<select
    name="{{ $name }}"
    @class([
        'tw:select tw:select-bordered tw:h-[1.7rem]  tw:bg-white tw:!pl-[5px]',
        'tw:w-auto' => !$attributes->has('class') || !str_contains($attributes->get('class'), 'tw:w-'),
        $attributes->get('class'),
        'tw:bg-red-100' => $is_error,
    ])
    {{ $attributes->except('class') }}
>
    @if ($empty)
        <option value="">{{ $empty }}</option>
    @endif
    @foreach ($options as $key => $item)
        <option value="{{ $key }}" {{ $key == $value ? 'selected' : '' }}>{{$item}}</option>
    @endforeach
</select>
