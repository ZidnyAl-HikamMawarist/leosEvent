<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LombaController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\TimelineController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\LombaDetailController;
/*
|--------------------------------------------------------------------------
| USER ROUTES (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
// Route::get('/timeline', [PageController::class, 'timeline'])->name('timeline');
Route::get('/lomba', [PageController::class, 'lomba'])->name('lomba');
Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri');
Route::get('/pendaftaran', [PageController::class, 'pendaftaran'])->name('pendaftaran');
Route::post('/pendaftaran', [PageController::class, 'storePendaftaran'])->name('pendaftaran.store');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/lomba/check-name', [LombaController::class, 'checkName'])->name('admin.lomba.checkName');
    Route::resource('lomba', LombaController::class);
    Route::resource('carousel', CarouselController::class);
    Route::resource('galeri', GalleryController::class);
    // Route::resource('timeline', TimelineController::class);
    Route::resource('faq', FaqController::class);

    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('admin.pendaftaran.index');
    Route::get('/pendaftaran/{id}/edit', [PendaftaranController::class, 'edit'])->name('admin.pendaftaran.edit');
    Route::put('/pendaftaran/{id}', [PendaftaranController::class, 'update'])->name('admin.pendaftaran.update');
    Route::delete('/pendaftaran/{id}', [PendaftaranController::class, 'destroy'])->name('admin.pendaftaran.destroy');
    Route::get('/pendaftaran/export', [PendaftaranController::class, 'export'])->name('admin.pendaftaran.export');

    // Dynamic Settings Routes
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');

    Route::get('/settings/about', [SettingController::class, 'about'])->name('admin.settings.about');
    Route::get('/settings/pendaftaran', [SettingController::class, 'pendaftaran'])->name('admin.settings.pendaftaran');
    Route::get('/settings/galeri', [SettingController::class, 'galeri'])->name('admin.settings.galeri');
    Route::get('/settings/informasi', [SettingController::class, 'informasi'])->name('admin.settings.informasi');
    Route::get('/settings/hero', [SettingController::class, 'hero'])->name('admin.settings.hero');
    Route::get('/settings/process', [SettingController::class, 'processFlow'])->name('admin.settings.process');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (BREEZE)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| AUTH DETAIL ROUTE ()
|--------------------------------------------------------------------------
*/
Route::get('/lomba/{lomba:slug}', [LombaDetailController::class, 'show'])->name('lomba.detail');