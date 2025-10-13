@props([
    'errors'
])
@if ($errors->all())
<x-alert type="error">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
</x-alert>
@endif
