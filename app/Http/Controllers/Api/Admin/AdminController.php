<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function isDisabledUser(Request $request)
    {
        $selectedValue = $request->input('accountid');

        $user = User::find($selectedValue);
        $user->update([
            'is_disabled' => !$user->is_disabled,
        ]);

        return response()->json([
            'message' => "disabled update success"
        ]);
    }

}
