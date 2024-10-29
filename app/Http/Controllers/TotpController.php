<?php

namespace App\Http\Controllers;

use App\Models\Authenticator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TotpController extends Controller
{
    public function addTotp(Request $request)
    {
        $request->validate([
            'account_name' => 'required',
            'secret_key' => 'required'
        ]);

        Authenticator::create([
            'account_name' => $request->account_name,
            'secret_key' => $request->secret_key,
            'user_id' => Auth::id()
        ]);

        return redirect(route('account.totp'));
    }

    public function editAccountName(Request $request){
        $authenticator = Authenticator::find($request->authenticator_id);
        $updateData = $request->only('account_name');
        $authenticator->update($updateData);

        return redirect(route('account.totp'));
    }

}
