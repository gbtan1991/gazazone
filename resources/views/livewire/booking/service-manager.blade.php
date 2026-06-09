<div>
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">Leistungen</h1>
        <button wire:click="openCreate" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Neue Leistung
        </button>
    </div>

    {{-- Form modal --}}
    @if($showForm)
        <div class="mb-6 rounded-xl bg-white ring-1 ring-blue-200 p-5" x-data>
            <h2 class="text-sm font-semibold text-slate-900 mb-4">{{ $editingId ? 'Leistung bearbeiten' : 'Neue Leistung' }}</h2>
            <form wire:submit="save" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="name" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Dauer (Minuten) <span class="text-red-500">*</span></label>
                    <input type="number" wire:model="durationMinutes" min="15" max="480" step="15" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('durationMinutes') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Preis (CHF) <span class="text-red-500">*</span></label>
                    <input type="number" wire:model="priceChf" min="0" step="0.05" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    @error('priceChf') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2 flex items-center gap-2">
                    <input type="checkbox" wire:model="isActive" id="isActive" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <label for="isActive" class="text-sm text-slate-700">Leistung aktiv</label>
                </div>
                <div class="sm:col-span-2 flex items-center gap-3">
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">Speichern</button>
                    <button type="button" wire:click="$set('showForm', false)" class="text-sm font-medium text-slate-600 hover:text-slate-900">Abbrechen</button>
                </div>
            </form>
        </div>
    @endif

    {{-- Services table --}}
    <div class="rounded-xl bg-white ring-1 ring-slate-200 overflow-hidden">
        @if($services->isEmpty())
            <p class="py-12 text-center text-sm text-slate-400">Noch keine Leistungen angelegt.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Dauer</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Preis</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($services as $service)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-3 font-medium text-slate-900">{{ $service->name }}</td>
                                <td class="px-5 py-3 text-slate-600">{{ $service->duration_minutes }} Min.</td>
                                <td class="px-5 py-3 text-slate-600">CHF {{ number_format($service->price_chf, 2) }}</td>
                                <td class="px-5 py-3">
                                    <button wire:click="toggleActive('{{ $service->id }}')" @class([
                                        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium transition-colors',
                                        'bg-green-100 text-green-700' => $service->is_active,
                                        'bg-slate-100 text-slate-500' => ! $service->is_active,
                                    ])>
                                        {{ $service->is_active ? 'Aktiv' : 'Inaktiv' }}
                                    </button>
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <button wire:click="openEdit('{{ $service->id }}')" class="text-xs font-medium text-blue-600 hover:text-blue-700">Bearbeiten</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
