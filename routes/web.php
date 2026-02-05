<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\LoginController;
// import registeredusercontroller
use App\Http\Controllers\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ideas');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register')->middleware('guest');

Route::get('/ideas', [IdeaController::class, 'index'])->middleware('auth');

Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');
Route::get('/login', [LoginController::class, 'create'])->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth');
