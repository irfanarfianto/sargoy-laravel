<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\SystemAnnouncement;
use App\Events\SystemAlert;

class NotificationController extends Controller
{

    public function index()
    {
        return view('dashboard.notifications.index');
    }
    public function sendAnnouncement()
    {
        $announcement = 'There will be a scheduled maintenance on Sunday at 2 AM.';
        event(new SystemAnnouncement($announcement));

        return response()->json(['message' => 'Announcement sent successfully!']);
    }

    public function sendAlert()
    {
        $alert = 'There is an issue with the payment gateway. Please check immediately.';
        event(new SystemAlert($alert));

        return response()->json(['message' => 'Alert sent successfully!']);
    }
}
