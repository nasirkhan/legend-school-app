<?php

namespace App\Livewire\Tasks\Concerns;

use App\Services\ApiService;
use Carbon\Carbon;

trait HandlesTaskForm
{
    public string $name = '';

    public string $description = '';

    public string $dueAt = '';

    public string $status = 'pending';

    public string $completedAt = '';

    public ?int $primaryAssigneeId = null;

    public ?int $assignedRoleId = null;

    /** @var array<int, int> */
    public array $coAssigneeIds = [];

    /** @var array<int, array{id:int,name:string,email:?string}> */
    public array $userOptions = [];

    /** @var array<int, array{id:int,name:string}> */
    public array $roleOptions = [];

    public string $loadError = '';

    public string $saveError = '';

    protected function taskRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'dueAt' => ['required', 'date'],
            'status' => ['required', 'in:pending,completed'],
            'primaryAssigneeId' => ['nullable', 'integer'],
            'assignedRoleId' => ['nullable', 'integer'],
            'coAssigneeIds' => ['nullable', 'array'],
            'coAssigneeIds.*' => ['integer', 'distinct'],
            'completedAt' => ['nullable', 'date'],
        ];
    }

    protected function loadTaskOptions(ApiService $api): void
    {
        $response = $api->getTaskOptions();

        if (! $response->successful()) {
            $this->loadError = $response->json('message') ?? 'Unable to load task options right now.';

            return;
        }

        $this->userOptions = $response->json('data.users', []);
        $this->roleOptions = $response->json('data.roles', []);
    }

    /**
     * @param  array<string, mixed>  $task
     */
    protected function fillTaskForm(array $task): void
    {
        $this->name = (string) ($task['name'] ?? '');
        $this->description = (string) ($task['description'] ?? '');
        $this->dueAt = $this->toLocalDateTimeInput($task['due_at'] ?? null);
        $this->status = (string) ($task['status'] ?? 'pending');
        $this->completedAt = $this->toLocalDateTimeInput($task['completed_at'] ?? null);
        $this->primaryAssigneeId = $task['primary_assignee']['id'] ?? null;
        $this->assignedRoleId = $task['assigned_role']['id'] ?? null;
        $this->coAssigneeIds = collect($task['co_assignees'] ?? [])
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    protected function taskPayload(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description ?: null,
            'due_at' => $this->toApiDateTime($this->dueAt),
            'status' => $this->status,
            'primary_assignee_id' => $this->primaryAssigneeId ?: null,
            'assigned_role_id' => $this->assignedRoleId ?: null,
            'co_assignee_ids' => $this->coAssigneeIds,
            'completed_at' => $this->completedAt ? $this->toApiDateTime($this->completedAt) : null,
        ];
    }

    protected function toLocalDateTimeInput(?string $value): string
    {
        if (! $value) {
            return '';
        }

        return Carbon::parse($value)->format('Y-m-d\TH:i');
    }

    protected function toApiDateTime(string $value): string
    {
        return Carbon::parse($value)->toDateTimeString();
    }
}
