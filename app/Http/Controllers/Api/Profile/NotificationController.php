<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        $notifications = $user->notifications()->get()->each(function ($notification) {
            $notification->formatted_created_at = $notification->created_at->format('d.m.Y');
        });
        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return $notifications;
    }
    public function unread()
    {
        $user = \Auth::user();
        $notifications = $user->unreadNotifications()->get();
        return $notifications;
    }

    public function read()
    {
        $user = \Auth::user();
        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
    }
}
