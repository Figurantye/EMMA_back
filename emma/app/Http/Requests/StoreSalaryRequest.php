<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSalaryRequest extends FormRequest
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
            'amount' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date']
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'EMPLOYEE_ID is required',                    
            'employee_id.exists' => 'The selected employee does not exist',                    
            'amount.required' => 'AMOUNT is required',                    
            'start_date.required' => 'START_DATE is required',                    
            'end_date.required' => 'END_DATE is required'                     
        ];
    }
}
