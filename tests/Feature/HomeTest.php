<?php

use App\Livewire\Home;
use App\Services\ApiService;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

beforeEach(function () {
    session()->flush();
    session(['api_token' => 'fake-token']);
});

it('shows the home page when authenticated', function () {
    Http::fake([
        '*/api/v1/users/profile' => Http::response([
            'data' => [
                'name' => 'Nasir Khan',
                'email' => 'nasir@example.com',
                'avatar' => null,
                'roles' => ['admin'],
                'can' => ['edit_profile' => true],
            ],
        ], 200),
    ]);

    Livewire::test(Home::class)
        ->assertSet('user.name', 'Nasir Khan')
        ->assertSee('Nasir Khan');
});

it('falls back to session user when api call fails', function () {
    session(['api_user' => ['name' => 'Cached User', 'email' => 'cached@example.com']]);

    Http::fake([
        '*/api/v1/users/profile' => Http::response([], 401),
    ]);

    Livewire::test(Home::class)
        ->assertSet('user.name', 'Cached User');
});

it('clears session and redirects on logout', function () {
    Http::fake([
        '*/api/v1/users/profile' => Http::response(['data' => []], 200),
        '*/api/v1/logout' => Http::response(['message' => 'Logged out successfully.'], 200),
    ]);

    Livewire::test(Home::class)
        ->call('logout', app(ApiService::class))
        ->assertRedirect(route('login'));

    expect(session()->has('api_token'))->toBeFalse();
});
