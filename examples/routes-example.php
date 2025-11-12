<?php

use Illuminate\Support\Facades\Route;
use Saeedvir\Supabase\Examples\SupabaseExampleController;

/*
|--------------------------------------------------------------------------
| Supabase Package Examples
|--------------------------------------------------------------------------
|
| These routes are examples of how to use the Supabase Laravel Package.
| You can copy and modify these routes in your application.
|
*/

Route::prefix('supabase')->group(function () {
    Route::get('/users', [SupabaseExampleController::class, 'getUsers']);
    Route::post('/auth', [SupabaseExampleController::class, 'authenticate']);
    Route::post('/upload-avatar', [SupabaseExampleController::class, 'uploadAvatar']);
    Route::get('/info', [SupabaseExampleController::class, 'info']);
});