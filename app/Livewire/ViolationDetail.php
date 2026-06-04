<?php

namespace App\Livewire;

use App\Models\PpeViolation;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ViolationDetail extends Component
{
    public PpeViolation $violation;

    public bool $showRawPayload = false;

    public function mount(PpeViolation $violation): void
    {
        $this->violation = $violation;
    }

    public function toggleRawPayload(): void
    {
        $this->showRawPayload = ! $this->showRawPayload;
    }

    public function render(): View
    {
        return view('livewire.violation-detail')
            ->title('Violation #'.$this->violation->id);
    }
}
