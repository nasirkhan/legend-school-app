<div class="w-full max-w-sm">
    <h1 class="mb-8 text-center text-2xl font-semibold text-gray-900 dark:text-white">
        {{ config('app.name') }}
    </h1>

    @if ($errorMessage)
        <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700 dark:bg-red-900 dark:text-red-200">
            {{ $errorMessage }}
        </div>
    @endif

    <form wire:submit="login" class="space-y-4">
        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Email
            </label>
            <input
                id="email"
                type="email"
                wire:model="email"
                autocomplete="email"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                placeholder="you@example.com"
            />
            @error('email')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Password
            </label>
            <input
                id="password"
                type="password"
                wire:model="password"
                autocomplete="current-password"
                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                placeholder="••••••••"
            />
            @error('password')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            wire:loading.attr="disabled"
            class="w-full rounded-lg bg-blue-600 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:opacity-60"
        >
            <span wire:loading.remove>Sign in</span>
            <span wire:loading>Signing in…</span>
        </button>
    </form>
</div>
