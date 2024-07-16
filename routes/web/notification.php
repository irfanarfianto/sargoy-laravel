<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::get('/send-announcement', [NotificationController::class, 'sendAnnouncement']);
Route::get('/send-alert', [NotificationController::class, 'sendAlert']);
