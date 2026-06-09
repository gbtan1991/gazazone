<div>
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">Team verwalten</h1>
        <button wire:click="$toggle('showForm')" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Mitarbeiter hinzufügen
        </button>
    </div>

    @if($showForm)
        <div class="mb-6 rounded-xl bg-white ring-1 ring-blue-200 p-5">
            <h2 class="text-sm font-semibold text-slate-900 mb-4">Neuer Mitarbeiter</h2>
            <form wire:submit="save" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="name" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">E-Mail <span class="text-red-500">*</span></label>
                    <input type="email" wire:model="email" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Passwort <span class="text-red-500">*</span></label>
                    <input type="password" wire:model="password" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Rolle</label>
                    <select wire:model="role" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="staff">Mitarbeiter</option>
                        <option value="owner">Inhaber</option>
                    </select>
                </div>
                <div class="sm:col-span-2 flex items-center gap-3">
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">Hinzufügen</button>
                    <button type="button" wire:click="$set('showForm', false)" class="text-sm font-medium text-slate-600 hover:text-slate-900">Abbrechen</button>
                </div>
            </form>
        </div>
    @endif

    <div class="rounded-xl bg-white ring-1 ring-slate-200 overflow-hidden">
        @if($users->isEmpty())
            <p class="py-12 text-center text-sm text-slate-400">Keine Mitarbeiter.</p>
        @else
            <ul class="divide-y divide-slate-100">
                @foreach($users as $user)
                    <li class="flex items-center gap-4 px-5 py-4">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $user->email }}</p>
                        </div>
                        <span class="text-xs font-medium text-slate-500">{{ $user->role->label() }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
