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
use App\Http\Controllers\FullPaperReviewController;
use App\Http\Controllers\PresentationUploadController;

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

        Route::post('/temp-reviewers', [ReviewerAuthController::class, 'storeTempReviewer'])
        ->name('temp-reviewers.store');

        // Full Papers
        Route::get('/fullpapers', [FullPaperController::class, 'index'])->name('fullpapers.index');
        Route::get('/fullpapers/completed', [FullPaperReviewController::class, 'adminCompletedReviews'])->name('fullpapers.completed');
        
        Route::get('/fullpapers/{id}/all-reviews', [FullPaperReviewController::class, 'adminAllReviews'])->name('fullpapers.all-reviews');
        Route::get('/fullpapers/{id}/materials',   [PresentationUploadController::class, 'adminViewMaterials'])->name('fullpapers.materials');
        
           // View presentation materials
        
        Route::post('/users', [ReviewerDashboardController::class, 'store'])->name('users.store');
                // Users Management 
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [ReviewerDashboardController::class, 'index'])->name('index');
            Route::post('/', [ReviewerDashboardController::class, 'store'])->name('store');
            Route::get('/{id}', [ReviewerDashboardController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [ReviewerDashboardController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ReviewerDashboardController::class, 'update'])->name('update');
            Route::delete('/{id}', [ReviewerDashboardController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/reset-password', [ReviewerDashboardController::class, 'resetPassword'])->name('reset-password');
        });

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

         
    // View presentation materials
    Route::get('/fullpapers/{id}/materials',
        [PresentationUploadController::class, 'viewMaterials']
    )->name('fullpapers.materials');


        
});




// Reviewer/Sub-Theme Leader Routes (NO AUTH)
Route::prefix('reviewer')->middleware(['auth','reviewer'])->group(function () {

    Route::get('/fullpapers-review', 
    [FullPaperReviewController::class, 'index']
)->name('reviewer.fullpapers.index');

    Route::get('/fullpapers/{id}/assign', 
    [FullPaperReviewController::class, 'showAssignForm']
)->name('reviewer.fullpapers.assign');
    //Route::get('/fullpapers/{id}/reviews', function ($id) {
        //return view('reviewer.fullpapers-decision', ['paperId' => $id]);
   // });

    Route::get('/fullpapers/{id}/reviews', [FullPaperReviewController::class, 'showFullPaperReviews'])
     ->name('reviewer.fullpapers.show-reviews');

    Route::get('/fullpapers/{id}/decision',
        [FullPaperReviewController::class, 'allReviews']
    )->name('reviewer.fullpapers.decision');

    // Fully Reviewed Papers — all 3 reviews complete, awaiting leader decision
    Route::get('/fullpapers-completed',
        [FullPaperReviewController::class, 'completedReviews']
    )->name('reviewer.fullpapers.completed');

    Route::get('/fullpapers/{id}/all-reviews',
        [FullPaperReviewController::class, 'allReviews']
    )->name('reviewer.fullpapers.all-reviews');

    Route::post('/fullpapers/{id}/final-decision',
        [FullPaperReviewController::class, 'submitFinalDecision']
    )->name('reviewer.fullpapers.final-decision');

});

// Admin Routes (NO AUTH)
Route::prefix('admin')->group(function () {

    Route::get('/fullpapers/assignment', function () {
        return view('admin.fullpapers.assignment');
    });

    Route::get('/fullpapers/{id}/assign', function ($id) {
        return view('reviewer.fullpapers-assign', ['paperId' => $id]);
    });

});



// Public Review Routes

Route::get('/review/success', function () {
    return view('reviewer.review.success'); // Path: resources/views/reviews/success.blade.php
})->name('reviewer.review.success');


Route::get('/review/{token}', function ($token) {

    $assignment = \App\Models\ReviewAssignment::where('review_token', $token)
        ->with(['fullPaper.abstract'])
        ->firstOrFail();

    return view('public.review-form', compact('assignment'));
});

Route::post(
    '/reviewer/fullpapers/{id}/assign',
    [FullPaperReviewController::class, 'assignReviewers']
)->name('reviewer.fullpapers.assign.submit');

Route::post('/reviewer/fullpapers/{paper}/submit-review', 
    [FullPaperReviewController::class, 'submitReview']
)->name('reviewer.fullpapers.submit-review');

Route::post('/review/{assignment}', 
    [FullPaperReviewController::class, 'submitReview']
)->name('review.submit');

//Route::get('/presentation-upload', function() {
//    return view('powerpoint.presentation-upload');
//});

//Route::get('/presentation-success', function() {
//    return view('powerpoint.presentation-upload-success');
//});

Route::prefix('presentation')->group(function () {

    Route::get('/upload/{paper}',
        [PresentationUploadController::class, 'showUploadForm']
    )->name('fullpaper.presentation.upload');

    Route::post('/upload/{paper}',
        [PresentationUploadController::class, 'upload']
    )->name('fullpaper.presentation.submit');

    Route::get('/success/{paper}',
        [PresentationUploadController::class, 'success']
    )->name('presentation.success');

});


Route::get('/test/admin-materials', function() {
    return view('admin.fullpapers.materials');
});

Route::get('/test/reviewer-materials', function() {
    return view('reviewer.presentation-materials');
});

Route::get('/login', function () {
    return redirect()->route('reviewer.login');
})->name('login');