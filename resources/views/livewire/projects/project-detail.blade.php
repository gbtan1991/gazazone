<div>
    <div class="mb-6">
        <a href="{{ route('tenant.projects.index', request()->route('tenant')) }}" class="text-sm text-slate-500 hover:text-slate-700">← Zurück zu Projekten</a>
        <h1 class="mt-2 text-2xl font-bold text-slate-900">{{ $project->name }}</h1>
        <p class="mt-1 text-sm text-slate-500">{{ $project->customer?->name }}</p>
    </div>

    <div class="flex gap-3 mb-6">
        <a href="{{ route('tenant.projects.tasks', [request()->route('tenant'), $project]) }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
            Aufgaben anzeigen
        </a>
        <div class="flex items-center gap-2">
            <select wire:model="editStatus" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                @foreach($statuses as $s)
                    <option value="{{ $s->value }}">{{ $s->label() }}</option>
                @endforeach
            </select>
            <button wire:click="updateStatus" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Speichern</button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-xl bg-white ring-1 ring-slate-200 p-5 lg:col-span-2">
            @if($project->description)
                <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $project->description }}</p>
            @else
                <p class="text-sm text-slate-400">Keine Beschreibung.</p>
            @endif
        </div>
        <div class="rounded-xl bg-white ring-1 ring-slate-200 p-5 space-y-3">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Status</p>
                <span @class(['inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium', $project->status->color()])>{{ $project->status->label() }}</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Priorität</p>
                <span @class(['inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium', $project->priority->color()])>{{ $project->priority->label() }}</span>
            </div>
            @if($project->start_date)
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Startdatum</p>
                    <p class="text-sm text-slate-700">{{ $project->start_date->translatedFormat('j. M Y') }}</p>
                </div>
            @endif
            @if($project->due_date)
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Fälligkeitsdatum</p>
                    <p class="text-sm text-slate-700">{{ $project->due_date->translatedFormat('j. M Y') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
