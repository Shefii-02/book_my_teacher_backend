<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_name'   => 'required|string|max:255',
            'phone'          => 'required|digits:10',
            'email'          => 'nullable|email',
            'course_id'      => 'required|integer|exists:courses,id',
            'admission_date' => 'required|date',
            'remarks'        => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'student_name.required' => 'Student name is required.',
            'phone.required'        => 'Phone number is required.',
            'course_id.required'    => 'Please select a course.',
            'admission_date.required' => 'Admission date is required.',
        ];
    }
}
