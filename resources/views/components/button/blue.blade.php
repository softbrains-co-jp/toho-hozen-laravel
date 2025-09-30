
@props([
    'type' => 'button'
])
<button type="{{ $type }}" {{ $attributes->merge(['class' => 'bg-[#007bff] hover:bg-[#0069d9] disabled:bg-gray-300 rounded-2xl text-white px-[20px] py-[8px] font-bold text-[2rem] min-w-[200px] text-center border-none outline-none']) }}>{{ $slot }}</button>
