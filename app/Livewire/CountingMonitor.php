<?php

namespace App\Livewire;

use App\Models\CountingSession;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Production Monitoring')]
class CountingMonitor extends Component
{
    /**
     * Get all counting sessions.
     *
     * @return Collection<int, CountingSession>
     */
    #[Computed]
    public function sessions(): Collection
    {
        // Mark stale sessions as disconnected
        CountingSession::stale()->update(['status' => 'disconnected']);

        return CountingSession::query()
            ->orderByRaw("FIELD(status, 'running', 'started', 'disconnected', 'stopped')")
            ->orderByDesc('last_heartbeat_at')
            ->get();
    }

    /**
     * Get total active device count.
     */
    #[Computed]
    public function activeCount(): int
    {
        return CountingSession::active()->count();
    }

    /**
     * Get total production count across all running sessions.
     */
    #[Computed]
    public function totalProduction(): int
    {
        return (int) CountingSession::whereIn('status', ['started', 'running'])
            ->where('last_heartbeat_at', '>=', now()->subSeconds(30))
            ->sum('current_count');
    }

    /**
     * Get total sessions count.
     */
    #[Computed]
    public function totalSessions(): int
    {
        return CountingSession::count();
    }

    public function render(): View
    {
        return view('livewire.counting-monitor');
    }
}
