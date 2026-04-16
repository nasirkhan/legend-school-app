@if ($flash = session('status'))
    <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-900/40 dark:text-green-300">
        {{ $flash }}
    </div>
@endif

@if ($loadError)
    <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700 dark:bg-red-900/40 dark:text-red-300">
        {{ $loadError }}
    </div>
@endif

<div class="space-y-6">
    <section class="rounded-xl bg-white p-4 shadow-sm dark:bg-gray-800">
        <div class="mb-4 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Created Tasks</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tasks you created for others.</p>
            </div>
        </div>

        @if ($createdTasks)
            <div class="space-y-3">
                @foreach ($createdTasks as $task)
                    <article class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-white">{{ $task['name'] }}</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Due {{ \Carbon\Carbon::parse($task['due_at'])->format('d M Y, h:i A') }}
                                </p>
                            </div>

                            <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $task['is_completed'] ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' }}">
                                {{ ucfirst($task['status']) }}
                            </span>
                        </div>

                        @if (! empty($task['description']))
                            <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">{{ $task['description'] }}</p>
                        @endif

                        <div class="mt-3 flex flex-wrap gap-2 text-xs text-gray-500 dark:text-gray-400">
                            @if (! empty($task['primary_assignee']['name']))
                                <span class="rounded-full bg-gray-100 px-2.5 py-1 dark:bg-gray-700">
                                    Primary: {{ $task['primary_assignee']['name'] }}
                                </span>
                            @endif

                            @foreach ($task['co_assignees'] ?? [] as $assignee)
                                <span class="rounded-full bg-gray-100 px-2.5 py-1 dark:bg-gray-700">
                                    Co: {{ $assignee['name'] }}
                                </span>
                            @endforeach

                            @if (! empty($task['assigned_role']['name']))
                                <span class="rounded-full bg-gray-100 px-2.5 py-1 dark:bg-gray-700">
                                    Role: {{ $task['assigned_role']['name'] }}
                                </span>
                            @endif
                        </div>

                        @if ($task['can']['edit'] ?? false)
                            <div class="mt-4">
                                <a
                                    href="{{ route('tasks.edit', $task['id']) }}"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                >
                                    Edit task
                                </a>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 dark:text-gray-400">No created tasks yet.</p>
        @endif
    </section>

    <section class="rounded-xl bg-white p-4 shadow-sm dark:bg-gray-800">
        <div class="mb-4">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">Assigned Tasks</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Tasks assigned directly to you, your role, or as co-assignee.</p>
        </div>

        @if ($assignedTasks)
            <div class="space-y-3">
                @foreach ($assignedTasks as $task)
                    <article class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-white">{{ $task['name'] }}</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Due {{ \Carbon\Carbon::parse($task['due_at'])->format('d M Y, h:i A') }}
                                </p>
                            </div>

                            <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $task['is_completed'] ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' }}">
                                {{ ucfirst($task['status']) }}
                            </span>
                        </div>

                        @if (! empty($task['description']))
                            <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">{{ $task['description'] }}</p>
                        @endif

                        <div class="mt-3 flex flex-wrap gap-2 text-xs text-gray-500 dark:text-gray-400">
                            @if (! empty($task['creator']['name']))
                                <span class="rounded-full bg-gray-100 px-2.5 py-1 dark:bg-gray-700">
                                    Created by: {{ $task['creator']['name'] }}
                                </span>
                            @endif

                            @if (! empty($task['assigned_role']['name']))
                                <span class="rounded-full bg-gray-100 px-2.5 py-1 dark:bg-gray-700">
                                    Role: {{ $task['assigned_role']['name'] }}
                                </span>
                            @endif
                        </div>

                        @if ($task['can']['edit'] ?? false)
                            <div class="mt-4">
                                <a
                                    href="{{ route('tasks.edit', $task['id']) }}"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                >
                                    Edit task
                                </a>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 dark:text-gray-400">No assigned tasks right now.</p>
        @endif
    </section>
</div>
