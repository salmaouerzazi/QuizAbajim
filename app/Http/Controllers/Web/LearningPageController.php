<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\traits\LearningPageAssignmentTrait;
use App\Http\Controllers\Web\traits\LearningPageForumTrait;
use App\Http\Controllers\Web\traits\LearningPageItemInfoTrait;
use App\Http\Controllers\Web\traits\LearningPageMixinsTrait;
use App\Http\Controllers\Web\traits\LearningPageNoticeboardsTrait;
use App\Models\CourseNoticeboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LearningPageController extends Controller
{
    use LearningPageMixinsTrait, LearningPageAssignmentTrait, LearningPageItemInfoTrait,
        LearningPageNoticeboardsTrait, LearningPageForumTrait;

    public function index(Request $request, $slug)
    {
        $requestData = $request->all();

        $webinarController = new WebinarController();

        $data = $webinarController->course($slug, true);

        $authUserIsFollower = false;
        $course= $data['course'];

        if (auth()->check()) {
            $authUserIsFollower = DB::table('teachers')
            ->where('users_id', auth()->id())->where('teacher_id', $course->teacher->id)->exists();
        }


        if (is_array($data)) {
            $course = $data['course'];
            $user = $data['user'];
            $data['authUserIsFollower'] = $authUserIsFollower;

        } else {
            return redirect()->back()->withErrors(['error' => 'Invalid course data.']);
        }
        
        if ($course->creator_id != $user->id and $course->teacher_id != $user->id and !$user->isAdmin()) {
            $unReadCourseNoticeboards = CourseNoticeboard::where('webinar_id', $course->id)
                ->whereDoesntHave('noticeboardStatus', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->count();

            if ($unReadCourseNoticeboards) {
                $url = $course->getNoticeboardsPageUrl();
                return redirect($url);
            }
        }

        return view('web.default.course.learningPage.index', $data);
    }
}
