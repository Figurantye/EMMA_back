<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDocumentRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'path' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'EMPLOYEE_ID is required',
            'employee_id.exists' => 'The selected employee does not exist',
            'name.required' => 'NAME is required',
            'name.max:255' => 'NAME Max length: 255',
            'type.required' => 'TYPE is required',
            'type.max:255' => 'TYPE Max length: 255',
            'path.required' => 'PATH is required'
        ];
    }
}
