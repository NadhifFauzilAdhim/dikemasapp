<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CountingSession extends Model
{
    protected $fillable = [
        'device_id',
        'source_id',
        'current_count',
        'status',
        'fps',
        'last_heartbeat_at',
        'session_started_at',
        'metadata',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'current_count' => 'integer',
            'fps' => 'float',
            'last_heartbeat_at' => 'datetime',
            'session_started_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    // ── Scopes ──

    /**
     * Scope to sessions that are actively running (heartbeat within 30 seconds).
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '!=', 'stopped')
            ->where('last_heartbeat_at', '>=', now()->subSeconds(30));
    }

    /**
     * Scope to sessions that have gone stale (no heartbeat for 30+ seconds).
     */
    public function scopeStale(Builder $query): Builder
    {
        return $query->whereIn('status', ['started', 'running'])
            ->where('last_heartbeat_at', '<', now()->subSeconds(30));
    }

    // ── Helpers ──

    /**
     * Check if session is considered online (heartbeat within 30 seconds).
     */
    public function isOnline(): bool
    {
        if (! $this->last_heartbeat_at) {
            return false;
        }

        return $this->last_heartbeat_at->diffInSeconds(now()) <= 30;
    }

    /**
     * Get the display status considering staleness.
     */
    public function getDisplayStatusAttribute(): string
    {
        if ($this->status === 'stopped') {
            return 'stopped';
        }

        return $this->isOnline() ? $this->status : 'disconnected';
    }

    /**
     * Get the uptime duration string.
     */
    public function getUptimeAttribute(): string
    {
        if (! $this->session_started_at || $this->status === 'stopped') {
            return '—';
        }

        return $this->session_started_at->diffForHumans(now(), [
            'parts' => 2,
            'short' => true,
            'syntax' => CarbonInterface::DIFF_ABSOLUTE,
        ]);
    }
}
