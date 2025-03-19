<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Assuming all users can register
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';

        if (!empty($this->mobile) and !empty($this->country_code)) {
            $this->merge([
                'mobile' => ltrim($this->country_code, '+') . ltrim($this->mobile, '0')
            ]);
        }

        return [
            'country_code' => ($registerMethod == 'mobile') ? 'required' : 'nullable',
            'mobile' => (($registerMethod == 'mobile') ? 'required' : 'nullable') . '|numeric|min:8',
            'email' => (($registerMethod == 'email') ? 'required' : 'nullable') . '|email|max:255|unique:users',
            'term' => 'required',
            'full_name' => 'required|string|min:3',
            'password' => [
                'required', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d\s]).+$/',
                'min:6', 
                'confirmed'
            ],
            'referral_code' => 'nullable|exists:affiliates_codes,code'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'country_code.required' => __('validation.country_code.required'),
            'mobile.required' => __('validation.mobile.required'),
            'mobile.numeric' => __('validation.mobile.numeric'),
            'mobile.unique' => __('validation.mobile.unique'),
            'email.required' => __('validation.email.required'),
            'email.email' => __('validation.email.email'),
            'email.max' => __('validation.email.max'),
            'email.unique' => __('validation.email.unique'),
            'term.required' => __('validation.term.required'),
            'full_name.required' => __('validation.full_name.required'),
            'password.required' => __('validation.password.required'),
            'password.regex' => __('validation.password.regex'),
            'password.min' => __('validation.password.min'),
            'password.confirmed' => __('validation.password.confirmed'),
            'referral_code.exists' => __('validation.referral_code.exists'),
        ];
    }
}
