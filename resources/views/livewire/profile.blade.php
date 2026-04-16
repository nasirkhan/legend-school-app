<div class="p-6">
    @if (! empty($user))
        <div class="space-y-4">
            <div class="rounded-xl bg-white p-4 shadow-sm dark:bg-gray-800">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?: '—' }}
                        </p>
                        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                            {{ $user['email'] ?? '' }}
                        </p>
                    </div>
                </div>
            </div>

            @if (! empty($user['mobile']))
                <div class="rounded-xl bg-white p-4 shadow-sm dark:bg-gray-800">
                    <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">Mobile</p>
                    <p class="text-sm text-gray-900 dark:text-white">{{ $user['mobile'] }}</p>
                </div>
            @endif

            @if (! empty($user['bio']))
                <div class="rounded-xl bg-white p-4 shadow-sm dark:bg-gray-800">
                    <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">Bio</p>
                    <p class="text-sm text-gray-900 dark:text-white">{{ $user['bio'] }}</p>
                </div>
            @endif

            @if (! empty($user['roles']))
                <div class="rounded-xl bg-white p-4 shadow-sm dark:bg-gray-800">
                    <p class="mb-2 text-xs font-medium uppercase tracking-wide text-gray-400 dark:text-gray-500">Roles</p>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach ($user['roles'] as $role)
                            <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ $role }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="pt-4 w-full">
                <a href="{{ route('profile.edit') }}" class="block w-full rounded-lg bg-blue-600 py-3 text-center text-sm font-semibold text-white transition hover:bg-blue-700">
                    Edit Profile
                </a>
            </div>
        </div>
    @else
        <p class="text-sm text-gray-400 dark:text-gray-500">Loading profile…</p>
    @endif
</div>
