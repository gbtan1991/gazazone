<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\FollowUp;
use App\Models\Project;
use App\Enums\BookingStatus;
use App\Enums\ProjectStatus;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Dashboard'])]
class Dashboard extends Component
{
    public function render()
    {
        $todayBookings = Booking::whereDate('booked_at', today())
            ->whereNotIn('status', [BookingStatus::Cancelled->value, BookingStatus::NoShow->value])
            ->count();

        $openFollowUps = FollowUp::where('completed', false)
            ->where('due_at', '<=', now()->addDays(7))
            ->count();

        $activeProjects = Project::where('status', ProjectStatus::Active)->count();

        $newLeads = Customer::where('pipeline_stage', 'lead')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->count();

        $upcomingBookings = Booking::with(['customer', 'service'])
            ->whereDate('booked_at', today())
            ->whereNotIn('status', [BookingStatus::Cancelled->value, BookingStatus::NoShow->value])
            ->orderBy('booked_at')
            ->limit(5)
            ->get();

        $overdueFollowUps = FollowUp::with('customer')
            ->where('completed', false)
            ->where('due_at', '<', now())
            ->orderBy('due_at')
            ->limit(5)
            ->get();

        return view('livewire.dashboard', compact(
            'todayBookings',
            'openFollowUps',
            'activeProjects',
            'newLeads',
            'upcomingBookings',
            'overdueFollowUps',
        ));
    }
}
