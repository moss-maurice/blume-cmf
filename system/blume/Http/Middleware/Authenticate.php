<?php

namespace Blume\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
-
        dd('Нужно написать набор мидлверов для API-слоя');
        return $request->expectsJson() ? null : route('web.home');
    }
}
