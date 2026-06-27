<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\DisbursementController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserCampaignController;

Route::get('/', function () {
    return view('welcome');
});

// REGISTER
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

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
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/user/profile', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/user/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::get('/user/campaigns', [UserCampaignController::class, 'index'])->name('user.campaigns');

    // route sementara buat cek halaman
    Route::get('/user/campaigns/{id}/detail', [UserCampaignController::class, 'ownerDetail'])->name('user.campaigns.owner-detail');

    // route sementara buat cek halaman
    Route::get('/user/campaigns/{id}/edit', function($id) {
        return response('<h1 style="font-family:sans-serif; text-align:center; margin-top:50px; color:#4A5568;">Halaman Kosong (Placeholder Form Edit Campaign #ID-' . $id . ')</h1>');
    })->name('user.campaigns.edit');
    
    Route::middleware(['check.eligibility'])->group(function () {
        // route sementara buat cek halaman, nanti bisa diubah sesuaiin sama rute create campaign yg udah jadi
        Route::get('/user/campaigns/create', function() {
            return view('user.campaigns.create'); 
        })->name('user.campaigns.create');
    });
});