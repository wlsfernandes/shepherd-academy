<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AboutController;
use App\Http\Controllers\AmazonS3Controller;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DeveloperSettingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublishController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SocialLinkController;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;




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

});
Route::middleware(['auth', 'verified'])->group(function () {

    // Files
    Route::get('/files/{model}/{id}/{lang}', [FileUploadController::class, 'edit'])->name('admin.files.edit');
    Route::post('/files/{model}/{id}/{lang}', [FileUploadController::class, 'update'])->name('admin.files.update');
    Route::get('/files/{model}/{id}/{lang}/download', [FileUploadController::class, 'download'])->name('admin.files.download');

    // Images
    Route::get('/images/{model}/{id}', [ImageUploadController::class, 'edit'])->name('admin.images.edit');
    Route::post('/images/{model}/{id}', [ImageUploadController::class, 'update'])->name('admin.images.update');
    Route::get('/images/{model}/{id}/preview', [ImageUploadController::class, 'preview'])->name('admin.images.preview');

    // Publish toggle
    Route::patch('/publish/{model}/{id}', [PublishController::class, 'toggle'])->name('admin.publish.toggle');

});
/*
|--------------------------------------------------------------------------
| Administration
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:access-admin'])->group(function () {

    /*
     |--------------------------------------------------------------------------
     | LMS Content Management   move to right place
     |--------------------------------------------------------------------------
     */
    // S3 Amazon 
    Route::post('/s3-presigned-url', [AmazonS3Controller::class, 'generatePresignedUrl']);
    Route::view('/upload-test', 'upload');

    Route::get('/course/{course}/modules/create', [ModuleController::class, 'create'])->name('modules.create');
    // 🔹 Task Routes (Nested under module)
    Route::get('/module/{module}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/module/{module}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    // 🔹 Lessons Files Tests (Nested under Tasks)
    Route::get('/task/{task}/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/task/{task}/lessons', [LessonController::class, 'store'])->name('lessons.store');
    Route::get('/task/{task}/files/create', [FileController::class, 'create'])->name('files.create');
    Route::post('/task/{task}/files', [FileController::class, 'store'])->name('files.store');
    Route::get('/task/{task}/tests/create', [TestController::class, 'create'])->name('tests.create');
    Route::post('/task/{task}/tests', [TestController::class, 'store'])->name('tests.store');
    Route::delete('/question/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

    Route::resource("course", CourseController::class);
    Route::resource("module", ModuleController::class);
    Route::resource("task", TaskController::class);
    Route::resource("lesson", LessonController::class);
    Route::resource("file", FileController::class);
    Route::resource("test", TestController::class);

    /*
    |--------------------------------------------------------------------------
    | End LMS Content Management
    |--------------------------------------------------------------------------
    */

    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('roles', RoleController::class)->except(['show']);

    Route::get('audits', [AuditController::class, 'index'])->name('audits.index');
    Route::get('system-logs', [SystemLogController::class, 'index'])->name('system-logs.index');

});
/*
|--------------------------------------------------------------------------
| Website-admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:access-website-admin'])->group(function () {

    // Site Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    // Content
    Route::resource('banners', BannerController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('events', EventController::class);
    Route::resource('pages', PageController::class);
    Route::resource('about', AboutController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('resources', ResourceController::class);
    Route::resource('teams', TeamController::class);
    Route::resource('testimonials', TestimonialController::class);

    // Navigation & Social
    Route::resource('menu-items', MenuItemController::class);
    Route::resource('social-links', SocialLinkController::class);

});
/*
|--------------------------------------------------------------------------
| Developer
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'can:access-developer'])->group(function () {

    Route::get('/developer-settings', [DeveloperSettingController::class, 'index'])->name('developer-settings.index');
    Route::get('/developer-settings/edit', [DeveloperSettingController::class, 'edit'])->name('developer-settings.edit');
    Route::put('/developer-settings', [DeveloperSettingController::class, 'update'])->name('developer-settings.update');
    Route::post('/developer-settings/test-stripe', [DeveloperSettingController::class, 'testStripe'])->name('developer-settings.test-stripe');

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