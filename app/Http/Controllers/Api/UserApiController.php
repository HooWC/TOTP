<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class UserApiController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(UserRequest $request)
    {
        User::create($request->all());
        return true;
    }

    public function show(string $id)
    {
        $data = User::find($id);
        if ($data) {
            return $data;
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }
    }

    public function update(UserRequest $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $updateData = $request->only('name', 'email');
        return $user->update($updateData);
    }

    public function destroy(UserRequest $request)
    {
        // 禁止使用 delete function
        // 只有让用户 block account 而已
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        return $user->delete();
    }
}
