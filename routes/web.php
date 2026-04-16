<?php

use App\Livewire\Auth\Login;
use App\Livewire\Home;
use App\Livewire\Profile;
use App\Livewire\ProfileEdit;
use App\Livewire\Tasks\Create as TaskCreate;
use App\Livewire\Tasks\Edit as TaskEdit;
use App\Livewire\Tasks\Index as TaskIndex;
use App\Services\ApiService;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');

Route::middleware('auth.api')->group(function () {
    Route::get('/', Home::class)->name('home');

    Route::get('/profile', Profile::class)->name('profile');

    Route::get('/profile/edit', ProfileEdit::class)->name('profile.edit');

    Route::get('/tasks', TaskIndex::class)->name('tasks.index');

    Route::get('/tasks/create', TaskCreate::class)->name('tasks.create');

    Route::get('/tasks/{task}/edit', TaskEdit::class)->name('tasks.edit');

    Route::post('/logout', function (ApiService $api) {
        $api->logout();
        session()->forget(['api_token', 'api_user']);

        return redirect()->route('login');
    })->name('logout');
});
