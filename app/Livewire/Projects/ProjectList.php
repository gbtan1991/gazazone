<?php

namespace App\Livewire\Projects;

use App\Enums\Priority;
use App\Enums\ProjectStatus;
use App\Models\Customer;
use App\Models\Project;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Projekte'])]
class ProjectList extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    public bool $showForm = false;

    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('nullable|uuid|exists:customers,id')]
    public string $customerId = '';

    #[Rule('nullable|uuid|exists:users,id')]
    public string $assignedTo = '';

    #[Rule('required|string')]
    public string $priority = 'medium';

    #[Rule('nullable|date')]
    public string $startDate = '';

    #[Rule('nullable|date|after_or_equal:startDate')]
    public string $dueDate = '';

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedStatus(): void { $this->resetPage(); }

    public function save(): void
    {
        $this->validate();

        Project::create([
            'name'        => $this->name,
            'customer_id' => $this->customerId ?: null,
            'assigned_to' => $this->assignedTo ?: null,
            'priority'    => $this->priority,
            'start_date'  => $this->startDate ?: null,
            'due_date'    => $this->dueDate ?: null,
        ]);

        session()->flash('success', 'Projekt erstellt.');
        $this->showForm = false;
        $this->reset(['name', 'customerId', 'assignedTo', 'priority', 'startDate', 'dueDate']);
    }

    public function render()
    {
        $projects = Project::with(['customer', 'assignedTo'])
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->orderByDesc('created_at')
            ->paginate(20);

        $statuses   = ProjectStatus::cases();
        $priorities = Priority::cases();
        $customers  = Customer::orderBy('name')->get();
        $users      = User::orderBy('name')->get();

        return view('livewire.projects.project-list', compact('projects', 'statuses', 'priorities', 'customers', 'users'));
    }
}
