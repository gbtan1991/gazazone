<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
        <p class="mt-1 text-sm text-slate-500">{{ now()->translatedFormat('l, j. F Y') }}</p>
    </div>

    {{-- Stats grid --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 mb-8">
        <div class="rounded-xl bg-white ring-1 ring-slate-200 p-5">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Heute Buchungen</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $todayBookings }}</p>
        </div>
        <div class="rounded-xl bg-white ring-1 ring-slate-200 p-5">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Offene Wiedervorlagen</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $openFollowUps }}</p>
        </div>
        <div class="rounded-xl bg-white ring-1 ring-slate-200 p-5">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Aktive Projekte</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $activeProjects }}</p>
        </div>
        <div class="rounded-xl bg-white ring-1 ring-slate-200 p-5">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Neue Leads (7 Tage)</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $newLeads }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Upcoming bookings --}}
        <div class="rounded-xl bg-white ring-1 ring-slate-200">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-900">Heutige Termine</h2>
                <a href="{{ route('tenant.booking.calendar', request()->route('tenant')) }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">Alle anzeigen →</a>
            </div>
            @if($upcomingBookings->isEmpty())
                <p class="px-5 py-8 text-center text-sm text-slate-400">Keine Termine heute.</p>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach($upcomingBookings as $booking)
                        <li class="flex items-center gap-4 px-5 py-3">
                            <span class="text-xs font-medium text-slate-500 w-12 shrink-0">{{ $booking->booked_at->format('H:i') }}</span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ $booking->customer?->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ $booking->service?->name }}</p>
                            </div>
                            <span @class([
                                'inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium',
                                $booking->status->color(),
                            ])>{{ $booking->status->label() }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Overdue follow-ups --}}
        <div class="rounded-xl bg-white ring-1 ring-slate-200">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-900">Überfällige Wiedervorlagen</h2>
                @if(auth()->user()?->client?->plan?->has_crm)
                    <a href="{{ route('tenant.crm.follow-ups', request()->route('tenant')) }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">Alle anzeigen →</a>
                @endif
            </div>
            @if($overdueFollowUps->isEmpty())
                <p class="px-5 py-8 text-center text-sm text-slate-400">Keine überfälligen Wiedervorlagen.</p>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach($overdueFollowUps as $followUp)
                        <li class="flex items-center gap-4 px-5 py-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ $followUp->title }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ $followUp->customer?->name }}</p>
                            </div>
                            <span class="text-xs text-red-600 font-medium shrink-0">{{ $followUp->due_at->diffForHumans() }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
