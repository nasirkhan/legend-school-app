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

        {{-- Native Bottom Navigation (mobile app only) --}}
        @mobile
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
        @endmobile

        @web
        <nav class="fixed bottom-0 w-full bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex justify-around p-3">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 text-xs {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7A1 1 0 003 11h1v6a1 1 0 001 1h4v-4h2v4h4a1 1 0 001-1v-6h1a1 1 0 00.707-1.707l-7-7z"/></svg>
                Home
            </a>
            <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1 text-xs {{ request()->routeIs('profile') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                Profile
            </a>
        </nav>
        @endweb

        @livewireScripts
    </body>
</html>
