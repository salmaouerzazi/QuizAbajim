<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if (Auth::guard($guard)->check()) {
        //     return redirect(RouteServiceProvider::HOME);
        // }

        // return $next($request);
        if (Auth::guard($guard)->check()) {
            // Check the role of the authenticated user
            $user = Auth::guard($guard)->user();

            if ($user->isTeacher()) {
                // Redirect to /panel if the user is a teacher
                return redirect('/panel');
            } elseif ($user->isOrganization()) {
                // Redirect to /panel/enfant if the user is part of an organization
                return redirect('/panel/enfant');
            }
            elseif ($user->isEnfant()) {
                // Redirect to /panel/enfant if the user is part of an organization
                return redirect('/panel/enfant');
            }
        }

        // If not authenticated, continue to th e next middleware or the requested route
        return $next($request);
    }
}
