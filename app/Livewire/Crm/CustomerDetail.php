<?php

namespace App\Livewire\Crm;

use App\Enums\ActivityType;
use App\Enums\PipelineStage;
use App\Models\Customer;
use App\Models\FollowUp;
use App\Models\PipelineActivity;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Kundendetails'])]
class CustomerDetail extends Component
{
    public Customer $customer;

    public string $activityType = 'note';
    public string $activityContent = '';

    #[Rule('required|string|max:255')]
    public string $followUpTitle = '';

    #[Rule('required|date|after_or_equal:today')]
    public string $followUpDue = '';

    public bool $showFollowUpForm = false;

    public function mount(Customer $customer): void
    {
        $this->customer = $customer;
        $this->followUpDue = today()->addDay()->toDateString();
    }

    public function logActivity(): void
    {
        if (empty($this->activityContent)) {
            return;
        }

        PipelineActivity::create([
            'customer_id' => $this->customer->id,
            'user_id'     => auth()->id(),
            'type'        => $this->activityType,
            'content'     => $this->activityContent,
        ]);

        $this->customer->update(['last_contacted_at' => now()]);
        $this->activityContent = '';
        $this->customer->refresh();
    }

    public function updateStage(string $stage): void
    {
        $this->customer->update(['pipeline_stage' => $stage]);
        $this->customer->refresh();
    }

    public function saveFollowUp(): void
    {
        $this->validate([
            'followUpTitle' => 'required|string|max:255',
            'followUpDue'   => 'required|date|after_or_equal:today',
        ]);

        FollowUp::create([
            'customer_id' => $this->customer->id,
            'assigned_to' => auth()->id(),
            'title'       => $this->followUpTitle,
            'due_at'      => $this->followUpDue,
        ]);

        $this->showFollowUpForm = false;
        $this->followUpTitle    = '';
        $this->followUpDue      = today()->addDay()->toDateString();
        $this->customer->refresh();
    }

    public function completeFollowUp(string $id): void
    {
        FollowUp::findOrFail($id)->update(['completed' => true]);
        $this->customer->refresh();
    }

    public function render()
    {
        $activities    = $this->customer->activities()->with('user')->orderByDesc('created_at')->get();
        $followUps     = $this->customer->followUps()->orderBy('due_at')->get();
        $bookings      = $this->customer->bookings()->with('service')->orderByDesc('booked_at')->limit(5)->get();
        $projects      = $this->customer->projects()->orderByDesc('created_at')->limit(5)->get();
        $activityTypes = ActivityType::cases();
        $stages        = PipelineStage::cases();

        return view('livewire.crm.customer-detail', compact(
            'activities', 'followUps', 'bookings', 'projects', 'activityTypes', 'stages'
        ));
    }
}
