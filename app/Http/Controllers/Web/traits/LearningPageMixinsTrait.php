<?php

namespace App\Http\Controllers\Web\traits;

use App\Models\Webinar;
use Illuminate\Support\Facades\Request;

trait LearningPageMixinsTrait
{
    public function getCourse($slug, $user = null, $relation = null, $relationWith = null)
    {
 
        if (empty($user)) {
            $user = auth()->user();
        }

        $query = Webinar::where('slug', $slug)
            ->where('status', 'active');

        if (!empty($relation)) {
            $query->with([
                "{$relation}" => function ($query) use ($relation, $relationWith) {
                    if ($relation == 'forums') {
                        $query->orderBy('pin', 'desc');
                    }

                    $query->orderBy('created_at', 'desc');

                    if (!empty($relationWith)) {
                        $query->with($relationWith);
                    }
                }
            ])->withCount([
                "{$relation}"
            ]);
        }

        $course = $query->first();

        if (!empty($course)) {
            $isPrivate = $course->private;
            if (!empty($user) and ($user->id == $course->creator_id or $user->organ_id == $course->creator_id or $user->isAdmin())) {
                $isPrivate = false;
            }

            if ($isPrivate) {
                return 'not_access';
            }

            return $course;
        }

        return 'not_access';
    }
}
