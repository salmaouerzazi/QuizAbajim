<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UpdateLastSeen
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $lastSeen = session('last_seen_at', null);
            $currentTime = Carbon::now('Africa/Tunis');

            if (!$lastSeen || Carbon::parse($lastSeen)->diffInMinutes($currentTime) >= 5) {
                $user->update(['last_seen_at' => $currentTime]);
                session(['last_seen_at' => $currentTime]);
            }
        }

        return $next($request);
    }
}
