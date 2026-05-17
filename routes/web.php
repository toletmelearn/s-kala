<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\ContactEnquiryController as AdminContactEnquiryController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\GalleryCategoryController as AdminGalleryCategoryController;
use App\Http\Controllers\Admin\GalleryItemController as AdminGalleryItemController;
use App\Http\Controllers\Admin\ProductCategoryController as AdminProductCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductEnquiryController as AdminProductEnquiryController;
use App\Http\Controllers\Admin\TraineeController as AdminTraineeController;
use App\Http\Controllers\Admin\TrainerController as AdminTrainerController;
use App\Http\Controllers\Admin\TrainingProgramController as AdminTrainingProgramController;
use App\Http\Controllers\Admin\Website\HomepageSectionController;
use App\Http\Controllers\Admin\Website\ImpactCounterController;
use App\Http\Controllers\Admin\Website\WebsiteController;
use App\Http\Controllers\Admin\Website\WebsiteSettingController;
use App\Http\Controllers\Frontend\GalleryEventController;
use App\Http\Controllers\Frontend\CertificateVerificationController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\JoinController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\TrainingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/join', [JoinController::class, 'create'])->name('join.create');
Route::post('/join', [JoinController::class, 'store'])->name('join.store');
Route::get('/join/thank-you', [JoinController::class, 'thankYou'])->name('join.thank-you');
Route::get('/training', [TrainingController::class, 'programs'])->name('training.index');
Route::get('/trainers', [TrainingController::class, 'trainers'])->name('training.trainers');
Route::get('/gallery', [GalleryEventController::class, 'gallery'])->name('gallery.index');
Route::get('/events', [GalleryEventController::class, 'events'])->name('events.index');
Route::get('/events/{slug}', [GalleryEventController::class, 'eventDetail'])->name('events.show');
Route::get('/products', [FrontendProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [FrontendProductController::class, 'show'])->name('products.show');
Route::post('/products/{slug}/enquiry', [FrontendProductController::class, 'enquiry'])->name('products.enquiry');
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/verify-certificate/{verification_code}', [CertificateVerificationController::class, 'show'])->name('certificates.verify');

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

        Route::middleware('can:programs.manage')->group(function () {
            Route::patch('/training-programs/{training_program}/toggle-status', [AdminTrainingProgramController::class, 'toggleStatus'])
                ->name('training-programs.toggle-status');
            Route::patch('/training-programs/{training_program}/toggle-featured', [AdminTrainingProgramController::class, 'toggleFeatured'])
                ->name('training-programs.toggle-featured');
            Route::resource('training-programs', AdminTrainingProgramController::class)
                ->except(['show'])
                ->parameters(['training-programs' => 'training_program']);
        });

        Route::middleware('can:trainers.manage')->group(function () {
            Route::patch('/trainers/{trainer}/toggle-status', [AdminTrainerController::class, 'toggleStatus'])
                ->name('trainers.toggle-status');
            Route::resource('trainers', AdminTrainerController::class)->except(['show']);
        });

        Route::middleware('can:trainees.manage')->group(function () {
            Route::resource('trainees', AdminTraineeController::class);
        });

        Route::middleware('can:gallery.manage')->group(function () {
            Route::patch('/gallery-categories/{gallery_category}/toggle-status', [AdminGalleryCategoryController::class, 'toggleStatus'])
                ->name('gallery-categories.toggle-status');
            Route::resource('gallery-categories', AdminGalleryCategoryController::class)
                ->except(['show'])
                ->parameters(['gallery-categories' => 'gallery_category']);

            Route::patch('/gallery/{gallery_item}/toggle-status', [AdminGalleryItemController::class, 'toggleStatus'])
                ->name('gallery.toggle-status');
            Route::patch('/gallery/{gallery_item}/toggle-featured', [AdminGalleryItemController::class, 'toggleFeatured'])
                ->name('gallery.toggle-featured');
            Route::resource('gallery', AdminGalleryItemController::class)
                ->except(['show'])
                ->parameters(['gallery' => 'gallery_item']);
        });

        Route::middleware('can:events.manage')->group(function () {
            Route::patch('/events/{event}/toggle-status', [AdminEventController::class, 'toggleStatus'])
                ->name('events.toggle-status');
            Route::patch('/events/{event}/toggle-featured', [AdminEventController::class, 'toggleFeatured'])
                ->name('events.toggle-featured');
            Route::resource('events', AdminEventController::class)->except(['show']);
        });

        Route::middleware('can:products.manage')->group(function () {
            Route::patch('/product-categories/{product_category}/toggle-status', [AdminProductCategoryController::class, 'toggleStatus'])
                ->name('product-categories.toggle-status');
            Route::resource('product-categories', AdminProductCategoryController::class)
                ->except(['show'])
                ->parameters(['product-categories' => 'product_category']);

            Route::patch('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])
                ->name('products.toggle-status');
            Route::patch('/products/{product}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])
                ->name('products.toggle-featured');
            Route::resource('products', AdminProductController::class)->except(['show']);

            Route::resource('product-enquiries', AdminProductEnquiryController::class)
                ->only(['index', 'show', 'update', 'destroy'])
                ->parameters(['product-enquiries' => 'product_enquiry']);
        });

        Route::middleware('can:enquiries.manage')->group(function () {
            Route::resource('enquiries', AdminContactEnquiryController::class)
                ->only(['index', 'show', 'update', 'destroy']);
        });

        Route::middleware('can:certificates.manage')->group(function () {
            Route::patch('/certificates/{certificate}/issue', [AdminCertificateController::class, 'issue'])->name('certificates.issue');
            Route::patch('/certificates/{certificate}/revoke', [AdminCertificateController::class, 'revoke'])->name('certificates.revoke');
            Route::get('/certificates/{certificate}/download', [AdminCertificateController::class, 'download'])->name('certificates.download');
            Route::resource('certificates', AdminCertificateController::class);
        });

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
