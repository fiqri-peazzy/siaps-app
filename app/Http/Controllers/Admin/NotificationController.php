<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function read($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        
        $notification->markAsRead();
        
        // As per user request: "kalo sdah banyak di hapus aja notif nya"
        // Let's delete the notification after it's clicked to keep the table clean
        $actionUrl = $notification->data['action_url'] ?? route('admin.dashboard');
        
        $notification->delete();

        return redirect($actionUrl);
    }
}
