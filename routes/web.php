<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
})->middleware('CheckToken'); ;

Route::get('/auth/authenticate', function () {
    return view('OauthProxy');
}); 

Route::get('/auth/supabase/google', [AuthController::class, 'redirectToSupabase'])->name('supabase.google');
Route::get('/auth/supabase/callback', [AuthController::class, 'handleSupabaseCallback'])->name('supabase.callback');