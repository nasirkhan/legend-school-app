@if ($loadError)
    <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700 dark:bg-red-900/40 dark:text-red-300">
        {{ $loadError }}
    </div>
@endif

@if ($saveError)
    <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700 dark:bg-red-900/40 dark:text-red-300">
        {{ $saveError }}
    </div>
@endif

<form wire:submit="save" class="space-y-4">
    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
            Name
        </label>
        <input
            type="text"
            wire:model="name"
            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
        />
        @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Due date & time
            </label>
            <input
                type="datetime-local"
                wire:model="dueAt"
                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            />
            @error('dueAt')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Status
            </label>
            <select
                wire:model="status"
                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            >
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
            </select>
            @error('status')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Primary assignee
            </label>
            <select
                wire:model="primaryAssigneeId"
                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            >
                <option value="">Select an option</option>
                @foreach ($userOptions as $option)
                    <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
                @endforeach
            </select>
            @error('primaryAssigneeId')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Assign to role
            </label>
            <select
                wire:model="assignedRoleId"
                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            >
                <option value="">Select an option</option>
                @foreach ($roleOptions as $option)
                    <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
                @endforeach
            </select>
            @error('assignedRoleId')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
            Co-assignees
        </label>
        <select
            wire:model="coAssigneeIds"
            multiple
            class="min-h-40 w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
        >
            @foreach ($userOptions as $option)
                <option value="{{ $option['id'] }}">
                    {{ $option['name'] }}@if (! empty($option['email'])) ({{ $option['email'] }}) @endif
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Hold Ctrl or Cmd to choose more than one user.
        </p>
        @error('coAssigneeIds')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
        @error('coAssigneeIds.*')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    @if (collect($user['permissions'] ?? [])->contains('edit_tasks'))
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Completed date & time
            </label>
            <input
                type="datetime-local"
                wire:model="completedAt"
                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            />
            @error('completedAt')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
            Description
        </label>
        <textarea
            wire:model="description"
            rows="5"
            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
        ></textarea>
        @error('description')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button
        type="submit"
        wire:loading.attr="disabled"
        class="w-full rounded-lg bg-blue-600 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:opacity-60"
    >
        <span wire:loading.remove>{{ $submitLabel }}</span>
        <span wire:loading>Saving…</span>
    </button>
</form>
