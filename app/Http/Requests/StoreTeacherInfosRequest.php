<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherInfosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isTeacher();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'materials' => [
                function ($attribute, $value, $fail) {
                    if (empty($value) && empty($this->input('materials[]'))) {
                        $fail('The occupations or occupationsoption is required.');
                    }
                },
            ],
            'levels' => [
                function ($attribute, $value, $fail) {
                    if (empty($value) && empty($this->input('levels[]'))) {
                        $fail('The occupations or occupationsoption is required.');
                    }
                },
            ],
        ];
    }
}

