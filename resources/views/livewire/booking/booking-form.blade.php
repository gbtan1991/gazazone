<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Neue Buchung erstellen</h1>
    </div>

    <div class="max-w-2xl">
        <form wire:submit="save" class="rounded-xl bg-white ring-1 ring-slate-200 p-6 space-y-5">

            <div class="border-b border-slate-100 pb-5">
                <h2 class="text-sm font-semibold text-slate-700 mb-4">Kundendaten</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Name <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="customerName" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('customerName') border-red-500 @enderror">
                        @error('customerName') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">E-Mail</label>
                        <input type="email" wire:model="customerEmail" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('customerEmail') border-red-500 @enderror">
                        @error('customerEmail') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Telefon</label>
                        <input type="tel" wire:model="customerPhone" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <div class="border-b border-slate-100 pb-5">
                <h2 class="text-sm font-semibold text-slate-700 mb-4">Termindetails</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Leistung <span class="text-red-500">*</span></label>
                        <select wire:model="serviceId" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('serviceId') border-red-500 @enderror">
                            <option value="">Leistung wählen...</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }} ({{ $service->duration_minutes }} Min.)</option>
                            @endforeach
                        </select>
                        @error('serviceId') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Mitarbeiter</label>
                        <select wire:model="assignedTo" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="">Nicht zugewiesen</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Datum <span class="text-red-500">*</span></label>
                        <input type="date" wire:model="bookedDate" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('bookedDate') border-red-500 @enderror">
                        @error('bookedDate') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Uhrzeit <span class="text-red-500">*</span></label>
                        <input type="time" wire:model="bookedTime" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('bookedTime') border-red-500 @enderror">
                        @error('bookedTime') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Notizen</label>
                <textarea wire:model="notes" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Optionale Hinweise zur Buchung..."></textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition-colors"
                    wire:loading.attr="disabled" wire:loading.class="opacity-75">
                    <span wire:loading.remove>Buchung speichern</span>
                    <span wire:loading>Speichern...</span>
                </button>
                <a href="{{ route('tenant.booking.calendar', request()->route('tenant')) }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">Abbrechen</a>
            </div>
        </form>
    </div>
</div>
