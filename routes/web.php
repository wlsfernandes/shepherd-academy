<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ImageUploadController;



Route::get('/', function () {
    return view('welcome');
});

// Locale Language 
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'es'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');


// 🧱 ADMIN SECTION
/*
|--------------------------------------------------------------------------
| Authentication (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin (protected by Gate)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Breeze compatibility
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    /***  SPECIFIC RESOURCES */
    Route::get('/files/{model}/{id}/{lang}', [FileUploadController::class, 'edit'])->name('admin.files.edit');
    Route::post('/files/{model}/{id}/{lang}', [FileUploadController::class, 'update'])->name('admin.files.update');
    Route::get('/files/{model}/{id}/{lang}/download', [FileUploadController::class, 'download'])->name('admin.files.download');
    Route::get('/images/{model}/{id}', [ImageUploadController::class, 'edit'])->name('admin.images.edit');
    Route::post('/images/{model}/{id}', [ImageUploadController::class, 'update'])->name('admin.images.update');
    Route::get('/images/{model}/{id}/preview', [ImageUploadController::class, 'preview'])->name('admin.images.preview');

    /***  ADMIN RESOURCES */
    Route::resource('users', UserController::class)->except(['show']);

    Route::get('system-logs', [SystemLogController::class, 'index'])->name('system-logs.index');
    Route::get('audits', [AuditController::class, 'index'])->name('audits.index');
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('events', EventController::class);
});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});