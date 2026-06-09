<div>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold text-slate-900">Kunden</h1>
        <p class="text-sm text-slate-500">{{ $customers->total() }} Kunden</p>
    </div>

    <div class="mb-4 flex flex-col gap-3 sm:flex-row">
        <div class="flex-1">
            <input type="search" wire:model.live.debounce.300ms="search" placeholder="Name, E-Mail oder Telefon suchen..." class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>
        <select wire:model.live="stage" class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            <option value="">Alle Phasen</option>
            @foreach($stages as $s)
                <option value="{{ $s->value }}">{{ $s->label() }}</option>
            @endforeach
        </select>
    </div>

    <div class="rounded-xl bg-white ring-1 ring-slate-200 overflow-hidden">
        @if($customers->isEmpty())
            <p class="py-12 text-center text-sm text-slate-400">Keine Kunden gefunden.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
                            <th class="hidden sm:table-cell px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kontakt</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Phase</th>
                            <th class="hidden lg:table-cell px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Letzter Kontakt</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($customers as $customer)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="font-medium text-slate-900">{{ $customer->name }}</div>
                                    <div class="sm:hidden text-xs text-slate-500 mt-0.5">{{ $customer->email }}</div>
                                </td>
                                <td class="hidden sm:table-cell px-5 py-3 text-slate-600">
                                    <div>{{ $customer->email }}</div>
                                    <div class="text-xs text-slate-400">{{ $customer->phone }}</div>
                                </td>
                                <td class="px-5 py-3">
                                    <span @class([
                                        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                        $customer->pipeline_stage->color(),
                                    ])>{{ $customer->pipeline_stage->label() }}</span>
                                </td>
                                <td class="hidden lg:table-cell px-5 py-3 text-slate-500 text-xs">
                                    {{ $customer->last_contacted_at?->diffForHumans() ?? '—' }}
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('tenant.crm.customer', [request()->route('tenant'), $customer]) }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">Anzeigen →</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 px-5 py-3">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>
