<?php

use App\Livewire\Auth\Login;
use App\Livewire\Home;
use App\Livewire\Profile;
use App\Livewire\ProfileEdit;
use App\Services\ApiService;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');

Route::middleware('auth.api')->group(function () {
    Route::get('/', Home::class)->name('home');

    Route::get('/profile', Profile::class)->name('profile');

    Route::get('/profile/edit', ProfileEdit::class)->name('profile.edit');

    Route::post('/logout', function (ApiService $api) {
        $api->logout();
        session()->forget(['api_token', 'api_user']);

        return redirect()->route('login');
    })->name('logout');
});
