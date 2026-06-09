<div>
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">Wiedervorlagen</h1>
        <div class="flex items-center gap-2">
            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" wire:model.live="showCompleted" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                Erledigte anzeigen
            </label>
        </div>
    </div>

    <div class="rounded-xl bg-white ring-1 ring-slate-200 overflow-hidden">
        @if($followUps->isEmpty())
            <p class="py-12 text-center text-sm text-slate-400">{{ $showCompleted ? 'Keine erledigten Wiedervorlagen.' : 'Keine offenen Wiedervorlagen.' }}</p>
        @else
            <ul class="divide-y divide-slate-100">
                @foreach($followUps as $followUp)
                    <li class="flex items-center gap-4 px-5 py-4">
                        @unless($followUp->completed)
                            <button wire:click="complete('{{ $followUp->id }}')" class="h-5 w-5 shrink-0 rounded border-2 border-slate-400 hover:border-green-500 transition-colors"></button>
                        @else
                            <span class="h-5 w-5 shrink-0 rounded bg-green-500 flex items-center justify-center">
                                <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </span>
                        @endunless
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-900">{{ $followUp->title }}</p>
                            <p class="text-xs text-slate-500">{{ $followUp->customer?->name }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <p @class(['text-xs font-medium', $followUp->due_at->isPast() && !$followUp->completed ? 'text-red-600' : 'text-slate-500'])>
                                {{ $followUp->due_at->translatedFormat('j. M Y') }}
                            </p>
                            @if($followUp->assignedTo)
                                <p class="text-xs text-slate-400">{{ $followUp->assignedTo->name }}</p>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
