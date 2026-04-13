<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;

class Home extends Component
{
    /** @var array<string, mixed> */
    public array $user = [];

    public function mount(ApiService $api): void
    {
        $sessionUser = session('api_user', []);

        $response = $api->getProfile();

        if ($response->successful()) {
            $this->user = $response->json('data');
            session(['api_user' => $this->user]);
        } else {
            $this->user = $sessionUser;
        }
    }

    public function logout(ApiService $api): void
    {
        $api->logout();

        session()->forget(['api_token', 'api_user']);

        $this->redirect(route('login'), navigate: true);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.home');
    }
}
