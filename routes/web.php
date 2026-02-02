<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ContactController;

/* MainController Routes */

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/about', [MainController::class, 'about'])->name('about');
Route::get('/conference-theme', [MainController::class, 'conferenceTheme'])->name('conference.theme');
Route::get('/conference-procedure', [MainController::class, 'conferenceProcedure'])->name('conference.procedure');
Route::get('/submit-abstract', [MainController::class, 'submitAbstract'])->name('submit.abstract');

/* ContactController Routes */

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
