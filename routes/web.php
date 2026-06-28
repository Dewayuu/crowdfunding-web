<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\DisbursementController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PageController;
use App\Http\Controllers\User\CampaignController as UserCampaignController;

Route::get('/', function () {
    return view('welcome');
});

// Forgot Password
Route::get('/forgot-password', [LoginController::class, 'showForgotPassword'])
    ->name('forgot.password');

Route::post('/forgot-password', [LoginController::class, 'sendResetLink'])
    ->name('forgot.password.send');
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
    Route::get('/admin/pengajuan-dana', [DisbursementController::class, 'index'])->name('admin.disbursements');
    Route::get('/admin/disbursements/{id}/{type}', [DisbursementController::class, 'show'])->name('admin.disbursements.show');
    Route::post('/admin/disbursements/{id}/{type}/update', [DisbursementController::class, 'update'])->name('admin.disbursements.update');
    Route::get('/admin/refunds/campaign/{campaignId}', [DisbursementController::class, 'refundDetail'])->name('admin.disbursements.refund-detail');
    Route::post('/admin/refunds/process/{refundId}', [DisbursementController::class, 'processRefund'])->name('admin.disbursements.process-refund');
    Route::get('/admin/refunds/campaign/{campaignId}/export', [DisbursementController::class, 'exportRefundAccounts'])->name('admin.disbursements.export-refund');
});

// USER

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('user.dashboard');

    Route::get('/beranda', [PageController::class, 'beranda'])
        ->name('beranda');

    Route::get('/donasi', [PageController::class, 'donasi'])
        ->name('donasi');

    Route::get('/tentang', [PageController::class, 'tentang'])
        ->name('tentang');

    Route::get('/kontak', [PageController::class, 'kontak'])
        ->name('kontak');

    Route::get('/campaign/create', [UserCampaignController::class, 'create'])
        ->name('campaign.create');

    Route::post('/campaign/store', [UserCampaignController::class, 'store'])
        ->name('campaign.store');
});