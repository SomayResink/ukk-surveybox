<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginField
{
    public function handle(Request $request, Closure $next)
    {
        $login = $request->input('login');

        if ($login) {
            $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nis';
            $request->merge([$field => $login]);
        }

        return $next($request);
    }
}
