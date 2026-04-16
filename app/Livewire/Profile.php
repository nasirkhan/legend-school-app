<?php

namespace App\Livewire;

use App\Services\ApiService;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Profile')]
class Profile extends Component
{
    /** @var array<string, mixed> */
    public array $user = [];

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
    }

    public function render(): View
    {
        return view('livewire.profile');
    }
}
