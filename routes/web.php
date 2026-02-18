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
use App\Http\Controllers\ConferenceRegistrationController;
use App\Http\Controllers\ExhibitionRegistrationController;
use App\Http\Controllers\TermsController; 
use App\Http\Controllers\AdminRegistrationController; 

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/about', [MainController::class, 'about'])->name('about');
Route::get('/conference-theme', [MainController::class, 'conferenceTheme'])->name('conference.theme');
Route::get('/conference-procedure', [MainController::class, 'conferenceProcedure'])->name('conference.procedure');
Route::get('/submit-abstract', [MainController::class, 'submitAbstract'])->name('submit.abstract');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::post('/abstracts/submit', [AbstractSubmissionController::class, 'store'])->name('abstracts.store');

Route::get('/abstracts/success', fn () => view('main.success'))->name('abstracts.success');
Route::get('/full-papers/success', fn () => view('full-papers.success'))->name('fullpapers.success');
Route::get('/full-papers/{id}', [FullPaperController::class, 'create'])->name('full-papers.create');
Route::post('/full-papers/{id}', [FullPaperController::class, 'store'])->name('full-papers.store');


/*
|--------------------------------------------------------------------------
| REGISTRATION (PUBLIC)
|--------------------------------------------------------------------------
*/

Route::get('/conference/register', [ConferenceRegistrationController::class, 'showRegistrationForm'])
    ->name('conference.register.form');

Route::post('/conference/register', [ConferenceRegistrationController::class, 'store'])
    ->name('conference.register');

Route::get('/exhibition/register', [ExhibitionRegistrationController::class, 'showRegistrationForm'])
    ->name('exhibition.register.form');

Route::post('/exhibition/register', [ExhibitionRegistrationController::class, 'processRegistration'])
    ->name('exhibition.register');

Route::get('/exhibition/success', [ExhibitionRegistrationController::class, 'showSuccessPage'])
    ->name('exhibition.success');

Route::get('/terms', [TermsController::class, 'index'])->name('terms');

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| REVIEWER AUTH
|--------------------------------------------------------------------------
*/

Route::prefix('reviewer')->name('reviewer.')->group(function () {
    Route::get('/login', [ReviewerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ReviewerAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [ReviewerAuthController::class, 'logout'])->name('logout');

    Route::get('/change-password', [ReviewerAuthController::class, 'showChangePasswordForm'])
        ->name('password.change');
    Route::post('/change-password', [ReviewerAuthController::class, 'updatePassword'])
        ->name('password.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');

        // Abstracts
        Route::prefix('abstracts')->name('abstracts.')->group(function () {
            Route::get('/', [AdminController::class, 'abstracts'])->name('index');
            Route::post('/review', [AbstractsController::class, 'review'])->name('review');
        });

        // Full Papers
        Route::get('/fullpapers', [FullPaperController::class, 'index'])->name('fullpapers.index');

        Route::post('/users', [ReviewerDashboardController::class, 'store'])->name('users.store');


        // Reviewer Management
        Route::prefix('reviewers')->name('reviewers.')->group(function () {
            Route::get('/', [ReviewerDashboardController::class, 'index'])->name('index');
            Route::get('/create', [ReviewerDashboardController::class, 'create'])->name('create');
            Route::post('/', [ReviewerDashboardController::class, 'store'])->name('store');
            Route::get('/{id}', [ReviewerDashboardController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [ReviewerDashboardController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ReviewerDashboardController::class, 'update'])->name('update');
            Route::delete('/{id}', [ReviewerDashboardController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/reset-password', [ReviewerDashboardController::class, 'resetPassword'])->name('reset-password');
            Route::get('/workload/view', [ReviewerDashboardController::class, 'workload'])->name('workload');
        });

        // Conference Registrations
        Route::prefix('registrations')->name('registrations.')->group(function () {
            Route::get('/', [AdminRegistrationController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminRegistrationController::class, 'show'])->name('show');
            Route::post('/{id}/approve', [AdminRegistrationController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [AdminRegistrationController::class, 'reject'])->name('reject');
            Route::get('/{id}/download/{type}', [AdminRegistrationController::class, 'downloadProof'])->name('downloadProof');
        });

        // Exhibition Registrations
        Route::prefix('exhibitions')->name('exhibitions.')->group(function () {
            Route::get('/', [ExhibitionRegistrationController::class, 'index'])->name('index');
            Route::get('/{id}', [ExhibitionRegistrationController::class, 'show'])->name('show');
            Route::post('/{id}/approve', [ExhibitionRegistrationController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [ExhibitionRegistrationController::class, 'reject'])->name('reject');
            Route::get('/{id}/download-proof', [ExhibitionRegistrationController::class, 'downloadProof'])->name('downloadProof');
            Route::post('/{id}/resend-email', [ExhibitionRegistrationController::class, 'resendApprovalEmail'])->name('resend-email');
        });
});

/*
|--------------------------------------------------------------------------
| REVIEWER PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('reviewer')
    ->name('reviewer.')
    ->middleware(['auth', 'reviewer'])
    ->group(function () {

        Route::get('/dashboard', [ReviewerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/abstracts', [ReviewerAbstractController::class, 'index'])->name('abstracts.index');
        Route::post('/review', [AbstractsController::class, 'review'])->name('review');

        Route::get('/assignments', [ReviewerDashboardController::class, 'assignments'])->name('assignments.index');
        Route::get('/assignments/{id}', [ReviewerDashboardController::class, 'showAbstract'])->name('assignments.show');
        Route::post('/assignments/{id}/review', [ReviewerDashboardController::class, 'submitReview'])->name('assignments.review');

        Route::get('/profile', [ReviewerDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [ReviewerDashboardController::class, 'updateProfile'])->name('profile.update');

        Route::get('/pending-reviews', [ReviewsController::class, 'pendingReviews'])->name('pending-reviews');
        Route::get('/completed-reviews', [ReviewsController::class, 'completedReviews'])->name('completed-reviews');
        Route::post('/submit-review', [ReviewsController::class, 'submitReview'])->name('submit-review');
        Route::post('/start-review/{assignmentId}', [ReviewsController::class, 'startReview'])->name('start-review');

        Route::prefix('fullpapers')->name('fullpapers.')->group(function () {
            Route::get('/', [ReviewerFullPaperController::class, 'index'])->name('index');
            Route::get('/{id}', [ReviewerFullPaperController::class, 'show'])->name('show');
            Route::get('/{id}/download/{type}', [ReviewerFullPaperController::class, 'download'])->name('download');
            Route::get('/{id}/supplementary', [ReviewerFullPaperController::class, 'supplementary'])->name('supplementary');
        });
});

