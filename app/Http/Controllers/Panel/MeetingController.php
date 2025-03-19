<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Mixins\RegistrationPackage\UserPackage;
use App\Models\Meeting;
use App\Models\MeetingTime;
use App\Models\ReserveMeeting;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Request;
use App\Models\SectionMat;
use App\Models\School_level;
use App\Models\Material;
use App\Models\Manuels;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use App\Http\Requests\SaveMeetingRequest;
use App\Models\MeetingFile;
use App\Models\Submaterial;

class MeetingController extends Controller
{
    /**
     * return meeting setting page
     * @param Request $request
     * @return View
     */
    
    public final function setting(Request $request) : View
    {
        $user = auth()->user();

        $meeting = Meeting::where('teacher_id', $user->id)
            ->with(['meetingTimes.level', 'meetingTimes.material'])
            ->first();

        if (!$meeting) {
            $meeting = Meeting::create([
                'teacher_id' => $user->id,
                'created_at' => now()->timestamp,
            ]);
        }

        $levels = School_level::all();
        $matieres = $request->has('level_id')
            ? Material::join('sectionsmat', 'materials.section_id', '=', 'sectionsmat.id')
                ->where('sectionsmat.level_id', $request->level_id)
                ->get(['materials.id', 'materials.name'])
            : collect();

        $submaterials = Submaterial::select('id', 'name')->distinct()->get();

        $days = config('constants.DAYS');
        $materialColors = config('constants.MATERIAL_COLORS');

        return view(getTemplate() . '.panel.meeting.settings', [
            'pageTitle'      => trans('meeting.meeting_setting_page_title'),
            'meeting'        => $meeting,
            'levels'         => $levels,
            'matieres'       => $matieres,
            'submaterials'   => $submaterials,
            'materialColors' => $materialColors,
        ]);
    }
        public function getNextAndPreviousWeek(Request $request)
    {
        $materialColors = config('constants.MATERIAL_COLORS');

        $user = auth()->user();
        $meeting = Meeting::where('teacher_id', $user->id)
            ->with(['meetingTimes.level', 'meetingTimes.material'])
            ->first();

        $startDate = Carbon::parse(
            $request->input('start_date', Carbon::now()->startOfWeek(Carbon::SATURDAY)->format('Y-m-d'))
        )->startOfDay();
        $endDate = Carbon::parse(
            $request->input('end_date', Carbon::now()->endOfWeek(Carbon::FRIDAY)->format('Y-m-d'))
        )->endOfDay();

        $weekDates = [];
        $meetingTimes = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $weekDates[$formattedDate] = $date->format('d/m');
            $meetingTimes[$formattedDate]['times'] = [];
            $meetingTimes[$formattedDate]['hours_available'] = 0;

            if ($meeting) {
                $dayMeetingTimes = $meeting->meetingTimes->filter(function ($mt) use ($date) {
                    return Carbon::parse($mt->meet_date)->isSameDay($date);
                });

                $timesInSeconds = 0;

                foreach ($dayMeetingTimes as $timeRecord) {
                    if (!$timeRecord->time || strpos($timeRecord->time, '-') === false) {
                        continue;
                    }

                    $explodedTime = explode('-', $timeRecord->time);
                    $startTime = $explodedTime[0] ?? null;
                    $endTime = $explodedTime[1] ?? null;

                    if ($startTime && $endTime) {
                        $timesInSeconds += strtotime($endTime) - strtotime($startTime);
                    }
                }
            }
        }

        $data = [
            'meeting'      => $meeting,
            'weekDates'    => $weekDates,
            'materialColors' => $materialColors,

        ];

