<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Login' }} — DikemasApp</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-amber-50 to-slate-100 px-4 text-slate-800 antialiased border-t-4 border-amber-500 transition-colors duration-300 dark:from-slate-950 dark:to-slate-900 dark:text-slate-200 sm:px-6 lg:px-8">
    {{ $slot }}
</body>
</html>
