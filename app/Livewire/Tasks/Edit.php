<?php

namespace App\Livewire\Tasks;

use App\Livewire\Tasks\Concerns\HandlesTaskForm;
use App\Services\ApiService;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Edit Task')]
class Edit extends Component
{
    use HandlesTaskForm;

    public int $taskId;

    /** @var array<string, mixed> */
    public array $user = [];

    /** @var array<string, mixed> */
    public array $taskData = [];

    public bool $canEditTask = false;

    public function mount(ApiService $api, int $task): void
    {
        $this->taskId = $task;
        $this->loadCurrentUser($api);
        $this->loadTaskOptions($api);
        $this->loadTask($api);

        abort_unless($this->canEditTask, 403);
    }

    public function save(ApiService $api): void
    {
        abort_unless($this->canEditTask, 403);

        $this->validate($this->taskRules());

        $response = $api->updateTask($this->taskId, $this->taskPayload());
        $this->saveError = '';

        if ($response->successful()) {
            session()->flash('status', 'Task updated successfully.');
            $this->redirect(route('tasks.index'), navigate: true);

            return;
        }

        $this->saveError = $response->json('message') ?? 'Failed to update task. Please try again.';
    }

    public function render(): View
    {
        return view('livewire.tasks.edit');
    }

    protected function loadCurrentUser(ApiService $api): void
    {
        $sessionUser = session('api_user', []);
        $response = $api->getProfile();

        if ($response->successful()) {
            $this->user = $response->json('data', []);
            session(['api_user' => $this->user]);
        } else {
            $this->user = $sessionUser;
        }
    }

    protected function loadTask(ApiService $api): void
    {
        $response = $api->getTask($this->taskId);

        if (! $response->successful()) {
            abort($response->status());
        }

        $this->taskData = $response->json('data', []);
        $this->canEditTask = (bool) ($this->taskData['can']['edit'] ?? false);
        $this->fillTaskForm($this->taskData);
    }
}
