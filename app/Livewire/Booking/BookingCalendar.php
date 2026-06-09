<?php

namespace App\Livewire\Booking;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Buchungskalender'])]
class BookingCalendar extends Component
{
    public string $currentDate;

    public function mount(): void
    {
        $this->currentDate = today()->toDateString();
    }

    public function previousDay(): void
    {
        $this->currentDate = Carbon::parse($this->currentDate)->subDay()->toDateString();
    }

    public function nextDay(): void
    {
        $this->currentDate = Carbon::parse($this->currentDate)->addDay()->toDateString();
    }

    public function today(): void
    {
        $this->currentDate = today()->toDateString();
    }

    public function render()
    {
        $bookings = Booking::with(['customer', 'service', 'assignedTo'])
            ->whereDate('booked_at', $this->currentDate)
            ->orderBy('booked_at')
            ->get();

        $date = Carbon::parse($this->currentDate);

        return view('livewire.booking.booking-calendar', compact('bookings', 'date'));
    }
}
