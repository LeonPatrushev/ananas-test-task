<?php

use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [PassportAuthController::class, 'login'])->name('login');
Route::post('/register', [PassportAuthController::class, 'register'])->name('register');

Route::middleware('auth:api')->group(function(){
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
});