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
<body class="h-full bg-slate-50 font-['Inter',sans-serif] antialiased flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="mb-8 text-center">
            <span class="text-3xl font-bold text-slate-900 tracking-tight">MeisterFlow</span>
            <p class="mt-1 text-sm text-slate-500">Für Schweizer Handwerksbetriebe</p>
        </div>

        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>
