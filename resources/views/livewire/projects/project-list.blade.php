<div>
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">Projekte</h1>
        <button wire:click="$toggle('showForm')" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Neues Projekt
        </button>
    </div>

    @if($showForm)
        <div class="mb-6 rounded-xl bg-white ring-1 ring-blue-200 p-5">
            <h2 class="text-sm font-semibold text-slate-900 mb-4">Neues Projekt anlegen</h2>
            <form wire:submit="save" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Projektname <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="name" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kunde</label>
                    <select wire:model="customerId" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">Kein Kunde</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Zugewiesen an</label>
                    <select wire:model="assignedTo" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">Nicht zugewiesen</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Priorität</label>
                    <select wire:model="priority" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @foreach($priorities as $p)
                            <option value="{{ $p->value }}">{{ $p->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Startdatum</label>
                    <input type="date" wire:model="startDate" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Fälligkeitsdatum</label>
                    <input type="date" wire:model="dueDate" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="sm:col-span-2 flex items-center gap-3">
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">Erstellen</button>
                    <button type="button" wire:click="$set('showForm', false)" class="text-sm font-medium text-slate-600 hover:text-slate-900">Abbrechen</button>
                </div>
            </form>
        </div>
    @endif

    <div class="mb-4 flex flex-col gap-3 sm:flex-row">
        <div class="flex-1">
            <input type="search" wire:model.live.debounce.300ms="search" placeholder="Projekt suchen..." class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>
        <select wire:model.live="status" class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            <option value="">Alle Status</option>
            @foreach($statuses as $s)
                <option value="{{ $s->value }}">{{ $s->label() }}</option>
            @endforeach
        </select>
    </div>

    <div class="rounded-xl bg-white ring-1 ring-slate-200 overflow-hidden">
        @if($projects->isEmpty())
            <p class="py-12 text-center text-sm text-slate-400">Keine Projekte gefunden.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Projekt</th>
                            <th class="hidden sm:table-cell px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kunde</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="hidden lg:table-cell px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Priorität</th>
                            <th class="hidden lg:table-cell px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Fällig</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($projects as $project)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-3 font-medium text-slate-900">{{ $project->name }}</td>
                                <td class="hidden sm:table-cell px-5 py-3 text-slate-600">{{ $project->customer?->name ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    <span @class(['inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium', $project->status->color()])>{{ $project->status->label() }}</span>
                                </td>
                                <td class="hidden lg:table-cell px-5 py-3">
                                    <span @class(['inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium', $project->priority->color()])>{{ $project->priority->label() }}</span>
                                </td>
                                <td class="hidden lg:table-cell px-5 py-3 text-slate-500 text-xs">
                                    {{ $project->due_date?->translatedFormat('j. M Y') ?? '—' }}
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('tenant.projects.tasks', [request()->route('tenant'), $project]) }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">Aufgaben →</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 px-5 py-3">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</div>
