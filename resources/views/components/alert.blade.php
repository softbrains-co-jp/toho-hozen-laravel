@props([
    'type' => ''
])
@php
switch($type){
    case 'success':
        $add_class = 'tw:text-green-500 tw:border-green-500';
        break;
    case 'info':
        $add_class = 'tw:text-blue-600 tw:border-blue-600';
        break;
    case 'error':
        $add_class = 'tw:text-red-500 tw:border-red-500';
        break;
    case 'warning':
        $add_class = 'tw:text-yellow-500 tw:border-yellow-500';
        break;
    default:
        $add_class = 'tw:text-black-500 tw:border-black-500';
        break;
}
@endphp
<x-center-box>
    <div {{ $attributes->merge(['class' => 'tw:font-bold tw:border-2 tw:rounded-lg tw:px-[30px] tw:py-[10px] tw:my-[10px] tw:bg-[#fff6f3] ' . $add_class]) }} >
        {{ $slot }}
    </div>
</x-center-box>
