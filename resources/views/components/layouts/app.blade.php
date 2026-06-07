<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Swiss Book') }} — {{ $title ?? 'Premium Booking' }}</title>
    <meta name="description" content="Book your appointment with precision and ease.">

    {{-- Preconnect for performance --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased bg-stone-50 text-stone-900 font-['Inter',sans-serif] min-h-screen">

    {{-- Navigation --}}
    <header class="fixed top-0 inset-x-0 z-50 bg-white/90 backdrop-blur-md border-b border-stone-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto">
            </a>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-sm font-medium text-stone-500 hover:text-stone-900 transition-colors">
                        Admin panel
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="text-sm font-semibold border border-stone-200 text-stone-600 hover:bg-stone-50 px-4 py-2 rounded-full transition-colors">
                            Sign out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-semibold border border-stone-200 text-stone-600 hover:bg-stone-50 px-4 py-2 rounded-full transition-colors">
                        Admin sign in
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="pt-28">
        {{ $slot }}
    </main>

    <footer class="mt-24 border-t border-stone-200 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div>
                    <p class="font-semibold text-stone-900">Gazazone</p>
                    <p class="text-sm text-stone-500 mt-1">Precision scheduling for discerning businesses.</p>
                </div>
                <p class="text-xs text-stone-400">© {{ date('Y') }} Gazazone. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
