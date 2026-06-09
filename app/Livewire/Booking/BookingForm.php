<?php

namespace App\Livewire\Booking;

use App\Actions\CreateBooking;
use App\Enums\BookingStatus;
use App\Models\Service;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Neue Buchung'])]
class BookingForm extends Component
{
    #[Rule('required|string|max:255')]
    public string $customerName = '';

    #[Rule('nullable|email|max:255')]
    public string $customerEmail = '';

    #[Rule('nullable|string|max:50')]
    public string $customerPhone = '';

    #[Rule('required|uuid|exists:services,id')]
    public string $serviceId = '';

    #[Rule('nullable|uuid|exists:users,id')]
    public string $assignedTo = '';

    #[Rule('required|date|after_or_equal:today')]
    public string $bookedDate = '';

    #[Rule('required|date_format:H:i')]
    public string $bookedTime = '';

    #[Rule('nullable|string|max:2000')]
    public string $notes = '';

    public function mount(): void
    {
        $this->bookedDate = today()->toDateString();
        $this->bookedTime = now()->addHour()->startOfHour()->format('H:i');
    }

    public function save(CreateBooking $action): void
    {
        $this->validate();

        $action->execute(
            customerName:  $this->customerName,
            customerEmail: $this->customerEmail ?: null,
            customerPhone: $this->customerPhone ?: null,
            serviceId:     $this->serviceId,
            assignedTo:    $this->assignedTo ?: null,
            bookedAt:      $this->bookedDate . ' ' . $this->bookedTime,
            notes:         $this->notes ?: null,
        );

        session()->flash('success', 'Buchung erfolgreich erstellt.');
        $this->redirect(route('tenant.booking.calendar', request()->route('tenant')), navigate: true);
    }

    public function render()
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $users    = User::orderBy('name')->get();

        return view('livewire.booking.booking-form', compact('services', 'users'));
    }
}
