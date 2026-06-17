<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\Admin\CampaignController;

Route::get('/', function () {
    return view('welcome');
});

// LOGIN
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ADMIN
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/campaigns', [CampaignController::class, 'index'])->name('admin.campaigns');
    Route::get('/admin/campaigns/{id}', [CampaignController::class, 'show'])->name('admin.campaigns.show');
    Route::post('/admin/campaigns/{id}/verify', [CampaignController::class, 'verify'])->name('admin.campaigns.verify');
});

// USER
Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware('auth')->name('user.dashboard');