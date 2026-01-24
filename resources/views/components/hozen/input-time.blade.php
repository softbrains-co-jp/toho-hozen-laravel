@if (Auth::user()->role == App\Models\MstUser::ROLE_USER)
    {{ $value }}
@else
<x-forms.input-time :value="$value" {{ $attributes }} />
@endif
