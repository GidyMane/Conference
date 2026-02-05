<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| Here is where you can define all of your Closure based console commands.
| You may also define scheduled tasks here using the $schedule variable.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule your review reminder command
$schedule = app(Schedule::class);

$schedule->command('app:send-review-reminders')->dailyAt('19:07');