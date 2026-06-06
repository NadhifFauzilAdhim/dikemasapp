<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PPE Violation Monitoring Dashboard - Real-time safety monitoring">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-header.png') }}?v=2">

    <!-- PWA Setup -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#f59e0b">
    <link rel="apple-touch-icon" href="{{ asset('image/logo-header.png') }}">

    <title>{{ $title ?? 'Dikemas Ops' }} — Industrial Monitoring</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-100 via-amber-50/20 to-slate-200/40 text-slate-800 antialiased transition-colors duration-300 dark:from-slate-950 dark:to-slate-900 dark:text-slate-200 border-t-4 border-amber-500">
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <x-layouts.sidebar />

        {{-- Overlay for mobile sidebar --}}
        <div id="sidebar-overlay"
            class="fixed inset-0 z-20 hidden bg-slate-900/50 backdrop-blur-sm dark:bg-black/50 lg:hidden"
            onclick="toggleSidebar()"></div>

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto overflow-x-hidden">
            {{-- Top Bar --}}
            <x-layouts.topbar :title="$title ?? 'Dashboard'" />
            <div class="p-6">
                {{ $slot }}
            </div>
        </main>
    </div>

    <script data-navigate-once>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar) sidebar.classList.toggle('-translate-x-full');
            if (overlay) overlay.classList.toggle('hidden');
        }

        document.addEventListener('livewire:navigated', function() {
            // Time logic
            function updateTime() {
                const el = document.getElementById('current-time');
                if (el) {
                    el.textContent = new Date().toLocaleString('id-ID', {
                        dateStyle: 'medium',
                        timeStyle: 'medium'
                    });
                }
            }
            updateTime();
            if (window.timeInterval) clearInterval(window.timeInterval);
            window.timeInterval = setInterval(updateTime, 1000);
        });
    </script>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then(registration => {
                    console.log('SW registered: ', registration);
                }).catch(registrationError => {
                    console.log('SW registration failed: ', registrationError);
                });
            });
        }
    </script>
</body>

</html>
