<!DOCTYPE html>
<html lang="de" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'MeisterFlow') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-slate-50 font-['Inter',sans-serif] antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-full">
        {{-- Sidebar overlay (mobile) --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            @click="sidebarOpen = false"
            class="fixed inset-0 z-20 bg-slate-900/50 lg:hidden"
        ></div>

        {{-- Sidebar --}}
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 w-64 bg-slate-900 text-white flex flex-col transition-transform duration-300 lg:relative lg:translate-x-0 lg:flex"
        >
            <div class="flex h-16 items-center px-6 border-b border-slate-700">
                <span class="text-xl font-bold tracking-tight">MeisterFlow</span>
            </div>

            @php
                $clientId = auth()->user()?->client_id;
                $plan = auth()->user()?->client?->plan;
            @endphp

            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <x-nav-link :href="route('tenant.dashboard', $clientId)" :active="request()->routeIs('tenant.dashboard')" icon="home">
                    Dashboard
                </x-nav-link>

                <div class="pt-4 pb-1 px-3">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Buchung</p>
                </div>
                <x-nav-link :href="route('tenant.booking.calendar', $clientId)" :active="request()->routeIs('tenant.booking.*')" icon="calendar">
                    Kalender
                </x-nav-link>

                @if($plan?->has_crm)
                    <div class="pt-4 pb-1 px-3">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">CRM</p>
                    </div>
                    <x-nav-link :href="route('tenant.crm.customers', $clientId)" :active="request()->routeIs('tenant.crm.customers*')" icon="users">
                        Kunden
                    </x-nav-link>
                    <x-nav-link :href="route('tenant.crm.pipeline', $clientId)" :active="request()->routeIs('tenant.crm.pipeline')" icon="chart-bar">
                        Pipeline
                    </x-nav-link>
                    <x-nav-link :href="route('tenant.crm.follow-ups', $clientId)" :active="request()->routeIs('tenant.crm.follow-ups')" icon="bell">
                        Wiedervorlagen
                    </x-nav-link>
                @endif

                @if($plan?->has_pm)
                    <div class="pt-4 pb-1 px-3">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Projekte</p>
                    </div>
                    <x-nav-link :href="route('tenant.projects.index', $clientId)" :active="request()->routeIs('tenant.projects.*')" icon="folder">
                        Projekte
                    </x-nav-link>
                @endif

                <div class="pt-4 pb-1 px-3">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Konto</p>
                </div>
                <x-nav-link :href="route('tenant.settings.profile', $clientId)" :active="request()->routeIs('tenant.settings.*')" icon="cog">
                    Einstellungen
                </x-nav-link>
            </nav>

            <div class="border-t border-slate-700 px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-sm font-semibold">
                        {{ substr(auth()->user()?->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()?->name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ auth()->user()?->role?->label() }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-white transition-colors" title="Abmelden">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-h-0 overflow-hidden">
            {{-- Top bar (mobile) --}}
            <header class="flex h-16 items-center gap-4 border-b border-slate-200 bg-white px-4 lg:hidden">
                <button @click="sidebarOpen = true" class="text-slate-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <span class="font-semibold text-slate-900">{{ $title ?? 'MeisterFlow' }}</span>
            </header>

            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                @if (session('success'))
                    <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-4 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 rounded-md bg-red-50 border border-red-200 p-4 text-sm text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
