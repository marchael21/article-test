<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Admin
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
        // check if user logged in
        if (Auth::user()) {
            // check if user is admin
            if (Auth::user()->role_id !== 1) {
                abort(403, 'Unauthorized action.'); 
            }

            return $next($request);
        }

        return redirect('/');
    }
}
