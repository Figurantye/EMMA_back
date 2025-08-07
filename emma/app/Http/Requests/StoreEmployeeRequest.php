<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255', Rule::unique('employees', 'email')],
            'cpf' => ['required', 'string', 'max:15'],
            'city' => ['nullable', 'string', 'max:50'],
            'rg' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date', 'before:tomorrow'],
            'hire_date' => ['required', 'date', 'before:tomorrow'],
            'phone' => ['nullable', 'string', 'max:255', 'regex:/^[\d\s\-\+\(\)]+$/'],
            'employment_status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
            'position_id' => ['required', Rule::exists('positions', 'id')],
            'termination_date' => ['nullable', 'date', 'required_if:employment_status,terminated'],
            'termination_type' => ['nullable', 'string', 'in:voluntary,involuntary', 'required_if:employment_status,terminated'],
            'termination_reason' => ['nullable', 'string', 'required_if:employment_status,terminated'],
            'notice_paid' => ['nullable', 'boolean', 'required_if:employment_status,terminated'],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'FIRST_NAME is required',
            'last_name.required' => 'LAST_NAME is required',
            'email.required' => 'EMAIL is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
            'phone.regex' => 'The phone number must contain only numbers, spaces, "+" and dashes',
            'birth_date.before' => 'BIRTH_DATE must be before today',
            'position_id.required' => 'POSITION is required',
            'position_id.exists' => 'The selected position does not exist',
            'hired_at.before_or_equal' => 'HIRED_AT cannot be in the future',
            'status.in' => 'STATUS must be: active, inactive or suspended',
            'termination_date.required_if' => 'TERMINATION_DATE is required when the status is terminated',
            'termination_type.required_if' => 'TERMINATION_TYPE is required when the status is terminated',
            'termination_reason.required_if' => 'TERMINATION_REASON is required when the status is terminated',
            'notice_paid.required_if' => 'NOTICE_PAID is required when the status is terminated',
        ];
    }
}
