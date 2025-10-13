{{-- @foreach (['success', 'error', 'warning', 'info'] as $msg)
    @if (session($msg))
        <x-alert :type="$msg">
            {{ session($msg) }}
        </x-alert>
    @endif
@endforeach --}}
@push('scripts')
@endpush
