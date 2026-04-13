<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Legend School') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-white dark:bg-gray-950">
        <main class="nativephp-safe-area flex min-h-screen flex-col items-center justify-center px-6">
            {{ $slot }}
        </main>

        @livewireScripts
    </body>
</html>
