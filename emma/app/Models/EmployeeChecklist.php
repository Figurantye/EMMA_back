<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeChecklist extends Model
{
    protected $fillable = ['employee_id', 'checklist_template_id', 'status'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function template()
    {
        return $this->belongsTo(ChecklistTemplate::class, 'checklist_template_id');
    }

    public function items()
    {
        return $this->hasMany(EmployeeChecklistItem::class);
    }
};