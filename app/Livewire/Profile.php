<?php

namespace App\Livewire;

use App\Services\ApiService;
use Livewire\Component;

class Profile extends Component
{
    /** @var array<string, mixed> */
    public array $user = [];

    public string $firstName = '';

    public string $lastName = '';

    public string $mobile = '';

    public string $bio = '';

    public bool $saved = false;

    public function mount(ApiService $api): void
    {
        $response = $api->getProfile();

        if ($response->successful()) {
            $this->user = $response->json('data');
            $this->firstName = $this->user['first_name'] ?? '';
            $this->lastName = $this->user['last_name'] ?? '';
            $this->mobile = $this->user['mobile'] ?? '';
            $this->bio = $this->user['bio'] ?? '';
        }
    }

    public function save(ApiService $api): void
    {
        $this->validate([
            'firstName' => ['required', 'string', 'max:191'],
            'lastName' => ['required', 'string', 'max:191'],
            'mobile' => ['nullable', 'string', 'max:191'],
            'bio' => ['nullable', 'string', 'max:191'],
        ]);

        $response = $api->updateProfile([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'mobile' => $this->mobile,
            'bio' => $this->bio,
        ]);

        if ($response->successful()) {
            $this->user = $response->json('data');
            session(['api_user' => $this->user]);
            $this->saved = true;
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.profile');
    }
}
