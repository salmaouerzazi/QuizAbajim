<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveMeetingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'meet_date' => ['required', 'date'],

            'level_id' => ['required', 'integer', 'exists:school_levels,id'],
            'matiere_id' => ['required', 'integer', 'exists:materials,id'],
            'submaterial_id' => ['nullable', 'integer', 'exists:submaterials,id'],

            'price' => ['nullable', 'numeric', 'min:0'],
            'discount' => ['nullable', 'integer', 'min:0', 'max:100'],
            'discount_start_date' => ['nullable', 'date', 'before_or_equal:discount_end_date'],
            'discount_end_date' => ['nullable', 'date', 'after_or_equal:discount_start_date'],

            'meeting_min_students' => ['required', 'integer', 'min:1', 'lt:meeting_max_students'],
            'meeting_max_students' => ['required', 'integer', 'min:1', 'gt:meeting_min_students'],

            'recurring_meeting' => ['integer'],
        ];
    }

    public function messages()
    {
        return [
            'start_time.required' => __('validation.required', ['attribute' => 'وقت البداية']),
            'start_time.date_format' => __('validation.date_format', ['attribute' => 'وقت البداية', 'format' => 'HH:MM']),
            'end_time.required' => __('validation.required', ['attribute' => 'وقت النهاية']),
            'end_time.date_format' => __('validation.date_format', ['attribute' => 'وقت النهاية', 'format' => 'HH:MM']),
            'end_time.after' => __('validation.after', ['attribute' => 'وقت النهاية', 'date' => 'وقت البداية']),

            'level_id.required' => __('validation.required', ['attribute' => 'المستوى']),
            'matiere_id.required' => __('validation.required', ['attribute' => 'المادة']),

            'meeting_min_students.required' => __('validation.required', ['attribute' => 'الحد الأدنى لعدد الطلاب']),
            'meeting_min_students.integer' => __('validation.integer', ['attribute' => 'الحد الأدنى لعدد الطلاب']),
            'meeting_min_students.lt' => __('validation.lt.numeric', ['attribute' => 'الحد الأدنى لعدد الطلاب', 'value' => 'الحد الأقصى لعدد الطلاب']),

            'meeting_max_students.required' => __('validation.required', ['attribute' => 'الحد الأقصى لعدد الطلاب']),
            'meeting_max_students.gt' => __('validation.gt.numeric', ['attribute' => 'الحد الأقصى لعدد الطلاب', 'value' => 'الحد الأدنى لعدد الطلاب']),
        ];
    }
}
