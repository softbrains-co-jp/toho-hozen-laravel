<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="tw:bg-red-50 tw:h-screen">
    <div>
        Tailwindテスト画面
    </div>

    <input type="text" placeholder="Type here" class="tw:input" />
    <input type="text" placeholder="Type here" class="tw:input" />
</body>
</html>
