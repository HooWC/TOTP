<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticatorRequest;
use App\Http\Resources\AuthenticatorResource;
use App\Models\Authenticator;
use Illuminate\Http\Request;
use OTPHP\TOTP;

class AuthenticatorController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'authenticator_id' => ['required', 'integer', 'exists:authenticators,id'],
            'code' => ['required', 'digits:6'],
        ]);
        $authenticator = Authenticator::find($request->authenticator_id);
        $this->authorize('verify', $authenticator);

        $verifyCode = str_pad(TOTP::create($authenticator->secret_key)->now(), 6, '0', STR_PAD_LEFT);
        $isCodeValid = $verifyCode === $request->code;
        return response()->json([
            'message' => $isCodeValid ? 'Verification successful' : 'Verification failed',
            'authenticator' => $isCodeValid,
        ]);
    }

    public function index(Request $request)
    {
        $this->authorize('view', Authenticator::class);

        $authenticators = $request->user()->authenticators;
        return AuthenticatorResource::collection($authenticators);
    }

    public function store(AuthenticatorRequest $request)
    {
        $this->authorize('create', Authenticator::class);

        $authenticator = new Authenticator($request->validated());
        $authenticator->user_id = $request->user()->id;
        $authenticator->save();
        return response()->json([
           'message' => 'Authenticator created successfully',
           'authenticator' => AuthenticatorResource::make($authenticator)
        ]);
    }

    public function update(Authenticator $authenticator, AuthenticatorRequest $request)
    {
        $this->authorize('update',$authenticator);

        $updateData = $request->only('account_name');
        $authenticator->update($updateData);
        return response()->json([
            'message' => 'Authenticator update successfully',
            'authenticator' =>  AuthenticatorResource::make($authenticator),
        ]);
    }

    public function destroy(Authenticator $authenticator, AuthenticatorRequest $request )
    {
        $this->authorize('delete', $authenticator);

        $authenticator->delete();
        return response()->json([
            'message' => 'Authenticator deleted successfully'
        ]);
    }

}
