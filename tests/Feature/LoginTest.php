<?php

use App\Livewire\Auth\Login;
use App\Services\ApiService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

beforeEach(function () {
    session()->flush();
});

it('shows the login page', function () {
    $this->get(route('login'))->assertSeeLivewire(Login::class);
});

it('redirects to home after successful login', function () {
    Http::fake([
        '*/api/v1/login' => Http::response([
            'token' => 'test-token-abc',
            'user' => ['id' => 1, 'name' => 'Test User', 'email' => 'test@example.com'],
        ], 200),
    ]);

    Livewire::test(Login::class)
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->call('login', app(ApiService::class))
        ->assertRedirect(route('home'));

    expect(session('api_token'))->toBe('test-token-abc');
});

it('shows an error for invalid credentials', function () {
    Http::fake([
        '*/api/v1/login' => Http::response(['message' => 'These credentials do not match our records.'], 422),
    ]);

    Livewire::test(Login::class)
        ->set('email', 'wrong@example.com')
        ->set('password', 'bad-password')
        ->call('login', app(ApiService::class))
        ->assertSet('errorMessage', 'These credentials do not match our records.')
        ->assertNoRedirect();
});

it('validates required fields', function () {
    Livewire::test(Login::class)
        ->set('email', '')
        ->set('password', '')
        ->call('login', app(ApiService::class))
        ->assertHasErrors(['email', 'password']);
});

it('redirects unauthenticated users away from home', function () {
    $this->get(route('home'))->assertRedirect(route('login'));
});
