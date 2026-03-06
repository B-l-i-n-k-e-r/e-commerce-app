<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.users.create')->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
            'is_manager' => false,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.users.index')->with('error', 'User not found.');
        }
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.users.index')->with('error', 'User not found.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.users.edit', $id)->withErrors($validator)->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Prevent deleting yourself
            if ($user->id === auth()->id()) {
                return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own administrative account.');
            }

            if ($user->orders()->count() > 0) {
                return redirect()->route('admin.users.index')->with('error', 'Cannot delete user. There are orders associated with this user.');
            }

            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.users.index')->with('error', 'User not found.');
        }
    }

    public function verifyEmail(User $user)
    {
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return redirect()->route('admin.users.index')->with('success', 'User email verified successfully.');
        }

        return redirect()->route('admin.users.index')->with('info', 'User email is already verified.');
    }

    /**
     * Promote to Administrator
     * Matches route: admin.users.makeAdmin
     */
    public function promoteToAdmin(User $user)
    {
        $user->update([
            'is_admin' => true,
            'is_manager' => true, // Admins inherit manager permissions
        ]);

        return back()->with('success', "Personnel {$user->name} has been promoted to Administrator.");
    }

    /**
     * Toggle Manager Role
     */
    public function toggleManager(User $user)
    {
        if ($user->is_admin) {
            return redirect()->back()->with('error', 'Cannot downgrade an Admin via the Manager toggle.');
        }

        $user->is_manager = !$user->is_manager;
        $user->save();

        $roleStatus = $user->is_manager ? 'promoted to Manager' : 'reverted to User';
        return redirect()->back()->with('success', "User {$user->name} has been {$roleStatus}.");
    }
}