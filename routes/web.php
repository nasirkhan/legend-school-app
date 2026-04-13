<?php

use App\Livewire\Auth\Login;
use App\Livewire\Home;
use App\Livewire\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');

Route::middleware('auth.api')->group(function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/profile', Profile::class)->name('profile');
});
