<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepartmentRequest extends FormRequest
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
            'department' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'department.required' => 'DEPARTAMENT is required',
            'department.max:255' => 'DEPARAMENT NAME Max length: 255'
        ];
    }
}
