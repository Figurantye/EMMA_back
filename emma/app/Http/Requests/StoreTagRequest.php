<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTagRequest extends FormRequest
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
            'color' => ['required', 'string', 'max:50'],
            'content' => ['required', 'string', 'max:30'],
            'employee_id' => ['required', Rule::exists('employees', 'id')]
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'EMPLOYEE_ID is required',
            'employee_id.exists' => 'The selected employee does not exist',
            'color.required' => 'COLOR is required',
            'content.required' => 'CONTENT is required',
        ];
    }
}
