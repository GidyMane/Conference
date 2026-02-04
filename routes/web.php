<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AbstractSubmissionController;
use App\Http\Controllers\AbstractsController;
use App\Http\Controllers\FullPaperController;
use App\Http\Controllers\ReviewerAuthController;
use App\Http\Controllers\ReviewerAbstractController;
use App\Http\Controllers\ReviewerDashboardController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AbstractAssignmentController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ReviewerFullPaperController;

/* MainController Routes */

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/about', [MainController::class, 'about'])->name('about');
Route::get('/conference-theme', [MainController::class, 'conferenceTheme'])->name('conference.theme');
Route::get('/conference-procedure', [MainController::class, 'conferenceProcedure'])->name('conference.procedure');
Route::get('/submit-abstract', [MainController::class, 'submitAbstract'])->name('submit.abstract');



/* ContactController Routes */

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

/* AdminController Routes */

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard2', [AdminController::class, 'dashboard2'])->name('dashboard2');

/* AbstractSubmissionController Routes */

Route::post('/abstracts/submit', [AbstractSubmissionController::class, 'store'])->name('abstracts.store');

/* AbstractsController Routes */

Route::post('/abstracts/review', [AbstractsController::class, 'review'])->name('abstracts.review');
   // ->middleware('auth');

/* FullPaperController Routes */
Route::get('/admin/fullpapers', [FullPaperController::class, 'index'])->name('fullpapers.index');
Route::get('/full-papers/{abstract}',[FullPaperController::class, 'create'])->name('full-papers.create');

Route::post('/full-papers/{abstract}',[FullPaperController::class, 'store'])->name('full-papers.store');

// Reviewer Authentication Routes (for login & password setup)
Route::prefix('reviewer')->name('reviewer.')->group(function () {
    Route::get('/login', [ReviewerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ReviewerAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [ReviewerAuthController::class, 'logout'])->name('logout');

    // 🔐 Password change (first login)
    Route::get('/change-password', [ReviewerAuthController::class, 'showChangePasswordForm'])
        ->name('password.change');
    Route::post('/change-password', [ReviewerAuthController::class, 'updatePassword'])
        ->name('password.update');
});

// Protected Reviewer Routes (require login)
Route::prefix('reviewer')->name('reviewer.')->middleware('web', 'auth', 'reviewer')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [ReviewerDashboardController::class, 'index'])->name('dashboard');
    
    // Assignments
    Route::get('/assignments', [ReviewerDashboardController::class, 'assignments'])->name('assignments.index');
    Route::get('/assignments/{id}', [ReviewerDashboardController::class, 'showAbstract'])->name('assignments.show');
    Route::post('/assignments/{id}/review', [ReviewerDashboardController::class, 'submitReview'])->name('assignments.review');
    
    // Profile
    Route::get('/profile', [ReviewerDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [ReviewerDashboardController::class, 'updateProfile'])->name('profile.update');

    Route::get('/abstracts', [ReviewerAbstractController::class, 'index'])->name('abstracts.index');
});

// Admin Authentication Route
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::prefix('users')->group(function () {
        Route::post('{id}/reset-password', [
            ReviewerDashboardController::class,
            'resetPassword'
        ])->name('users.reset-password');
    });

// Protected Admin Routes (require login)
Route::prefix('admin')->name('admin.')->middleware('web', 'auth', 'admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');

    Route::post('/users', [ReviewerDashboardController::class, 'store'])
        ->name('users.store');

    // Fetch available abstracts for a reviewer
    Route::get('/users/{reviewer}/available-abstracts', [AbstractAssignmentController::class, 'availableAbstracts'])
        ->name('users.available-abstracts');

    // Assign abstracts to a reviewer
    Route::post('/users/assign-abstracts', [AbstractAssignmentController::class, 'assign'])
        ->name('users.assign-abstracts');
    
    // Abstracts Management
    Route::prefix('abstracts')->name('abstracts.')->group(function () {
        Route::get('/', [AdminController::class, 'abstracts'])->name('index');
    });

    Route::prefix('users')->group(function () {
        Route::post('{id}/reset-password', [
            ReviewerDashboardController::class,
            'resetPassword'
        ])->name('users.reset-password');
    });
        // Reviewers Management
    Route::prefix('reviewers')->name('reviewers.')->group(function () {
        Route::get('/', [ReviewerdashboardController::class, 'index'])->name('index');
        Route::get('/create', [ReviewerdashboardController::class, 'create'])->name('create');
        Route::post('/', [ReviewerdashboardController::class, 'store'])->name('store');
        Route::get('/{id}', [ReviewerdashboardController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ReviewerdashboardController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ReviewerdashboardController::class, 'update'])->name('update');
        Route::delete('/{id}', [ReviewerdashboardController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/reset-password', [ReviewerdashboardController::class, 'resetPassword'])->name('reset-password');
        Route::get('/workload/view', [ReviewerdashboardController::class, 'workload'])->name('workload');
    });
    
    
});








// Reviewer Routes
Route::prefix('reviewer')->name('reviewer.')->middleware('auth')->group(function () {
    
    // Pending Reviews
    Route::get('/pending-reviews', [ReviewsController::class, 'pendingReviews'])->name('pending-reviews');
    
    // Completed Reviews
    Route::get('/completed-reviews', [ReviewsController::class, 'completedReviews'])->name('completed-reviews');
    
    // Submit Review
    Route::post('/submit-review', [ReviewsController::class, 'submitReview'])->name('submit-review');
    
    // Start Review (AJAX)
    Route::post('/start-review/{assignmentId}', [ReviewsController::class, 'startReview'])->name('start-review');
    
    // Full Papers
    Route::prefix('fullpapers')->name('fullpapers.')->group(function () {
        Route::get('/', [ReviewerFullpaperController::class, 'index'])->name('index');
        Route::get('/{id}', [ReviewerFullPapersController::class, 'show'])->name('show');
        Route::get('/{id}/download/{type}', [ReviewerFullPapersController::class, 'download'])->name('download');
        Route::get('/{id}/supplementary', [ReviewerFullPapersController::class, 'supplementary'])->name('supplementary');
    });
});

    