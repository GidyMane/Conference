<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

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
Route::get('/abstracts', [AdminController::class, 'abstracts'])->name('abstracts');
Route::get('/abstracts/abstracts2', [AdminController::class, 'abstracts2'])->name('abstracts2');




//GDY
// Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Abstracts
    Route::resource('abstracts', AbstractController::class);
    Route::post('abstracts/{id}/assign-reviewer', [AbstractController::class, 'assignReviewer'])->name('abstracts.assign-reviewer');
    Route::post('abstracts/{id}/status', [AbstractController::class, 'changeStatus']);
    Route::post('abstracts/{id}/approve', [AbstractController::class, 'approve']);
    Route::post('abstracts/{id}/reject', [AbstractController::class, 'reject']);
    Route::get('abstracts/export', [AbstractController::class, 'export'])->name('abstracts.export');
    
    // Full Papers
    Route::resource('fullpapers', FullPaperController::class);
    Route::get('fullpapers/{id}/supplementary', [FullPaperController::class, 'supplementary']);
    Route::post('fullpapers/{id}/accept', [FullPaperController::class, 'accept']);
    Route::post('fullpapers/{id}/reject', [FullPaperController::class, 'reject']);
    Route::get('fullpapers/export', [FullPaperController::class, 'export'])->name('fullpapers.export');
    
    // Registrations
    Route::resource('registrations', RegistrationController::class);
    Route::post('registrations/{id}/send-confirmation', [RegistrationController::class, 'sendConfirmation']);
    Route::post('registrations/{id}/confirm-payment', [RegistrationController::class, 'confirmPayment']);
    Route::get('registrations/{id}/badge', [RegistrationController::class, 'generateBadge']);
    Route::post('registrations/send-invitations', [RegistrationController::class, 'sendInvitations'])->name('registrations.send-invitations');
    Route::get('registrations/export', [RegistrationController::class, 'export'])->name('registrations.export');
    
    // Exhibitions
    Route::resource('exhibitions', ExhibitionController::class);
    Route::post('exhibitions/{id}/confirm', [ExhibitionController::class, 'confirm']);
    Route::post('exhibitions/{id}/assign-booth', [ExhibitionController::class, 'assignBooth']);
    Route::get('exhibitions/floor-plan', [ExhibitionController::class, 'floorPlan']);
    Route::get('exhibitions/export', [ExhibitionController::class, 'export'])->name('exhibitions.export');
    
    // Users
    Route::resource('users', UserController::class);
    Route::get('users/{id}/available-abstracts', [UserController::class, 'availableAbstracts']);
    Route::post('users/{id}/reset-password', [UserController::class, 'resetPassword']);
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');

    //GDE

