<div>
    @section('title', 'API Keys')

    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <h3 class="mb-2 text-lg font-semibold text-slate-900 dark:text-white">Generate New API Key</h3>
        <p class="mb-4 text-sm text-slate-500 dark:text-slate-400">Create an API key for your CCTV detection systems to authenticate with this monitoring server.</p>
        
        <form wire:submit="generate" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[250px]">
                <label for="name" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Key Name / Camera Location</label>
                <input wire:model="name" id="name" type="text" required class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-200 dark:placeholder-slate-500" placeholder="e.g. Factory Entrance Camera">
                @error('name') <span class="mt-1 block text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="rounded-lg bg-amber-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm shadow-amber-500/20 transition-all hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:ring-offset-slate-50 dark:focus:ring-offset-slate-900">
                Generate Key
            </button>
        </form>

        @if ($newKey)
            <div class="mt-6 rounded-lg border border-emerald-500/30 bg-emerald-50 p-4 dark:bg-emerald-500/10">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-emerald-800 dark:text-emerald-400">API Key Generated Successfully</h3>
                        <div class="mt-2 text-sm text-emerald-700 dark:text-emerald-200/80">
                            <p>Please copy this API key and store it safely. For security reasons, you will <strong>not be able to see it again</strong>.</p>
                        </div>
                        <div class="mt-3 flex items-center gap-3">
                            <code class="block w-full rounded bg-emerald-100/50 px-3 py-2 font-mono text-sm text-emerald-900 border border-emerald-500/20 break-all select-all dark:bg-emerald-950/50 dark:text-emerald-300">{{ $newKey }}</code>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Active Keys Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Active API Keys</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-left text-xs uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:text-slate-400">
                        <th class="px-5 py-3 font-semibold">Name</th>
                        <th class="px-5 py-3 font-semibold">Created</th>
                        <th class="px-5 py-3 font-semibold">Last Used</th>
                        <th class="px-5 py-3 text-right font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($keys as $key)
                        <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="px-5 py-3 text-slate-900 font-medium dark:text-slate-200">{{ $key->name }}</td>
                            <td class="px-5 py-3 text-slate-500 dark:text-slate-400">{{ $key->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-5 py-3 text-slate-500 dark:text-slate-400">
                                @if ($key->last_used_at)
                                    {{ $key->last_used_at->diffForHumans() }}
                                @else
                                    <span class="text-slate-400 dark:text-slate-500">Never</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <button wire:click="revoke({{ $key->id }})" wire:confirm="Are you sure you want to revoke this API key? Systems using it will immediately lose access." class="text-xs font-medium text-red-600 hover:text-red-500 transition-colors dark:text-red-500 dark:hover:text-red-400">
                                    Revoke
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-slate-500">
                                No API keys generated yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
