<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        // Calculate total revenue (example: sum of order amounts)
        $totalRevenue = Order::sum('total_amount');

        // Get total order count
        $totalOrders = Order::count();

        // Get total product count
        $totalProducts = Product::count();

        // Pass the data to the view
        return view('admin.dashboard', [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
        ]);
    }

    public function showPasswordRequests()
    {
        $passwordRequests = User::whereNotNull('password_reset_requested_at')->get();
        return view('admin.password_requests.index', compact('passwordRequests'));
    }

    public function approvePasswordRequest(User $user)
    {
        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);
        $user->update(['password_reset_requested_at' => null]);
        $resetLink = route('password.reset', $token) . '?email=' . urlencode($user->email);
        Mail::send('emails.password_reset_link', ['resetLink' => $resetLink, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email)->subject('Your Password Reset Link');
        });
        return response()->json(['success' => true, 'message' => 'Password reset request for ' . $user->name . ' approved. Link sent to user.']);
    }

    public function rejectPasswordRequest(User $user)
    {
        $user->update(['password_reset_requested_at' => null]);
        Mail::raw('Your password reset request has been rejected by the administrator.', $user->email);
        return response()->json(['success' => true, 'message' => 'Password reset request for ' . $user->name . ' rejected.']);
    }
}