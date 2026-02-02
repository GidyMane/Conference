<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AbstractSubmissionController;

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

/* AbstractSubmissionController Routes */

Route::post('/abstracts/submit', [AbstractSubmissionController::class, 'store'])->name('abstracts.store');
