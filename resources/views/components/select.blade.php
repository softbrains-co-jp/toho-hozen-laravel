@props([
    'name' => '',
    'value' => '',
    'empty' => '',
    'options' => [],
    'is_error' => false,
])
<select name="{{ $name }}" {{ $attributes->merge([
    'class' => 'tw:select tw:select-bordered tw:text-[12pt] tw:h-[1.7rem] tw:w-full tw:bg-white tw:!w-auto' . ($is_error ? ' tw:bg-red-100 ' : ''),
]) }} >
    @if ($empty)
        <option value="">{{ $empty }}</option>
    @endif
    @foreach ($options as $key => $item)
        <option value="{{ $key }}" {{ $key == $value ? 'selected' : '' }}>{{$item}}</option>
    @endforeach
</select>
