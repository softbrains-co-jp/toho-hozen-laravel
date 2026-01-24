@if (Auth::user()->role == App\Models\MstUser::ROLE_USER)
    {!! nl2br($slot) !!}
@else
<x-forms.textarea {{ $attributes }} >{{ $slot }}</x-forms.textarea>
@endif
