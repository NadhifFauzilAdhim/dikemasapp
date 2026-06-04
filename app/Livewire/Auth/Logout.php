<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class Logout extends Component
{
    public string $type = 'sidebar';

    public function logout(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirect(route('login', absolute: false), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.auth.logout');
    }
}
