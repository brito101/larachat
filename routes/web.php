<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/chat', [ChatController::class, 'index'])
    ->name('chat')
    ->middleware('auth');

Route::get('/', function () {
    return redirect('chat');
})->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
