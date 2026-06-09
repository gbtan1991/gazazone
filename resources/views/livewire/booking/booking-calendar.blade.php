<div>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Buchungskalender</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $date->translatedFormat('l, j. F Y') }}</p>
        </div>
        <a href="{{ route('tenant.booking.new', request()->route('tenant')) }}"
           class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Neue Buchung
        </a>
    </div>

    {{-- Date navigation --}}
    <div class="mb-6 flex items-center gap-3">
        <button wire:click="previousDay" class="rounded-md border border-slate-300 bg-white p-2 text-slate-600 hover:bg-slate-50 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button wire:click="today" class="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors">Heute</button>
        <button wire:click="nextDay" class="rounded-md border border-slate-300 bg-white p-2 text-slate-600 hover:bg-slate-50 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>

    {{-- Bookings list --}}
    <div class="rounded-xl bg-white ring-1 ring-slate-200 overflow-hidden">
        @if($bookings->isEmpty())
            <div class="py-16 text-center">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="mt-3 text-sm text-slate-500">Keine Termine für diesen Tag.</p>
                <a href="{{ route('tenant.booking.new', request()->route('tenant')) }}" class="mt-4 inline-block text-sm font-medium text-blue-600 hover:text-blue-700">Buchung erstellen →</a>
            </div>
        @else
            <ul class="divide-y divide-slate-100">
                @foreach($bookings as $booking)
                    <li class="flex flex-col gap-2 px-5 py-4 sm:flex-row sm:items-center sm:gap-6">
                        <div class="text-sm font-semibold text-slate-700 shrink-0 w-14">
                            {{ $booking->booked_at->format('H:i') }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-900">{{ $booking->customer?->name }}</p>
                            <p class="text-sm text-slate-500">{{ $booking->service?->name }} · {{ $booking->duration_minutes }} Min.</p>
                            @if($booking->notes)
                                <p class="mt-1 text-xs text-slate-400 truncate">{{ $booking->notes }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            @if($booking->assignedTo)
                                <span class="text-xs text-slate-500">{{ $booking->assignedTo->name }}</span>
                            @endif
                            <span @class([
                                'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                $booking->status->color(),
                            ])>{{ $booking->status->label() }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
