<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnboardingChecklist extends Model
{
    protected $fillable = ['employee_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function statuses()
    {
        return $this->hasMany(EmployeeChecklistStatus::class);
    }
}
