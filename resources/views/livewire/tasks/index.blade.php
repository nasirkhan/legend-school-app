<div class="p-6">
    @include('livewire.tasks.partials.task-sections', [
        'createdTasks' => $createdTasks,
        'assignedTasks' => $assignedTasks,
        'canCreateTasks' => $canCreateTasks,
        'loadError' => $loadError,
    ])
</div>
