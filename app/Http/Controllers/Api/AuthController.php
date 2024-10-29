<?php

namespace App\Http\Controllers\Api;

use App\Events\Register;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'login_date' => now()
        ]);

        $role = Role::where('name', 'account')->first();

        RoleUser::create([
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);

        Register::dispatch($user);

        return response([
            'message' => 'Registration successful',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $loginData = $request->only('email', 'password');

        if (Auth::attempt($loginData)) {
            $user = User::where('email', $request->email)->first();
            $tokenResult = $user->createToken('auth_token');
            $token = $tokenResult->accessToken;

            return response([
                'message' => 'Login successfully',
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        return response([
            'message' => 'Login failed. Please verify your email and password'
        ], 401);
    }

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => trans($status)
            ], 200);
        } else {
            return response()->json([
                'message' => trans($status)
            ], 422);
        }
    }

    public function verifyEmail(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::find($userId);

        if ($user && $user->email_verified_at === null) {
            $user->email_verified_at = now();
            $user->save();
        }

        return view('emails.register', ['user' => $user]);
    }

}
