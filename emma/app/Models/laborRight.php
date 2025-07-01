<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaborRight extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'contract_type',
        'workload',
        'is_uniozined',
        'has_fgts',
        'has_inss',
        'has_13th',
        'has_vacation',
        'transport_voucher',
        'meal_voucher',
        'food_voucher',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}