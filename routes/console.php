<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:booking-type-wise-save-into-expenditure')->daily();


Schedule::command('app:test-comd')->everyFiveSeconds();
// $schedule->command('app:booking-type-wise-save-into-expenditure')
//     ->everyFiveSeconds()
//     ->appendOutputTo(storage_path('logs/booking-type-wise-save-into-expenditure.log'));
// ->daily();



