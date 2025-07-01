<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => ['required', Rule::exists('employees', 'id')],
            'date' => ['required', 'date'],
            'clock_in' => ['nullable', 'date_format:H:i'],
            'clock_out' => ['nullable', 'date_format:H:i', 'after_or_equal:check_in']
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'EMPLOYEE_ID is required',
            'employee_id.exists' => 'The selected employee does not exist',
            'date.required' => 'DATE is required',
            'clock_in.date_format' => 'CLOCK_IN time must be in HH:MM format',
            'clock_out.date_format' => 'CLOCK_OUT must be in HH:MM format'
        ];
    }
}
