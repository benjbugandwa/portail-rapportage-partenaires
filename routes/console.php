<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Rappel quotidien de rapportage des activités (Envoyé chaque jour entre 15h et 16h)
Schedule::command('app:send-daily-activity-reminder')->dailyAt('15:30');
