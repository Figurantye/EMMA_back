<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePositionRequest extends FormRequest
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
            'department_id' => ['required', Rule::exists('departments', 'id')],
            'title' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string']
        ];
    }

    public function messages()
    {
        return [
            'department_id.required' => 'DEPARTMENT_ID is required',
            'department_id.exists' => 'The selected department does not exist',
            'title.required' =>  'TITLE is required'
        ];
    }
}
