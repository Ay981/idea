<?php

use Illuminate\Support\Facades\Route;
//import registeredusercontroller
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\LoginController;

Route::get('/', fn () => view(view: 'welcome'));
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class,'store']);
Route::get('/login', [LoginController::class,'create']);
Route::post('/login', [LoginController::class,'store']);
Route::post('/logout', [LoginController::class,'destroy']);
