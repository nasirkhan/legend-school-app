<div class="p-6">
    <div class="rounded-xl bg-white p-4 shadow-sm dark:bg-gray-800">
        <div class="mb-4">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">Edit Task</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Task creators and elevated users can update task details here.</p>
        </div>

        @include('livewire.tasks.partials.form', ['submitLabel' => 'Save changes'])
    </div>
</div>
