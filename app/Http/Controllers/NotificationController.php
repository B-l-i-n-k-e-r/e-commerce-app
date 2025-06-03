<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return response()->json(Auth::user()->notifications()->latest()->get());
        }
        return response()->json([]);
    }

    public function unreadCount()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return response()->json(['count' => Auth::user()->unreadNotifications()->count()]);
        }
        return response()->json(['count' => 0]);
    }

    public function markAsRead(Request $request)
    {
        if (Auth::check() && Auth::user()->is_admin) {
            Auth::user()->unreadNotifications->markAsRead();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 403);
    }
}