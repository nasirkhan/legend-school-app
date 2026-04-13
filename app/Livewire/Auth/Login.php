<?php

namespace App\Livewire\Auth;

use App\Services\ApiService;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public string $errorMessage = '';

    public function login(ApiService $api): void
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $response = $api->login($this->email, $this->password, 'LegendSchoolApp');

        if (! $response->successful()) {
            $this->errorMessage = $response->json('message')
                ?? $response->json('errors.email.0')
                ?? __('auth.failed');

            return;
        }

        session([
            'api_token' => $response->json('token'),
            'api_user' => $response->json('user'),
        ]);

        $this->redirect(route('home'), navigate: true);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.auth.login')
            ->layout('layouts.auth');
    }
}
