<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ajuste se quiser implementar autorização
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'termination_date' => ['required', 'date', 'after_or_equal:hire_date'],
            'termination_type' => ['required', 'in:without_cause,resignation,with_cause'],
            'termination_reason' => ['nullable', 'string', 'max:1000'],
            'notice_paid' => ['required', 'boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'termination_date.required' => 'The termination date is required.',
            'termination_date.date' => 'The termination date must be a valid date.',
            'termination_date.after_or_equal' => 'The termination date must be after or equal to the hire date.',
            'termination_type.required' => 'The termination type is required.',
            'termination_type.in' => 'The termination type must be one of: without_cause, resignation, with_cause.',
            'notice_paid.required' => 'The notice paid field is required.',
            'notice_paid.boolean' => 'The notice paid field must be true or false.',
        ];
    }
}
