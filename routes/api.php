<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\User\CreateUserController;
use App\Http\Middleware\VerifyToken;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'execute']);

Route::post('/logout', [LogoutController::class, 'execute'])->middleware(VerifyToken::class);

Route::post('/register', [CreateUserController::class, 'execute']);
