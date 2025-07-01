<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLaborRightRequest extends FormRequest
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
            'contract_type' => ['required', 'string', 'max:255'],
            'workload' => ['required', 'string', 'max:255'],
            'is_unionized' => ['required', 'boolean'],
            'has_fgts' => ['required', 'boolean'],
            'has_inss' => ['required', 'boolean'],
            'has_vacation' => ['required', 'boolean'],
            'transport_voucher' => ['required', 'boolean'],
            'meal_voucher' => ['required', 'boolean'],
            'food_voucher' => ['required', 'boolean']
        ];
    }

    public function messages()
    {  
        return [
            'employee_id.required' => 'EMPLOYEE_ID is required',
            'employee_id.exists' => 'The selected employee does not exist',
            'contract_type.required' => 'CONTRACT_TYPE is required',
            'workload.required' => 'WORKLOAD is required',
            'is_unionized.required' => 'IS_UNIONIZED is required',
            'has_fgts.required' => 'HAS_FGTS is required',
            'has_inss.required' => 'HAS_INSS is required',
            'has_vacation.required' => 'HAS_VACATION is required',
            'transport_voucher.required' => 'TRASNPORT_VOUCHER is required',
            'meal_voucher.required' => 'MEAL_VOUCHER is required',
            'food_voucher.required' => 'FOOD_VOUCHER is required',
        ];
    }
}
