<?php

namespace App\Livewire\Projects;

use App\Enums\Priority;
use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Projektdetails'])]
class ProjectDetail extends Component
{
    public Project $project;

    #[Rule('required|string')]
    public string $editStatus = '';

    public function mount(Project $project): void
    {
        $this->project   = $project;
        $this->editStatus = $project->status->value;
    }

    public function updateStatus(): void
    {
        $this->project->update(['status' => $this->editStatus]);
        $this->project->refresh();
    }

    public function render()
    {
        $tasks    = $this->project->tasks()->with('assignedTo')->orderBy('priority', 'desc')->get();
        $statuses = ProjectStatus::cases();
        $users    = User::orderBy('name')->get();

        return view('livewire.projects.project-detail', compact('tasks', 'statuses', 'users'));
    }
}
