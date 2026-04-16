<div class="p-6">
    @if ($canCreateTasks)
        <div class="mb-6">
            <a
                href="{{ route('tasks.create') }}"
                wire:navigate
                class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Create Task
            </a>
        </div>
    @endif

    @include('livewire.tasks.partials.task-sections', [
        'createdTasks' => $createdTasks,
        'assignedTasks' => $assignedTasks,
        'canCreateTasks' => $canCreateTasks,
        'loadError' => $loadError,
    ])
</div>
