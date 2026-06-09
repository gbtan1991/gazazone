<?php

namespace App\Livewire\Booking;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Leistungen verwalten'])]
class ServiceManager extends Component
{
    public bool $showForm = false;
    public ?string $editingId = null;

    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|integer|min:15|max:480')]
    public int $durationMinutes = 60;

    #[Rule('required|numeric|min:0')]
    public string $priceChf = '0';

    public bool $isActive = true;

    public function openCreate(): void
    {
        $this->reset(['name', 'durationMinutes', 'priceChf', 'isActive', 'editingId']);
        $this->isActive = true;
        $this->durationMinutes = 60;
        $this->priceChf = '0';
        $this->showForm = true;
    }

    public function openEdit(string $id): void
    {
        $service = Service::findOrFail($id);
        $this->editingId      = $id;
        $this->name           = $service->name;
        $this->durationMinutes = $service->duration_minutes;
        $this->priceChf       = (string) $service->price_chf;
        $this->isActive       = $service->is_active;
        $this->showForm       = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name'             => $this->name,
            'duration_minutes' => $this->durationMinutes,
            'price_chf'        => $this->priceChf,
            'is_active'        => $this->isActive,
        ];

        if ($this->editingId) {
            Service::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Leistung aktualisiert.');
        } else {
            Service::create($data);
            session()->flash('success', 'Leistung erstellt.');
        }

        $this->showForm = false;
        $this->reset(['name', 'durationMinutes', 'priceChf', 'isActive', 'editingId']);
    }

    public function toggleActive(string $id): void
    {
        $service = Service::findOrFail($id);
        $service->update(['is_active' => ! $service->is_active]);
    }

    public function render()
    {
        $services = Service::orderBy('name')->get();

        return view('livewire.booking.service-manager', compact('services'));
    }
}
