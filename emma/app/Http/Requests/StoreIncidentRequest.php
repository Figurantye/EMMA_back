<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'exists:employees,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date'        => ['required', 'date'],
            'severity'    => ['required', 'in:low,medium,high'],
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'O campo funcionário é obrigatório.',
            'employee_id.exists'   => 'Funcionário inválido.',
            'title.required'       => 'O título do incidente é obrigatório.',
            'title.max'            => 'O título não pode ultrapassar 255 caracteres.',
            'date.required'        => 'A data do incidente é obrigatória.',
            'date.date'            => 'Data inválida.',
            'severity.required'    => 'O nível de severidade é obrigatório.',
            'severity.in'          => 'O nível de severidade deve ser: low, medium ou high.',
        ];
    }
}