        return response()->json($data);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function getMatieresByLevel(Request $request)
    {
        $matieres = Material::join('sectionsmat', 'materials.section_id', '=', 'sectionsmat.id')
            ->where('sectionsmat.level_id', $request->level_id)
            ->get(['materials.id', 'materials.name']);

        return response()->json($matieres);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $data = $request->all();

        $groupMeeting = (!empty($data['group_meeting']) and $data['group_meeting'] == 'on');
        $inPerson = (!empty($data['in_person']) and $data['in_person'] == 'on');

        $rules = [
            'amount' => 'required',
            'discount' => 'nullable',
            'disabled' => 'nullable',
            'in_person_amount' => 'required_if:in_person,on',
            'online_group_min_student' => 'required_if:group_meeting,on',
            'online_group_max_student' => 'required_if:group_meeting,on',
            'online_group_amount' => 'required_if:group_meeting,on',
        ];

        if ($groupMeeting and $inPerson) {
            $rules = array_merge($rules, [
                'in_person_group_min_student' => 'required_if:in_person,on',
                'in_person_group_max_student' => 'required_if:in_person,on',
                'in_person_group_amount' => 'required_if:in_person,on',
            ]);
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $meeting = Meeting::where('id', $id)
            ->where('teacher_id', $user->id)
            ->first();

        if (!empty($meeting)) {
            $meeting->update([
                'amount' => $data['amount'],
                'discount' => $data['discount'],
                'disabled' => !empty($data['disabled']) ? 1 : 0,
                'in_person' => $inPerson,
                'in_person_amount' => $inPerson ? $data['in_person_amount'] : null,
                'group_meeting' => $groupMeeting,
                'online_group_min_student' => $groupMeeting ? $data['online_group_min_student'] : null,
                'online_group_max_student' => $groupMeeting ? $data['online_group_max_student'] : null,
                'online_group_amount' => $groupMeeting ? $data['online_group_amount'] : null,
                'in_person_group_min_student' => ($groupMeeting and $inPerson) ? $data['in_person_group_min_student'] : null,
                'in_person_group_max_student' => ($groupMeeting and $inPerson) ? $data['in_person_group_max_student'] : null,
                'in_person_group_amount' => ($groupMeeting and $inPerson) ? $data['in_person_group_amount'] : null,
            ]);

            return response()->json([
                'code' => 200
            ], 200);
        }

        return response()->json([], 422);
    }

    /**
     * @param SaveMeetingRequest $request
     * @return JsonResponse
     */

    public function saveTime(SaveMeetingRequest $request)
    {
        $user = auth()->user();
        $meeting = Meeting::where('teacher_id', $user->id)->first();
        $data = $request->validated();
    
        if (!empty($meeting)) {
            $userPackage = new UserPackage();
            $userMeetingCountLimited = $userPackage->checkPackageLimit('meeting_count');
    
            if ($userMeetingCountLimited) {
                return response()->json([
                    'registration_package_limited' => $userMeetingCountLimited
                ], 200);
            }
            $meet_date = $request->input('meet_date');
            $carbonDate = Carbon::parse($meet_date);
            $level_id = $data['level_id'];
            $matiere_id = $data['matiere_id'] ?? null;
            $submaterial_id = $data['submaterial_id'] ?? null;
            $min_students = $data['meeting_min_students'];
            $max_students = $data['meeting_max_students'];
            $recurringMeeting = $data['recurring_meeting'] ?? 0;
    
            $price = $data['price'] ?? null;
            $discount = $data['discount'] ?? null;
            $discount_start_date = isset($data['discount_start_date']) ? strtotime($data['discount_start_date']) : null;
            $discount_end_date = isset($data['discount_end_date']) ? strtotime($data['discount_end_date']) : null;
    
            $start_time_str = $data['start_time'];
            $end_time_str = $data['end_time'];
    
            $start_time = strtotime($start_time_str);
            $end_time = strtotime($end_time_str);


            $dayOfWeek = $carbonDate->dayOfWeek;
            
    
            if ($end_time >= $start_time) {
                $meet_date_timestamp = strtotime($meet_date);
    
                $checkTime = MeetingTime::where('meeting_id', $meeting->id)
                    ->where('meet_date', $meet_date_timestamp)
                    ->where('start_time', '<', $end_time)
                    ->where('end_time', '>', $start_time)
                    ->first();
    
                if ($checkTime) {
                    return response()->json([
                        'error' => 'هذا الوقت محجوز بالفعل'
                    ], 422);
                }
    
                if (!is_null($price)) {
                    $meeting->amount = $price;
                }
                if (!is_null($discount)) {
                    $meeting->discount = $discount;
                }
                if (!is_null($discount_start_date)) {
                    $meeting->discount_start_date = $discount_start_date;
                }
                if (!is_null($discount_end_date)) {
                    $meeting->discount_end_date = $discount_end_date;
                }
                $meeting->save();
    
                if ($recurringMeeting && $recurringMeeting != 0) {
                    $dates = [$meet_date_timestamp];
                    $currentDate = \Carbon\Carbon::parse($meet_date);
    
                    for ($i = 1; $i <= 3; $i++) {
                        $dates[] = $currentDate->addWeek()->timestamp;
                    }
    
                    foreach ($dates as $dateTimestamp) {
                        MeetingTime::create([
                            'meeting_id'    => $meeting->id,
                            'level_id'      => $level_id,
                            'matiere_id'    => $matiere_id,
                            'submaterial_id'=> $submaterial_id,
                            'min_students'  => $min_students,
                            'max_students'  => $max_students,
                            'meet_date'     => $dateTimestamp,
                            'start_time'    => $start_time,
                            'end_time'      => $end_time,
                            'created_at'    => time(),
                            'updated_at'    => time(),
                        ]);
                    }
                } else {
                    MeetingTime::create([
                        'meeting_id'    => $meeting->id,
                        'level_id'      => $level_id,
                        'matiere_id'    => $matiere_id,
                        'submaterial_id'=> $submaterial_id,
                        'min_students'  => $min_students,
                        'max_students'  => $max_students,
                        'meet_date'     => $meet_date_timestamp,
                        'start_time'    => $start_time,
                        'end_time'      => $end_time,
                        'created_at'    => time(),
                        'updated_at'    => time(),
                    ]);
                }
    
                if ($request->hasFile('meeting_files')) {
                    foreach ($request->file('meeting_files') as $file) {
                        $path = $file->store('meeting_files', 'public');
                        MeetingFile::create([
                            'meeting_id' => $meeting->id,
                            'file_path' => $path,
                            'created_at' => time(),
                            'updated_at' => time(),
                        ]);
                    }
                }
    
                return response()->json([
                    'code' => 200
                ], 200);
            } else {
                return response()->json([
                    'error' => 'contradiction'
                ], 422);
            }
        }
    
        return response()->json([], 422);
    }
    

    
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteTime(Request $request)
    {
        $user = auth()->user();
        $meeting = Meeting::where('teacher_id', $user->id)->first();
        $data = $request->all();
        $timeIds = $data['time_id'];

        if (!empty($meeting) and !empty($timeIds) and is_array($timeIds)) {

            $meetingTimes = MeetingTime::whereIn('id', $timeIds)
                ->where('meeting_id', $meeting->id)
                ->get();

            if (!empty($meetingTimes)) {
                foreach ($meetingTimes as $meetingTime) {
                    $meetingTime->delete();
                }

                return response()->json([], 200);
            }
        }

        return response()->json([], 422);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function temporaryDisableMeetings(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();

        $meeting = Meeting::where('teacher_id', $user->id)
            ->first();

        if (!empty($meeting)) {
            $meeting->update([
                'disabled' => (!empty($data['disable']) and $data['disable'] == 'true') ? 1 : 0,
            ]);

            return response()->json([
                'code' => 200
            ], 200);
        }

        return response()->json([], 422);
    }
}