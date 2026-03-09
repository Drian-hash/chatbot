<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TteController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\IkasandiKategoriController;
use App\Http\Controllers\Admin\IdentifikasiController;
use App\Http\Controllers\Admin\ProteksiController;
use App\Http\Controllers\Admin\DeteksiController;
use App\Http\Controllers\Admin\GulihController;


Route::get('/', function () {
    return view('welcome');
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

        // TTe
        Route::resource('tte', TteController::class)->names('tte');
        Route::post('tte/import', [TteController::class, 'import'])->name('tte.import');
        Route::get('tte/export/excel', [TteController::class, 'exportExcel'])->name('tte.export.excel');

        // Ikasandi

        Route::prefix('ikasandi')->name('ikasandi.')->group(function () {

            //kategori
            Route::resource('kategori', IkasandiKategoriController::class)->names('kategori');

            //identifikasi
            Route::resource('identifikasi', IdentifikasiController::class)->names('identifikasi');
            Route::post('identifikasi/import', [IdentifikasiController::class, 'import'])->name('identifikasi.import');
            Route::post('identifikasi/update-nilai', [IdentifikasiController::class, 'updateNilai'])->name('identifikasi.updateNilai');
            Route::post('identifikasi/upload-bukti', [IdentifikasiController::class, 'uploadBukti'])->name('identifikasi.uploadBukti');
            Route::delete(
                'identifikasi/hapus-bukti/{id}',
                [IdentifikasiController::class, 'hapusBukti']
            )->name('identifikasi.hapusbukti');

            //proteksi
            Route::resource('proteksi', ProteksiController::class)->names('proteksi');
            Route::post('proteksi/import', [ProteksiController::class, 'import'])->name('proteksi.import');
            Route::post('proteksi/update-nilai', [ProteksiController::class, 'updateNilai'])->name('proteksi.updateNilai');
            Route::post('proteksi/upload-bukti', [ProteksiController::class, 'uploadBukti'])->name('proteksi.uploadBukti');
            Route::delete(
                'proteksi/hapus-bukti/{id}',
                [ProteksiController::class, 'hapusBukti']
            )->name('proteksi.hapusbukti');

            //deteksi
            Route::resource('deteksi', DeteksiController::class)->names('deteksi');
            Route::post('deteksi/import', [DeteksiController::class, 'import'])->name('deteksi.import');
            Route::post('deteksi/update-nilai', [DeteksiController::class, 'updateNilai'])->name('deteksi.updateNilai');
            Route::post('deteksi/upload-bukti', [DeteksiController::class, 'uploadBukti'])->name('deteksi.uploadBukti');
            Route::delete(
                'deteksi/hapus-bukti/{id}',
                [DeteksiController::class, 'hapusBukti']
            )->name('deteksi.hapusbukti');

            //gulih
            Route::resource('gulih', GulihController::class)->names('gulih');
            Route::post('gulih/import', [GulihController::class, 'import'])->name('gulih.import');
            Route::post('gulih/update-nilai', [GulihController::class, 'updateNilai'])->name('gulih.updateNilai');
            Route::post('gulih/upload-bukti', [GulihController::class, 'uploadBukti'])->name('gulih.uploadBukti');
            Route::delete(
                'gulih/hapus-bukti/{id}',
                [GulihController::class, 'hapusBukti']
            )->name('gulih.hapusbukti');
        });

        //Berita berklarifikasi
        Route::resource('berita', BeritaController::class)->names('berita');
        Route::get('berita/export/excel', [BeritaController::class, 'exportExcel'])->name('berita.export.excel');
    });
});
