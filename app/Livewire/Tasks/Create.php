<?php

namespace App\Livewire\Tasks;

use App\Livewire\Tasks\Concerns\HandlesTaskForm;
use App\Services\ApiService;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Create Task')]
class Create extends Component
{
    use HandlesTaskForm;

    /** @var array<string, mixed> */
    public array $user = [];

    public bool $canCreateTasks = false;

    public function mount(ApiService $api): void
    {
        $this->loadCurrentUser($api);
        abort_unless($this->canCreateTasks, 403);

        $this->loadTaskOptions($api);
    }

    public function save(ApiService $api): void
    {
        $this->validate($this->taskRules());

        $response = $api->createTask($this->taskPayload());
        $this->saveError = '';

        if ($response->status() === 401) {
            session()->forget(['api_token', 'api_user']);
            $this->redirect(route('login'), navigate: true);

            return;
        }

        if ($response->successful()) {
            session()->flash('status', 'Task created successfully.');
            $this->redirect(route('tasks.index'), navigate: true);

            return;
        }

        $this->saveError = $response->json('message') ?? 'Failed to create task. Please try again.';
    }

    public function render(): View
    {
        return view('livewire.tasks.create');
    }

    protected function loadCurrentUser(ApiService $api): void
    {
        $sessionUser = session('api_user', []);
        $response = $api->getProfile();

        if ($response->status() === 401) {
            session()->forget(['api_token', 'api_user']);
            $this->redirect(route('login'), navigate: true);

            return;
        }

        if ($response->successful()) {
            $this->user = $response->json('data', []);
            session(['api_user' => $this->user]);
        } else {
            $this->user = $sessionUser;
        }

        $this->canCreateTasks = collect($this->user['permissions'] ?? [])
            ->contains('add_tasks');
    }
}
