<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| All admin panel routes - no locale prefix
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Redirect /admin to /admin/dashboard
    Route::redirect('/', '/admin/dashboard');

    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Tools Management
    // Tools Management
    Route::prefix('tools')->name('tools.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminToolController::class, 'index'])->name('index');
        Route::post('/sync', [App\Http\Controllers\Admin\AdminToolController::class, 'sync'])->name('sync');
        Route::post('/build', [App\Http\Controllers\Admin\AdminToolController::class, 'build'])->name('build');
        Route::get('/{tool}/edit', [App\Http\Controllers\Admin\AdminToolController::class, 'edit'])->name('edit');
        Route::put('/{tool}', [App\Http\Controllers\Admin\AdminToolController::class, 'update'])->name('update');

        // Tool Categories
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    });

    // Language Management
    Route::prefix('languages')->name('languages.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminLanguageController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\AdminLanguageController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\AdminLanguageController::class, 'store'])->name('store');
        Route::get('/{language}/edit', [App\Http\Controllers\Admin\AdminLanguageController::class, 'edit'])->name('edit');
        Route::put('/{language}', [App\Http\Controllers\Admin\AdminLanguageController::class, 'update'])->name('update');
        Route::put('/{language}/toggle', [App\Http\Controllers\Admin\AdminLanguageController::class, 'toggle'])->name('toggle');
        Route::put('/{language}/set-default', [App\Http\Controllers\Admin\AdminLanguageController::class, 'setDefault'])->name('set-default');
        Route::delete('/{language}', [App\Http\Controllers\Admin\AdminLanguageController::class, 'destroy'])->name('destroy');
        Route::get('/report', [App\Http\Controllers\Admin\AdminTranslationReportController::class, 'index'])->name('report');
        Route::get('/checker', [App\Http\Controllers\Admin\AdminTranslationCheckerController::class, 'index'])->name('checker');
    });

    // Sitemap Management
    Route::get('/sitemap', [App\Http\Controllers\Admin\AdminSitemapController::class, 'index'])->name('sitemap.index');
    Route::post('/sitemap/generate', [App\Http\Controllers\Admin\AdminSitemapController::class, 'generate'])->name('sitemap.generate');

    // Posts Management
    Route::resource('posts', App\Http\Controllers\Admin\PostController::class);
    Route::post('posts/{post}/publish', [App\Http\Controllers\Admin\PostController::class, 'publish'])->name('posts.publish');

    // Categories & Tags
    // Categories & Tags
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('categories/list', [App\Http\Controllers\Admin\BlogCategoryController::class, 'list'])->name('categories.list');
        Route::resource('categories', App\Http\Controllers\Admin\BlogCategoryController::class);
    });



    Route::prefix('tags')->name('tags.')->group(function () {
        Route::get('/list', [App\Http\Controllers\Admin\PostController::class, 'tagsList'])->name('list');
        Route::post('/', [App\Http\Controllers\Admin\PostController::class, 'storeTag'])->name('store');
    });

    // Media Management
    Route::get('media/list', [App\Http\Controllers\Admin\MediaController::class, 'list'])->name('media.list');
    Route::resource('media', App\Http\Controllers\Admin\MediaController::class);
    Route::post('media/upload', [App\Http\Controllers\Admin\MediaController::class, 'upload'])->name('media.upload');


    // YouTube Tools
    Route::prefix('youtube')->name('youtube.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('update');
        Route::post('/generate-sitemap', [App\Http\Controllers\Admin\SettingController::class, 'generateSitemap'])->name('generate-sitemap');
    });

    // Redirects Management
    Route::resource('redirects', App\Http\Controllers\Admin\RedirectController::class);
    Route::post('redirects/import', [App\Http\Controllers\Admin\RedirectController::class, 'import'])->name('redirects.import');

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('edit');
        Route::put('/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('password.update');
    });

    // Admin User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['show']);


    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('update');
        Route::post('/generate-sitemap', [App\Http\Controllers\Admin\SettingController::class, 'generateSitemap'])->name('generate-sitemap');

        // Cache System
        Route::get('/cache', [App\Http\Controllers\Admin\SettingController::class, 'cache'])->name('cache');
        Route::post('/cache/clear', [App\Http\Controllers\Admin\SettingController::class, 'clearCache'])->name('cache.clear');
    });
});
