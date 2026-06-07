<div class="bg-white rounded-2xl border border-stone-200 shadow-sm p-8">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-stone-900">Willkommen zurück</h1>
        <p class="text-sm text-stone-500 mt-1">Melden Sie sich an, um Ihre Buchungen zu verwalten.</p>
    </div>

    @if (session('error'))
    <div class="mb-5 flex items-center gap-2 text-sm text-red-600 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 110 18A9 9 0 0112 3z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <form wire:submit="login" class="space-y-5">

        <div>
            <label class="block text-xs font-semibold text-stone-600 mb-1.5 uppercase tracking-wide">E-Mail</label>
            <input
                type="email"
                wire:model="email"
                autocomplete="email"
                autofocus
                class="w-full border border-stone-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-transparent transition placeholder-stone-300"
                placeholder="sie@beispiel.ch"
            >
            @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label class="text-xs font-semibold text-stone-600 uppercase tracking-wide">Passwort</label>
            </div>
            <input
                type="password"
                wire:model="password"
                autocomplete="current-password"
                class="w-full border border-stone-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-gold focus:border-transparent transition placeholder-stone-300"
                placeholder="••••••••"
            >
            @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-2.5 cursor-pointer select-none">
            <input type="checkbox" wire:model="remember"
                   class="w-4 h-4 rounded border-stone-300 text-brand-gold focus:ring-brand-gold">
            <span class="text-sm text-stone-600">Angemeldet bleiben</span>
        </label>

        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-60 cursor-wait"
            class="w-full bg-brand-gold text-white py-3 rounded-full text-sm font-semibold hover:bg-brand-gold-dark transition-all"
        >
            <span wire:loading.remove wire:target="login">Anmelden</span>
            <span wire:loading wire:target="login" class="flex items-center justify-center gap-2">
                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
                Wird angemeldet…
            </span>
        </button>

    </form>

</div>
