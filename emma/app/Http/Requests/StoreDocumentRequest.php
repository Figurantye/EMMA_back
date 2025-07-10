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
            'document' => 'required|file|mimes:pdf|max:5120', // máximo 5MB
            'name' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'document.required' => 'O arquivo PDF é obrigatório.',
            'document.file' => 'O arquivo deve ser um arquivo válido.',
            'document.mimes' => 'O arquivo deve ser um PDF.',
            'document.max' => 'O arquivo não pode ser maior que 5MB.',
            'name.required' => 'O nome do documento é obrigatório.',
            'name.max' => 'O nome do documento não pode exceder 255 caracteres.',
        ];
    }
}
