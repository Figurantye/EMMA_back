<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAbsenceRequest extends FormRequest
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
            'reason' => ['required', 'string', 'max:255'],
            'observation' => ['nullable', 'string']
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'ABSENCE needs to be linked to an employee',
            'employee_id.exists' => 'The selected employee does not exist',
            'date.required' => 'DATE is required',
            'reason.required' => 'REASON is required',
            'reason.max:255' => 'REASON Max length: 255'
        ];
    }
}
