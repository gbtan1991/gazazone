<?php

namespace App\Livewire\Projects;

use App\Enums\Priority;
use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Aufgaben'])]
class TaskBoard extends Component
{
    public Project $project;

    public bool $showTaskForm = false;
    public ?string $selectedTaskId = null;
    public string $newComment = '';

    #[Rule('required|string|max:255')]
    public string $taskTitle = '';

    #[Rule('nullable|string|max:2000')]
    public string $taskDescription = '';

    #[Rule('required|string')]
    public string $taskPriority = 'medium';

    #[Rule('nullable|uuid|exists:users,id')]
    public string $taskAssignedTo = '';

    #[Rule('nullable|date')]
    public string $taskDueDate = '';

    public function mount(Project $project): void
    {
        $this->project = $project;
    }

    public function saveTask(): void
    {
        $this->validate([
            'taskTitle'       => 'required|string|max:255',
            'taskDescription' => 'nullable|string|max:2000',
            'taskPriority'    => 'required|string',
            'taskAssignedTo'  => 'nullable|uuid|exists:users,id',
            'taskDueDate'     => 'nullable|date',
        ]);

        Task::create([
            'project_id'  => $this->project->id,
            'title'       => $this->taskTitle,
            'description' => $this->taskDescription ?: null,
            'priority'    => $this->taskPriority,
            'assigned_to' => $this->taskAssignedTo ?: null,
            'due_date'    => $this->taskDueDate ?: null,
        ]);

        $this->showTaskForm = false;
        $this->reset(['taskTitle', 'taskDescription', 'taskPriority', 'taskAssignedTo', 'taskDueDate']);
    }

    public function moveTask(string $taskId, string $status): void
    {
        Task::findOrFail($taskId)->update(['status' => $status]);
    }

    public function selectTask(string $taskId): void
    {
        $this->selectedTaskId = $this->selectedTaskId === $taskId ? null : $taskId;
        $this->newComment     = '';
    }

    public function addComment(): void
    {
        if (empty($this->newComment) || ! $this->selectedTaskId) {
            return;
        }

        TaskComment::create([
            'task_id' => $this->selectedTaskId,
            'user_id' => auth()->id(),
            'content' => $this->newComment,
        ]);

        $this->newComment = '';
    }

    public function render()
    {
        $statuses   = TaskStatus::cases();
        $priorities = Priority::cases();
        $users      = User::orderBy('name')->get();
        $tasks      = $this->project->tasks()->with(['assignedTo', 'comments.user'])->get()->groupBy('status');

        $selectedTask = $this->selectedTaskId
            ? Task::with(['comments.user', 'assignedTo'])->find($this->selectedTaskId)
            : null;

        return view('livewire.projects.task-board', compact('statuses', 'priorities', 'users', 'tasks', 'selectedTask'));
    }
}
