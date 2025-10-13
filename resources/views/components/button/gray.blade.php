
@props([
    'type' => 'button',
    'size' => ''
])
<button type="{{ $type }}" {{ $attributes->merge(['class' => 'tw:px-[8px] tw:py-[4px] tw:min-w-[100px] tw:rounded-md tw:bg-neutral-content tw:hover:bg-base-200 text-[#585d63] tw:text-center tw:border tw:outline-none tw:cursor-pointer']) }}>{{ $slot }}</button>
