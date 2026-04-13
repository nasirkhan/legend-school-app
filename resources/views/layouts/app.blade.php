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
    <body class="min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- Main Content --}}
        <main class="nativephp-safe-area pb-16">
            {{ $slot }}
        </main>

        {{-- Native Bottom Navigation --}}
        <native:bottom-nav>
            <native:bottom-nav-item
                id="home"
                icon="house.fill"
                label="Home"
                url="{{ route('home') }}"
                :active="request()->routeIs('home')"
            />
            <native:bottom-nav-item
                id="profile"
                icon="person.fill"
                label="Profile"
                url="{{ route('profile') }}"
                :active="request()->routeIs('profile')"
            />
        </native:bottom-nav>

        @livewireScripts
    </body>
</html>
