<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\Website\HomepageSectionController;
use App\Http\Controllers\Admin\Website\ImpactCounterController;
use App\Http\Controllers\Admin\Website\WebsiteController;
use App\Http\Controllers\Admin\Website\WebsiteSettingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

        Route::middleware('can:website.manage')
            ->prefix('website')
            ->name('website.')
            ->group(function () {
                Route::get('/', [WebsiteController::class, 'index'])->name('index');
                Route::get('/settings', [WebsiteSettingController::class, 'edit'])->name('settings.edit');
                Route::put('/settings', [WebsiteSettingController::class, 'update'])->name('settings.update');
                Route::resource('sections', HomepageSectionController::class)
                    ->except(['show'])
                    ->parameters(['sections' => 'homepage_section']);
                Route::resource('counters', ImpactCounterController::class)
                    ->except(['show'])
                    ->parameters(['counters' => 'impact_counter']);
            });
    });

require __DIR__.'/auth.php';
