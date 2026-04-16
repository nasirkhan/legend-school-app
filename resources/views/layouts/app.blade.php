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
    <body class="min-h-screen bg-gray-100 dark:bg-gray-900" x-data="{ sidebarOpen: false }">

        @if(function_exists('nativephp_call'))
            {{-- ── NATIVE: EDGE components handle safe areas automatically ── --}}
            <native:side-nav gestures-enabled="true">
                <native:side-nav-header title="{{ config('app.name', 'Legend School') }}" />

                <native:side-nav-item
                    id="home"
                    label="Home"
                    icon="home"
                    :url="route('home')"
                    :active="request()->routeIs('home')"
                />

                <native:side-nav-item
                    id="profile"
                    label="Profile"
                    icon="person"
                    :url="route('profile')"
                    :active="request()->routeIs('profile')"
                />

                <native:side-nav-item
                    id="tasks"
                    label="Tasks"
                    icon="task_alt"
                    :url="route('tasks.index')"
                    :active="request()->routeIs('tasks.*')"
                />
            </native:side-nav>

            <native:top-bar
                title="{{ $title ?? config('app.name', 'Legend School') }}"
                show-navigation-icon="true"
            >
                <native:top-bar-action
                    id="logout"
                    icon="logout"
                    label="Sign out"
                    :url="route('logout.get')"
                />
            </native:top-bar>

            <main>
                {{ $slot }}
            </main>

        @else
            {{-- ── BROWSER FALLBACK: standard HTML sidebar + top bar ── --}}

            {{-- Sidebar overlay (mobile) --}}
            <div
                x-show="sidebarOpen"
                x-transition.opacity
                @click="sidebarOpen = false"
                class="fixed inset-0 z-20 bg-black/50 lg:hidden"
                style="display: none;"
            ></div>

            {{-- Sidebar --}}
            <aside
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed left-0 top-0 z-30 flex h-full w-64 flex-col bg-white transition-transform duration-200 dark:bg-gray-900 lg:translate-x-0"
            >
                <div class="flex h-14 shrink-0 items-center border-b border-gray-200 px-5 dark:border-gray-700">
                    <span class="text-base font-bold text-gray-900 dark:text-white">
                        {{ config('app.name', 'Legend School') }}
                    </span>
                </div>

                <nav class="flex-1 space-y-1 p-4">
                    <a
                        href="{{ route('home') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7A1 1 0 003 11h1v6a1 1 0 001 1h4v-4h2v4h4a1 1 0 001-1v-6h1a1 1 0 00.707-1.707l-7-7z"/>
                        </svg>
                        Home
                    </a>

                    <a
                        href="{{ route('profile') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('profile') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        Profile
                    </a>

                    <a
                        href="{{ route('tasks.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('tasks.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 11l3 3L22 4"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                        </svg>
                        Tasks
                    </a>
                </nav>

                <div class="shrink-0 border-t border-gray-200 p-4 dark:border-gray-700">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                            </svg>
                            Sign out
                        </button>
                    </form>
                </div>
            </aside>

            {{-- Main area --}}
            <div class="lg:ml-64">
                <header class="sticky top-0 z-10 flex border-b border-gray-200 bg-white px-4 dark:border-gray-700 dark:bg-gray-900">
                    <div class="flex h-14 w-full items-center">
                        <button
                            @click="sidebarOpen = !sidebarOpen"
                            class="mr-3 rounded-lg p-2 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 lg:hidden"
                            aria-label="Toggle menu"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <button
                            onclick="history.back()"
                            class="mr-2 rounded-lg p-2 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800"
                            aria-label="Go back"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>

                        <h1 class="flex-1 text-base font-semibold text-gray-900 dark:text-white">
                            {{ $title ?? config('app.name', 'Legend School') }}
                        </h1>
                    </div>
                </header>

                <main>
                    {{ $slot }}
                </main>
            </div>
        @endif

        @livewireScripts
    </body>
</html>
