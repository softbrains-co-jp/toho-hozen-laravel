
@livewireScripts
@props([
    'title' => '',
    'code' => '',
])
<!DOCTYPE html>
<html lang="ja" class="tw:text-[12pt]!">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="tw:text-[10pt]">
    <x-toastr-notifications />
    <div class="tw:grid tw:grid-cols-[250px_1fr] tw:gap-[10px] tw:min-h-screen">
        <div class="tw:col-start-1 tw:col-end-2">
            <x-side-menu :code="$code" />
        </div>
        <div class="tw:col-start-2 tw:col-end-3">
            {{ $slot }}
            @stack('scripts')
        </div>
    </div>
</body>
</html>
