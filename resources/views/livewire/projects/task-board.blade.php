<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('tenant.projects.index', request()->route('tenant')) }}" class="text-sm text-slate-500 hover:text-slate-700">← Projekte</a>
            <h1 class="mt-1 text-2xl font-bold text-slate-900">{{ $project->name }} — Aufgaben</h1>
        </div>
        <button wire:click="$toggle('showTaskForm')" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Neue Aufgabe
        </button>
    </div>

    @if($showTaskForm)
        <div class="mb-6 rounded-xl bg-white ring-1 ring-blue-200 p-5">
            <form wire:submit="saveTask" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Titel <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="taskTitle" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('taskTitle') border-red-500 @enderror">
                    @error('taskTitle') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Priorität</label>
                    <select wire:model="taskPriority" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @foreach($priorities as $p)
                            <option value="{{ $p->value }}">{{ $p->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Zugewiesen an</label>
                    <select wire:model="taskAssignedTo" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">Nicht zugewiesen</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Fälligkeitsdatum</label>
                    <input type="date" wire:model="taskDueDate" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Beschreibung</label>
                    <textarea wire:model="taskDescription" rows="2" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"></textarea>
                </div>
                <div class="sm:col-span-2 flex items-center gap-3">
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">Erstellen</button>
                    <button type="button" wire:click="$set('showTaskForm', false)" class="text-sm font-medium text-slate-600 hover:text-slate-900">Abbrechen</button>
                </div>
            </form>
        </div>
    @endif

    {{-- Kanban board --}}
    <div class="flex gap-4 overflow-x-auto pb-4">
        @foreach($statuses as $status)
            @php $statusTasks = $tasks->get($status->value, collect()) @endphp
            <div class="shrink-0 w-64 rounded-xl bg-slate-100 p-3">
                <div class="flex items-center justify-between mb-3 px-1">
                    <h3 class="text-xs font-semibold text-slate-600 uppercase tracking-wider">{{ $status->label() }}</h3>
                    <span class="text-xs font-bold text-slate-500">{{ $statusTasks->count() }}</span>
                </div>
                <div class="space-y-2">
                    @foreach($statusTasks as $task)
                        <div
                            wire:click="selectTask('{{ $task->id }}')"
                            @class([
                                'rounded-lg bg-white ring-1 p-3 cursor-pointer hover:ring-blue-300 transition-all',
                                'ring-blue-500' => $selectedTaskId === $task->id,
                                'ring-slate-200' => $selectedTaskId !== $task->id,
                            ])
                        >
                            <p class="text-sm font-medium text-slate-900">{{ $task->title }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <span @class(['inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium', $task->priority->color()])>{{ $task->priority->label() }}</span>
                                @if($task->assignedTo)
                                    <span class="text-xs text-slate-400">{{ $task->assignedTo->name }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- Task detail panel --}}
    @if($selectedTask)
        <div class="mt-6 rounded-xl bg-white ring-1 ring-slate-200 p-5">
            <div class="flex items-start justify-between mb-4">
                <h2 class="text-base font-semibold text-slate-900">{{ $selectedTask->title }}</h2>
                <button wire:click="$set('selectedTaskId', null)" class="text-slate-400 hover:text-slate-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex gap-2 mb-4 flex-wrap">
                @foreach($statuses as $s)
                    <button
                        wire:click="moveTask('{{ $selectedTask->id }}', '{{ $s->value }}')"
                        @class([
                            'rounded-full px-3 py-1 text-xs font-medium transition-colors',
                            'bg-blue-600 text-white' => $selectedTask->status === $s,
                            'bg-slate-100 text-slate-600 hover:bg-slate-200' => $selectedTask->status !== $s,
                        ])
                    >{{ $s->label() }}</button>
                @endforeach
            </div>

            @if($selectedTask->description)
                <p class="text-sm text-slate-700 mb-4 whitespace-pre-wrap">{{ $selectedTask->description }}</p>
            @endif

            <div class="border-t border-slate-100 pt-4">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Kommentare</h3>
                @foreach($selectedTask->comments as $comment)
                    <div class="mb-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-slate-700">{{ $comment->user?->name }}</span>
                            <span class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-slate-700 bg-slate-50 rounded-lg px-3 py-2">{{ $comment->content }}</p>
                    </div>
                @endforeach
                <div class="flex gap-2 mt-3">
                    <input type="text" wire:model="newComment" placeholder="Kommentar hinzufügen..." class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" wire:keydown.enter="addComment">
                    <button wire:click="addComment" class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">Senden</button>
                </div>
            </div>
        </div>
    @endif
</div>
