@props([
    'value' => '',
])
@if (Auth::user()->role == App\Models\MstUser::ROLE_USER)
    {{ $value }}
@else
<x-forms.input-date :value="$value" {{ $attributes }} />
@endif
