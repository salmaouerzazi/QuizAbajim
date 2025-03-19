<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use App\Models\Manuels;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckLevelPermission
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
        $user = Auth::user(); // Get logged-in user
        $manual = Manuels::with('matiere.section.level')->find($request->id); // Fetch manual

        if (!$manual) {
            abort(404, 'Manual not found.');
        }

        // Check if user level matches manual level
        if ($user->level_id !== $manual->matiere->section->level->id) {
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}
