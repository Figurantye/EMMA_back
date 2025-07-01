<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeaveRequest extends FormRequest
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
            'type' => ['required', Rule::in(['vacation', 'medical', 'unpaid', 'other'])],
            'reson' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])]
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'EMPLOYEE_ID is required',            
            'employee_id.exists' => 'The selected employee does not exist',            
            'type.required' => 'TYPE is required',            
            'start_date.required' => 'START_DATE is required',            
            'end_date.required' => 'END_DATE is required',            
            'status.required' => 'STATUS is required',                
        ];
    }
}
