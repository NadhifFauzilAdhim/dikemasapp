<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('API Keys')]
class ApiKeys extends Component
{
    public string $name = '';
    public ?string $newKey = null;

    public function generate(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        $token = Auth::user()->createToken($this->name);

        $this->newKey = $token->plainTextToken;
        $this->name = '';
    }

    public function revoke(int $id): void
    {
        Auth::user()->tokens()->where('id', $id)->delete();
    }

    public function render(): View
    {
        return view('livewire.api-keys', [
            'keys' => Auth::user()->tokens()->latest()->get(),
        ]);
    }
}
