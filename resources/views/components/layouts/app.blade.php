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
    class="min-h-screen bg-gradient-to-br from-slate-100 via-slate-50 to-slate-200/50 text-slate-800 antialiased transition-colors duration-300 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 dark:text-slate-200 border-t-4 border-amber-500">
    <!-- Ambient Graphic Background Elements -->
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden select-none">
        <!-- Tech Dot Grid -->
        <div class="absolute inset-0 opacity-[0.25] dark:opacity-[0.08]" 
             style="background-image: radial-gradient(rgba(148, 163, 184, 0.5) 1.5px, transparent 1.5px); background-size: 24px 24px;"></div>
        
        <!-- Subtle Top-Right Ambient Glow (Amber) -->
        <div class="absolute -top-[20%] -right-[10%] w-[600px] h-[600px] rounded-full bg-gradient-to-br from-amber-400/20 to-amber-300/0 blur-[130px] dark:from-amber-500/10 dark:to-transparent"></div>
        
        <!-- Subtle Bottom-Left Ambient Glow (Blue/Slate) -->
        <div class="absolute -bottom-[20%] -left-[10%] w-[600px] h-[600px] rounded-full bg-gradient-to-tr from-blue-400/10 to-indigo-300/0 blur-[130px] dark:from-blue-500/5 dark:to-transparent"></div>
        
        <!-- Faint HUD/Tech Accent Lines -->
        <div class="absolute left-1/4 top-0 h-full w-px bg-gradient-to-b from-transparent via-slate-200/30 to-transparent dark:via-slate-800/10"></div>
        <div class="absolute left-3/4 top-0 h-full w-px bg-gradient-to-b from-transparent via-slate-200/30 to-transparent dark:via-slate-800/10"></div>
    </div>

    <div class="relative z-10 flex h-screen overflow-hidden">
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
            <div class="p-4 md:p-6">
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
