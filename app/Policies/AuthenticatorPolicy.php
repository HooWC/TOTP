<?php

namespace App\Policies;

use App\Models\Authenticator;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AuthenticatorPolicy
{
    public function verify(User $user, Authenticator $authenticators)
    {
        if ($user->id === $authenticators->user_id)
            return Response::allow();
        else
            return Response::deny("You are not allowed to perform this operation");
    }

    public function view(User $user)
    {
        if ($user->roles->contains('name', 'account'))
            return Response::allow();
        else
            return Response::deny("You are not allow to view");
    }

    public function create(User $user)
    {
        if ($user->roles->contains('name', 'account'))
            return Response::allow();
        else
            return Response::deny("You are not allow to create");
    }

    public function update(User $user, Authenticator $authenticators)
    {
        if ($user->id === $authenticators->user_id)
            return Response::allow();
        else
            return Response::deny("You are not allow to update");
    }

    public function delete(User $user, Authenticator $authenticators)
    {
        if ($user->id === $authenticators->user_id)
            return Response::allow();
        else
            return Response::deny("You are not allow to delete");
    }

}
