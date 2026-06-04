<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Login' }} — DikemasApp</title>
    
    <script>
        // Check for theme preference immediately to prevent FOUC, default to dark
        function applyTheme() {
            if (localStorage.theme === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        }
        applyTheme();
        document.addEventListener('livewire:navigated', applyTheme);
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-50 px-4 text-slate-800 antialiased transition-colors duration-300 dark:bg-slate-950 dark:text-slate-200 sm:px-6 lg:px-8">
    {{ $slot }}
</body>
</html>
