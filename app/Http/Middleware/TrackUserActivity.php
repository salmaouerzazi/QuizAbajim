<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        
        if (Auth::check()) {
            Auth::user()->update(['last_seen_at' => Carbon::now()]);

            $lastUpdate = session('last_activity_update', Carbon::now('Africa/Tunis'));

            $minutesSpent = Carbon::parse($lastUpdate)->diffInMinutes(Carbon::now('Africa/Tunis'));
            if ($minutesSpent > 0) {
                Auth::user()->increment('online_time', $minutesSpent);
                session(['last_activity_update' => Carbon::now('Africa/Tunis')]);
            }
        }

        return $next($request);
    }
}