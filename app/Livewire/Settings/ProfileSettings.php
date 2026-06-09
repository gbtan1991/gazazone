<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Einstellungen'])]
class ProfileSettings extends Component
{
    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|email|max:255')]
    public string $email = '';

    #[Rule('nullable|min:8|max:255')]
    public string $newPassword = '';

    #[Rule('nullable|same:newPassword')]
    public string $confirmPassword = '';

    public function mount(): void
    {
        $this->name  = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name'  => $this->name,
            'email' => $this->email,
        ];

        if ($this->newPassword) {
            $data['password'] = $this->newPassword;
        }

        auth()->user()->update($data);

        $this->newPassword     = '';
        $this->confirmPassword = '';

        session()->flash('success', 'Profil gespeichert.');
    }

    public function render()
    {
        return view('livewire.settings.profile-settings');
    }
}
