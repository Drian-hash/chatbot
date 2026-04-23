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
use App\Http\Controllers\Admin\ProfileController;


Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::prefix('admin')->name('admin.')->group(function () {

    // Login
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // ADMIN ONLY (HARUS LOGIN)
    Route::middleware('admin')->group(function () {

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // profile
        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        // User
        Route::resource('user', UserController::class)->names('user');
        Route::get('user/export', [UserController::class, 'export'])->name('user.export');

        //Pelayanan
        Route::resource('layanan', LayananController::class)->names('layanan');

        //Faq
        Route::resource('faq', FaqController::class);
        Route::post('faq/import', [FaqController::class, 'import'])->name('faq.import');

        //keyword
        Route::resource('keyword', KeywordController::class)->names('keyword');

        //chatlog
        Route::resource('chatlog', ChatLogController::class)->names('chatlog');

        Route::post('/webhook/wa', [ChatbotController::class, 'webhook']);
    });
});
