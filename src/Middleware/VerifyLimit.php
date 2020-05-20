<?php

namespace Den1n\ConcurrentSessions\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class VerifyLimit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if ($user = $request->user() and $limit = $user->sessions_limit) {
            $sessions = $user->sessions;

            while (count($sessions) > $limit)
                Session::getHandler()->destroy(array_shift($sessions));

            $user->sessions = $sessions;
            $user->save();

            if (!in_array(Session::getId(), $user->sessions)) {
                auth()->logout();
                throw new AuthenticationException;
            }
        }

        return $next($request);
    }
}
