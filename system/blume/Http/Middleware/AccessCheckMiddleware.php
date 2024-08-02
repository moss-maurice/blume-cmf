<?php

namespace Blume\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AccessCheckMiddleware
{
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if (!Auth::check()) {
            dd('aaaa1');

            //return redirect('web.home');
        }

        if (!$request->user()->hasRole($role)) {
            abort(403);
        }

        if (!is_null($permission) and !$request->user()->can($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
