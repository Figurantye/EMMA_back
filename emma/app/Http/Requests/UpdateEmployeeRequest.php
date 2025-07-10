<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255'],
            'cpf' => ['required', 'string', 'max:15'],
            'city' => ['nullable', 'string', 'max:50'],
            'rg' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date', 'before:tomorrow'],
            'hire_date' => ['required', 'date', 'before:tomorrow'],
            'phone' => ['nullable', 'string', 'max:255', 'regex:/^[\d\s\-\+\(\)]+$/'],
            'employment_status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
            'position_id' => ['required', Rule::exists('positions', 'id')],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'FIRST_NAME is required',
            'last_name.required' => 'LAST_NAME is required',
            'email.required' => 'EMAIL is required',
            'email.email' => 'Please enter a valid email address',
            'phone.regex' => 'The phone number must contain only numbers, spaces, "+" and dashes',
            'birth_date.before' => 'BIRTH_DATE must be before today',
            'position_id.required' => 'POSITION is required',
            'position_id.exists' => 'The selected position does not exist',
            'hired_at.before_or_equal' => 'HIRED_AT cannot be in the future',
            'status.in' => 'STATUS must be: active, inactive or suspended',
        ];
    }
}
