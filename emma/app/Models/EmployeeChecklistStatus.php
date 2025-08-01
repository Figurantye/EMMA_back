<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeChecklistStatus extends Model
{
    protected $table = 'employee_checklist_status';

    protected $fillable = [
        'onboarding_checklist_id',
        'checklist_task_id',
        'status',
        'comments',
        'completed_at'
    ];

    public function checklist()
    {
        return $this->belongsTo(OnboardingChecklist::class, 'onboarding_checklist_id');
    }

    public function task()
    {
        return $this->belongsTo(ChecklistTask::class, 'checklist_task_id');
    }
}
