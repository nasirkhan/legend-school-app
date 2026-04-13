<div class="p-6">
    <h1 class="mb-6 text-xl font-semibold text-gray-900 dark:text-white">Profile</h1>

    @if ($saved)
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-900 dark:text-green-200"
        >
            Profile updated successfully.
        </div>
    @endif

    <form wire:submit="save" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    First name
                </label>
                <input
                    type="text"
                    wire:model="firstName"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                />
                @error('firstName')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Last name
                </label>
                <input
                    type="text"
                    wire:model="lastName"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                />
                @error('lastName')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Mobile
            </label>
            <input
                type="tel"
                wire:model="mobile"
                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            />
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Bio
            </label>
            <textarea
                wire:model="bio"
                rows="3"
                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            ></textarea>
        </div>

        <button
            type="submit"
            wire:loading.attr="disabled"
            class="w-full rounded-lg bg-blue-600 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:opacity-60"
        >
            <span wire:loading.remove>Save changes</span>
            <span wire:loading>Saving…</span>
        </button>
    </form>
</div>
