<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        return view('components.content.home');
    }

    public function users(Request $request)
    {
        $users = User::with('roles')->get();
        if ($request->filled('role')) {
            $usersWithRoles = $users->filter(function ($user) use ($request) {
                return $user->roles->contains('name', $request->role);
            });
            return view('components.content.admin', ['users' => $usersWithRoles, 'role' => $request->role]);
        }

        return view('components.content.admin', ['users' => $users, 'role' => 'all']);
    }

    public function totp()
    {
        return view('components.content.account');
    }

}
