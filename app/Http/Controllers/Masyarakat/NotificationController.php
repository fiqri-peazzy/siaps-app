<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mark all unread notifications as read.
     */
    public function readAll()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }
}
