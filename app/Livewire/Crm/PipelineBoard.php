<?php

namespace App\Livewire\Crm;

use App\Enums\PipelineStage;
use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Sales Pipeline'])]
class PipelineBoard extends Component
{
    public function moveStage(string $customerId, string $stage): void
    {
        Customer::findOrFail($customerId)->update(['pipeline_stage' => $stage]);
    }

    public function render()
    {
        $stages    = PipelineStage::cases();
        $customers = Customer::orderBy('name')->get()->groupBy('pipeline_stage');

        return view('livewire.crm.pipeline-board', compact('stages', 'customers'));
    }
}
