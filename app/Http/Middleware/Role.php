<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if(auth()->check() && auth()->user()->hasAnyRole(...$roles)){
            return $next($request);
        } else {
            return redirect()->route('login');
        }
    }
}
