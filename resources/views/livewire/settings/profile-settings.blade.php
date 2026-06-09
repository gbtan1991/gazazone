<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Profileinstellungen</h1>
    </div>
    <div class="max-w-lg">
        <form wire:submit="save" class="rounded-xl bg-white ring-1 ring-slate-200 p-6 space-y-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                <input type="text" wire:model="name" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">E-Mail</label>
                <input type="email" wire:model="email" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="border-t border-slate-100 pt-5">
                <p class="text-sm font-medium text-slate-700 mb-3">Passwort ändern (optional)</p>
                <div class="space-y-3">
                    <div>
                        <input type="password" wire:model="newPassword" placeholder="Neues Passwort" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <input type="password" wire:model="confirmPassword" placeholder="Passwort bestätigen" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @error('confirmPassword') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">Speichern</button>
        </form>
    </div>
</div>
