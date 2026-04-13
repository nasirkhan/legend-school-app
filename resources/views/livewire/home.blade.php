<div class="p-6">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Home</h1>

        <button
            wire:click="logout"
            wire:loading.attr="disabled"
            class="rounded-lg bg-gray-100 px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300"
        >
            Sign out
        </button>
    </div>

    @if (! empty($user))
        <div class="rounded-xl bg-white p-4 shadow-sm dark:bg-gray-800">
            <div class="flex items-center gap-4">
                <img
                    src="{{ $user['avatar'] ?? '/img/default-avatar.jpg' }}"
                    alt="Avatar"
                    class="h-14 w-14 rounded-full object-cover"
                />
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">
                        {{ $user['name'] ?? '—' }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $user['email'] ?? '' }}
                    </p>
                </div>
            </div>

            @if (! empty($user['roles']))
                <div class="mt-3 flex flex-wrap gap-1.5">
                    @foreach ($user['roles'] as $role)
                        <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            {{ $role }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <p class="text-sm text-gray-400 dark:text-gray-500">Loading profile…</p>
    @endif
</div>
