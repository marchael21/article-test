<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class User
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
            // check if user is employee
            if (Auth::user()->role_id !== 2) {
                abort(403, 'Unauthorized action.'); 
            }

            return $next($request);
        }

        return redirect('/');
    }
}
