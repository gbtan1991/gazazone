<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Sales Pipeline</h1>
        <p class="mt-1 text-sm text-slate-500">Kundenübersicht nach Verkaufsphase</p>
    </div>

    <div class="flex gap-4 overflow-x-auto pb-4">
        @foreach($stages as $stage)
            @php $stageCustomers = $customers->get($stage->value, collect()) @endphp
            <div class="shrink-0 w-64 rounded-xl bg-slate-100 p-3">
                <div class="flex items-center justify-between mb-3 px-1">
                    <h3 class="text-xs font-semibold text-slate-600 uppercase tracking-wider">{{ $stage->label() }}</h3>
                    <span class="text-xs font-bold text-slate-500">{{ $stageCustomers->count() }}</span>
                </div>
                <div class="space-y-2">
                    @foreach($stageCustomers as $customer)
                        <a href="{{ route('tenant.crm.customer', [request()->route('tenant'), $customer]) }}"
                           class="block rounded-lg bg-white ring-1 ring-slate-200 p-3 hover:ring-blue-300 transition-all">
                            <p class="text-sm font-semibold text-slate-900">{{ $customer->name }}</p>
                            @if($customer->email)
                                <p class="text-xs text-slate-500 truncate mt-0.5">{{ $customer->email }}</p>
                            @endif
                            @if($customer->last_contacted_at)
                                <p class="text-xs text-slate-400 mt-1">{{ $customer->last_contacted_at->diffForHumans() }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
