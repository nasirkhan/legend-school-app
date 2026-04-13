<?php

use App\Livewire\Profile;
use App\Services\ApiService;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

beforeEach(function () {
    session()->flush();
    session(['api_token' => 'fake-token']);
});

it('loads and displays the current user profile', function () {
    Http::fake([
        '*/api/v1/users/profile' => Http::response([
            'data' => [
                'first_name' => 'Nasir',
                'last_name' => 'Khan',
                'mobile' => '01700000000',
                'bio' => 'Test bio',
            ],
        ], 200),
    ]);

    Livewire::test(Profile::class)
        ->assertSet('firstName', 'Nasir')
        ->assertSet('lastName', 'Khan')
        ->assertSet('mobile', '01700000000')
        ->assertSet('bio', 'Test bio');
});

it('saves profile changes and sets saved flag', function () {
    Http::fake([
        '*/api/v1/users/profile' => Http::sequence()
            ->push(['data' => ['first_name' => 'Nasir', 'last_name' => 'Khan', 'mobile' => '', 'bio' => '']], 200)
            ->push(['data' => ['first_name' => 'Updated', 'last_name' => 'Name', 'mobile' => '01711111111', 'bio' => 'New bio']], 200),
    ]);

    Livewire::test(Profile::class)
        ->set('firstName', 'Updated')
        ->set('lastName', 'Name')
        ->set('mobile', '01711111111')
        ->set('bio', 'New bio')
        ->call('save', app(ApiService::class))
        ->assertSet('saved', true)
        ->assertSet('firstName', 'Updated');
});

it('validates required first and last name', function () {
    Http::fake([
        '*/api/v1/users/profile' => Http::response(['data' => []], 200),
    ]);

    Livewire::test(Profile::class)
        ->set('firstName', '')
        ->set('lastName', '')
        ->call('save', app(ApiService::class))
        ->assertHasErrors(['firstName', 'lastName']);
});
