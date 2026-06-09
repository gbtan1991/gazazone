<?php

namespace App\Livewire\Settings;

use App\Enums\ClientUserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Team verwalten'])]
class TeamSettings extends Component
{
    public bool $showForm = false;

    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|email|max:255|unique:users,email')]
    public string $email = '';

    #[Rule('required|min:8')]
    public string $password = '';

    public string $role = 'staff';

    public function save(): void
    {
        $this->validate();

        User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
            'role'     => $this->role,
        ]);

        session()->flash('success', 'Mitarbeiter hinzugefügt.');
        $this->showForm = false;
        $this->reset(['name', 'email', 'password', 'role']);
    }

    public function render()
    {
        $users = User::orderBy('name')->get();

        return view('livewire.settings.team-settings', compact('users'));
    }
}
