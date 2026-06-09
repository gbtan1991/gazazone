<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Login extends Component
{
    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required|min:8')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', 'Diese Zugangsdaten sind ungültig.');
            return;
        }

        $clientUser = Auth::user();
        $clientId   = $clientUser->client_id;

        session()->regenerate();

        $this->redirect(route('tenant.dashboard', ['tenant' => $clientId]), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
