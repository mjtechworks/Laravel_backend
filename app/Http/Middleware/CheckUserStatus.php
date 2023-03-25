<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && !$request->user()->isActive()) {
            auth()->logout();
            return redirect(route('backend.auth.login.form'));
        }
        return $next($request);
    }
}
