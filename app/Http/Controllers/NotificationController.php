<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @group Notification
 */
class NotificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $notifications = auth()->user()->notifications;

        return $notifications;
    }
}
