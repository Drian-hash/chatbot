<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\KeywordController;
use App\Http\Controllers\Admin\ChatLogController;
use App\Http\Controllers\Admin\ChatbotController;
use App\Http\Controllers\Admin\PermohonanController;
use App\Http\Controllers\Admin\ProfileController;

// Webhook WhatsApp (NLP Bot)
Route::post('/webhook/wa', [ChatbotController::class, 'webhook']);

// Root Redirect
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Authentication
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // ADMIN ONLY (HARUS LOGIN)
    Route::middleware('admin')->group(function () {

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile Admin
        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        /* =====================================
           1. MASTER DATA
        ===================================== */
        // Layanan
        Route::resource('layanan', LayananController::class)->names('layanan');

        // FAQ
        Route::resource('faq', FaqController::class)->names('faq');
        Route::post('faq/import', [FaqController::class, 'import'])->name('faq.import');

        // Keyword (Sistem NLP Pembantu)
        Route::resource('keyword', KeywordController::class)->names('keyword');


        /* =====================================
           2. LAYANAN PUBLIK
        ===================================== */
        // Permohonan (Dipastikan menggunakan PermohonanController)
        Route::resource('permohonan', PermohonanController::class)->names('permohonan');

        // Percakapan (Menggantikan URL chatlog)
        Route::resource('percakapan', ChatLogController::class)->names('chatlog');


        /* =====================================
           3. MONITORING
        ===================================== */
        // Pengguna (Menggantikan URL user)
        Route::get('pengguna/export', [UserController::class, 'export'])->name('user.export');
        Route::resource('pengguna', UserController::class)->names('user');

    });
});
