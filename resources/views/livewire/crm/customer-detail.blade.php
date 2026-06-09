<div>
    <div class="mb-6">
        <a href="{{ route('tenant.crm.customers', request()->route('tenant')) }}" class="text-sm text-slate-500 hover:text-slate-700">← Zurück zur Liste</a>
        <h1 class="mt-2 text-2xl font-bold text-slate-900">{{ $customer->name }}</h1>
        <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-slate-500">
            @if($customer->email) <span>{{ $customer->email }}</span> @endif
            @if($customer->phone) <span>{{ $customer->phone }}</span> @endif
            @if($customer->city) <span>{{ $customer->city }}</span> @endif
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Left: Info & Stage --}}
        <div class="space-y-5">
            <div class="rounded-xl bg-white ring-1 ring-slate-200 p-5">
                <h2 class="text-sm font-semibold text-slate-700 mb-3">Pipeline-Phase</h2>
                <div class="space-y-1">
                    @foreach($stages as $stage)
                        <button
                            wire:click="updateStage('{{ $stage->value }}')"
                            @class([
                                'w-full text-left rounded-md px-3 py-2 text-sm font-medium transition-colors',
                                'ring-1 ring-blue-500 ' . $stage->color() => $customer->pipeline_stage === $stage,
                                'text-slate-600 hover:bg-slate-50' => $customer->pipeline_stage !== $stage,
                            ])
                        >{{ $stage->label() }}</button>
                    @endforeach
                </div>
            </div>

            <div class="rounded-xl bg-white ring-1 ring-slate-200 p-5">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-slate-700">Wiedervorlagen</h2>
                    <button wire:click="$toggle('showFollowUpForm')" class="text-xs font-medium text-blue-600 hover:text-blue-700">+ Neu</button>
                </div>

                @if($showFollowUpForm)
                    <form wire:submit="saveFollowUp" class="mb-3 space-y-3 bg-slate-50 rounded-lg p-3">
                        <div>
                            <input type="text" wire:model="followUpTitle" placeholder="Titel" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            @error('followUpTitle') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <input type="date" wire:model="followUpDue" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="w-full rounded-md bg-blue-600 py-2 text-xs font-semibold text-white hover:bg-blue-700">Speichern</button>
                    </form>
                @endif

                @forelse($followUps as $followUp)
                    <div @class(['flex items-start gap-2 py-2', 'opacity-50' => $followUp->completed])>
                        @unless($followUp->completed)
                            <button wire:click="completeFollowUp('{{ $followUp->id }}')" class="mt-0.5 h-4 w-4 shrink-0 rounded border-2 border-slate-400 hover:border-green-500"></button>
                        @else
                            <span class="mt-0.5 h-4 w-4 shrink-0 rounded bg-green-500 flex items-center justify-center">
                                <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </span>
                        @endunless
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900">{{ $followUp->title }}</p>
                            <p @class(['text-xs', $followUp->due_at->isPast() && !$followUp->completed ? 'text-red-600' : 'text-slate-400'])>{{ $followUp->due_at->translatedFormat('j. M Y') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400">Keine Wiedervorlagen.</p>
                @endforelse
            </div>
        </div>

        {{-- Right: Activity & History --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="rounded-xl bg-white ring-1 ring-slate-200 p-5">
                <h2 class="text-sm font-semibold text-slate-700 mb-3">Aktivität erfassen</h2>
                <div class="flex gap-2 mb-3 flex-wrap">
                    @foreach($activityTypes as $type)
                        <button
                            wire:click="$set('activityType', '{{ $type->value }}')"
                            @class([
                                'rounded-full px-3 py-1 text-xs font-medium transition-colors',
                                'bg-blue-600 text-white' => $activityType === $type->value,
                                'bg-slate-100 text-slate-600 hover:bg-slate-200' => $activityType !== $type->value,
                            ])
                        >{{ $type->label() }}</button>
                    @endforeach
                </div>
                <textarea wire:model="activityContent" rows="3" placeholder="Notiz eingeben..." class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"></textarea>
                <button wire:click="logActivity" class="mt-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">Speichern</button>
            </div>

            <div class="rounded-xl bg-white ring-1 ring-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-700">Aktivitätsverlauf</h2>
                </div>
                @if($activities->isEmpty())
                    <p class="px-5 py-8 text-center text-sm text-slate-400">Noch keine Aktivitäten.</p>
                @else
                    <ul class="divide-y divide-slate-100">
                        @foreach($activities as $activity)
                            <li class="px-5 py-3">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-medium text-blue-600">{{ $activity->type->label() }}</span>
                                    <span class="text-xs text-slate-400">{{ $activity->user?->name }}</span>
                                    <span class="ml-auto text-xs text-slate-400">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                                @if($activity->content)
                                    <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $activity->content }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
