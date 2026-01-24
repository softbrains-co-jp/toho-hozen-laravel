@props([
    'value' => '',
    'options' => [],
])
@if (Auth::user()->role == App\Models\MstUser::ROLE_USER)
    {{ $options[$value] ?? '' }}
@else
<x-forms.select :value="$value" :options="$options" {{ $attributes }} />
@endif
