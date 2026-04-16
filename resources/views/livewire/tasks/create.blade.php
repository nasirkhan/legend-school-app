<div class="p-6">
    <div class="rounded-xl bg-white p-4 shadow-sm dark:bg-gray-800">
        <div class="mb-4">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">Create Task</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Use the same assignment flow as the backend task form.</p>
        </div>

        @include('livewire.tasks.partials.form', ['submitLabel' => 'Create task'])
    </div>
</div>
