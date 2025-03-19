<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherInfosRequest;
use App\Mixins\RegistrationPackage\UserPackage;
use App\Models\BecomeInstructor;
use App\Models\Category;
use App\Models\RegistrationPackage;
use App\Models\Role;
use App\Models\School_level;
use App\Models\UserOccupation;
use App\Models\Material;
use App\Models\Option;
use App\Models\UserLevel;
use App\UserMatiere;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class BecomeInstructorController extends Controller
{
    /*
     * function to display the second step of the registration process for the teacher
     * @return view
     */

    public final function indexteacher() : View

    {
        $user = auth()->user();

        if ($user->isTeacher()) {
            $levelIds = [6, 7, 8, 9, 10, 11];
            $levels = School_level::whereIn('id', $levelIds)->with(['sectionsmat.materials'])->get();
            $lastRequest = BecomeInstructor::where('user_id', $user->id)
                ->where('status', 'pending')
                ->first();
            $isOrganizationRole = (!empty($lastRequest) and $lastRequest->role == Role::$organization);
            $isInstructorRole = (empty($lastRequest) or $lastRequest->role == Role::$teacher);

            $customOrder = [
                'رياضيات' => 0,
                'العربية' => 1,
                'الإيقاظ العلمي' => 2,
                'الفرنسية' => 3,
                'المواد الاجتماعية' => 4,
                'الإنجليزية' => 5
            ];

            foreach ($levels as $level) {
                foreach ($level->sectionsmat as $sectionMat) {
                    $sectionMat->uniqueMaterials = $sectionMat->materials
                        ->unique('name')
                        ->sortBy(function ($material) use ($customOrder) {
                            return $customOrder[$material->name] ?? PHP_INT_MAX;
                        })
                        ->values()
                        ->all();
                }
            }


            $data = [
                'pageTitle' => trans('site.become_instructor'),
                'levels' => $levels,
                'user' => $user,
                'lastRequest' => $lastRequest,
                'isOrganizationRole' => $isOrganizationRole,
                'isInstructorRole' => $isInstructorRole,
            ];
            return view('web.default.user.become_instructor.indexteacher', $data);
        }
        abort(404);
    }

    /**
     * Store the second step of the registration process for the teacher.
     *
     * @param StoreTeacherInfosRequest $request
     * @return RedirectResponse
     */
    public final function store(StoreTeacherInfosRequest $request) : RedirectResponse
    {
        $user = auth()->user();
        if ($user->isTeacher()) {
            $lastRequest = BecomeInstructor::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'accept'])
                ->first();
            $data = $request->validated();
            BecomeInstructor::create([
                'user_id' => $user->id,
                'created_at' => time()
            ]);

            $materials = $data['materials'] ?? [];
            $levels = $data['levels'] ?? [];

            if (!empty($materials) && !empty($levels)) {
                UserMatiere::where('teacher_id', $user->id)->delete();

                foreach ($materials as $materialId) {
                    $material = Material::find($materialId);

                    if ($material && School_level::find($material->section->level_id)) {
                        UserMatiere::create([
                            'teacher_id' => $user->id,
                            'matiere_id' => $materialId,
                            'level_id' => $material->section->level_id,
                            'created_at' => time()
                        ]);
                    }
                }
            }

            $user->update([
                'matier_id' => 7,
            ]);

            if ((!empty(getRegistrationPackagesGeneralSettings('show_packages_during_registration')) && getRegistrationPackagesGeneralSettings('show_packages_during_registration'))) {
                return redirect(route('becomeInstructorPackages'));
            }

            $toastData = [
                'title' => trans('public.request_success'),
                'msg' => trans('site.become_instructor_success_request'),
                'status' => 'success'
            ];

            return redirect('/panel')->with(['toast' => $toastData]);
        }

        abort(404);
    }

    public function storeSetting (Request $request)
    {
        $user = auth()->user();
        if ($user->isTeacher()) {
            $lastRequest = BecomeInstructor::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'accept'])
                ->first();
                $this->validate($request, [
                    'occupations' => [
                        function ($attribute, $value, $fail) use ($request) {
                            if (empty($value) && empty($request->input('occupations'))) {
                                $fail('The occupations or occupationsoption is required.');
                            }
                        },
                    ],
                    'occupationsll' => [
                        function ($attribute, $value, $fail) use ($request) {
                            if (empty($value) && empty($request->input('occupationsll'))) {
                                $fail('The occupations or occupationsoption is required.');
                            }
                        },
                    ],
                ]);

                $data = $request->all();
                \Log::info($request->all());

                BecomeInstructor::create([
                    'user_id' => $user->id,
                    'created_at' => time()
                ]);

                if (!empty($data['occupations'])) {
                    UserMatiere::where('teacher_id', $user->id)->delete();
                
                    foreach ($data['occupations'] as $level_id => $material_ids) {
                        foreach ($material_ids as $matiereid) {
                            UserMatiere::create([
                                'teacher_id' => $user->id,
                                'matiere_id' => $matiereid,
                                'level_id' => $level_id,
                                'created_at' => time()
                            ]);
                        }
                    }
                }
                if (!empty($data['occupationsll'])) {
                    UserLevel::where('teacher_id', $user->id)->delete();

                    foreach ($data['occupationsll'] as $levelid) {
                        UserLevel::create([
                            'teacher_id' => $user->id,
                            'level_id' => $levelid,
                            'created_at' => time()
                        ]);

                    }
                }

                $user->update([
                    'matier_id' => 7,
                ]);

            if ((!empty(getRegistrationPackagesGeneralSettings('show_packages_during_registration')) and getRegistrationPackagesGeneralSettings('show_packages_during_registration'))) {
                return redirect(route('becomeInstructorPackages'));
            }

            $toastData = [
                'title' => trans('public.request_success'),
                'msg' => trans('site.become_instructor_success_request'),
                'status' => 'success'
            ];

            return redirect('/panel')->with(['toast' => $toastData]);
           
        }

        abort(404);
    }
    public function packages()
    {
        $user = auth()->user();

        $role = 'instructors';

        if (!empty($user) and $user->isUser()) {
            $becomeInstructor = BecomeInstructor::where('user_id', $user->id)->first();

            if (!empty($becomeInstructor) and $becomeInstructor->role == Role::$organization) {
                $role = 'organizations';
            }

            $packages = RegistrationPackage::where('role', $role)
                ->where('status', 'active')
                ->get();

            $userPackage = new UserPackage();
            $defaultPackage = $userPackage->getDefaultPackage($role);

            $data = [
                'pageTitle' => trans('update.registration_packages'),
                'packages' => $packages,
                'defaultPackage' => $defaultPackage,
                'becomeInstructor' => $becomeInstructor ?? null,
                'selectedRole' => $role
            ];

            return view('web.default.user.become_instructor.packages', $data);
        }

        abort(404);
    }
}
