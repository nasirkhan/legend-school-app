<?php

namespace App\Livewire;

use App\Services\ApiService;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home')]
class Home extends Component
{
    /** @var array<string, mixed> */
    public array $user = [];

    /** @var array<int, array<string, mixed>> */
    public array $createdTasks = [];

    /** @var array<int, array<string, mixed>> */
    public array $assignedTasks = [];

    public bool $canCreateTasks = false;

    public string $taskLoadError = '';

    public function mount(ApiService $api): void
    {
        $sessionUser = session('api_user', []);

        $response = $api->getProfile();

        if ($response->status() === 401) {
            session()->forget(['api_token', 'api_user']);
            $this->redirect(route('login'), navigate: true);

            return;
        }

        if ($response->successful()) {
            $this->user = $response->json('data');
            session(['api_user' => $this->user]);
        } else {
            $this->user = $sessionUser;
        }

        $this->canCreateTasks = collect($this->user['permissions'] ?? [])
            ->contains('add_tasks');

        $this->loadTasks($api);
    }

    public function logout(ApiService $api): void
    {
        $api->logout();

        session()->forget(['api_token', 'api_user']);

        $this->redirect(route('login'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.home');
    }

    protected function loadTasks(ApiService $api): void
    {
        $response = $api->getTasks(['per_page' => 100]);

        if ($response->status() === 401) {
            session()->forget(['api_token', 'api_user']);
            $this->redirect(route('login'), navigate: true);

            return;
        }

        if (! $response->successful()) {
            $this->taskLoadError = $response->json('message') ?? 'Unable to load tasks right now.';

            return;
        }

        $tasks = $response->json('data', []);
        $userId = (int) ($this->user['id'] ?? 0);
        $userRoles = collect($this->user['roles'] ?? [])->map(fn ($role) => mb_strtolower((string) $role));

        $this->createdTasks = array_values(array_filter($tasks, fn ($task) => (int) ($task['creator']['id'] ?? 0) === $userId));

        $this->assignedTasks = array_values(array_filter($tasks, function ($task) use ($userId, $userRoles) {
            if ((int) ($task['creator']['id'] ?? 0) === $userId) {
                return false;
            }

            if ((int) ($task['primary_assignee']['id'] ?? 0) === $userId) {
                return true;
            }

            $isCoAssignee = collect($task['co_assignees'] ?? [])->pluck('id')->contains($userId);

            if ($isCoAssignee) {
                return true;
            }

            $assignedRole = mb_strtolower((string) ($task['assigned_role']['name'] ?? ''));

            return $assignedRole !== '' && $userRoles->contains($assignedRole);
        }));
    }
}
