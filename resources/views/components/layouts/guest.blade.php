<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Login' }} — Dikemas Ops</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative flex min-h-screen items-center justify-center bg-slate-50 px-4 text-slate-800 antialiased border-t-4 border-amber-500 dark:bg-slate-950 dark:text-slate-200 sm:px-6 lg:px-8">
    <div class="fixed inset-0 z-0 bg-cover bg-center bg-no-repeat opacity-30 dark:opacity-20 mix-blend-multiply dark:mix-blend-screen" style="background-image: url('{{ asset('image/dikemasloginbackground.jpg') }}'); filter: blur(2px);"></div>
    <div class="relative z-10 w-full flex justify-center">
        {{ $slot }}
    </div>
</body>
</html>
