<div class="w-full max-w-md space-y-8 rounded-2xl border-2 border-amber-500/20 bg-white/90 p-8 shadow-2xl backdrop-blur-md dark:border-amber-500/10 dark:bg-slate-900/80 sm:p-10">
    <div class="text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-400 to-amber-500 shadow-xl shadow-amber-500/30">
            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
        </div>
        <h2 class="mt-6 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">PPE Monitoring System</h2>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Sign in to your account</p>
    </div>

    <form wire:submit="login" class="mt-8 space-y-6">
        <div class="space-y-4">
            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Email address</label>
                <input wire:model="email" id="email" type="email" required autocomplete="email" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-4 py-2.5 text-slate-900 placeholder-slate-400 shadow-sm focus:border-amber-500 focus:bg-white focus:ring-amber-500 sm:text-sm dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-200 dark:placeholder-slate-500" placeholder="admin@dikemas.com">
                @error('email') <span class="mt-1 block text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                <input wire:model="password" id="password" type="password" required autocomplete="current-password" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-4 py-2.5 text-slate-900 placeholder-slate-400 shadow-sm focus:border-amber-500 focus:bg-white focus:ring-amber-500 sm:text-sm dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-200 dark:placeholder-slate-500" placeholder="••••••••">
                @error('password') <span class="mt-1 block text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input wire:model="remember" id="remember-me" type="checkbox" class="h-4 w-4 rounded border-slate-300 bg-slate-50 text-amber-500 focus:ring-amber-500 dark:border-slate-700 dark:bg-slate-800">
                <label for="remember-me" class="ml-2 block text-sm text-slate-600 dark:text-slate-300">Remember me</label>
            </div>
        </div>

        <div>
            <button type="submit" class="group relative flex w-full justify-center rounded-lg border border-transparent bg-gradient-to-r from-amber-500 to-amber-400 px-4 py-2.5 text-sm font-bold tracking-wide text-white shadow-lg shadow-amber-500/30 transition-all hover:scale-[1.02] hover:shadow-amber-500/40 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:ring-offset-slate-50 dark:focus:ring-offset-slate-900">
                <span wire:loading.remove wire:target="login">Sign in</span>
                <span wire:loading wire:target="login" class="flex items-center gap-2">
                    <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Signing in...
                </span>
            </button>
        </div>
    </form>
</div>
