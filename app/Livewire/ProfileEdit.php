<?php

namespace App\Livewire;

use App\Services\ApiService;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Edit Profile')]
class ProfileEdit extends Component
{
    /** @var array<string, mixed> */
    public array $user = [];

    public string $firstName = '';

    public string $lastName = '';

    public string $mobile = '';

    public string $bio = '';

    public string $saveError = '';

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

        $this->saveError = '';

        if ($response->successful()) {
            session(['api_user' => $response->json('data')]);
            $this->redirect(route('profile'), navigate: true);
        } else {
            $this->saveError = $response->json('message') ?? 'Failed to update profile. Please try again.';
        }
    }

    public function render(): View
    {
        return view('livewire.profile-edit');
    }
}
