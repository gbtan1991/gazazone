<?php

namespace App\Livewire\Crm;

use App\Models\FollowUp;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Wiedervorlagen'])]
class FollowUpList extends Component
{
    public bool $showCompleted = false;

    public function complete(string $id): void
    {
        FollowUp::findOrFail($id)->update(['completed' => true]);
    }

    public function render()
    {
        $followUps = FollowUp::with(['customer', 'assignedTo'])
            ->where('completed', $this->showCompleted)
            ->orderBy('due_at')
            ->get();

        return view('livewire.crm.follow-up-list', compact('followUps'));
    }
}
