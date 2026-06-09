<?php

namespace App\Livewire\Crm;

use App\Enums\PipelineStage;
use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Kunden'])]
class CustomerList extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $stage = '';

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedStage(): void  { $this->resetPage(); }

    public function render()
    {
        $customers = Customer::query()
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%");
            }))
            ->when($this->stage, fn ($q) => $q->where('pipeline_stage', $this->stage))
            ->orderByDesc('created_at')
            ->paginate(25);

        $stages = PipelineStage::cases();

        return view('livewire.crm.customer-list', compact('customers', 'stages'));
    }
}
