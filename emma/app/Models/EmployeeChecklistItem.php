<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeChecklistItem extends Model
{
    protected $fillable = ['employee_checklist_id', 'checklist_template_item_id', 'completed', 'notes'];

    public function checklist()
    {
        return $this->belongsTo(EmployeeChecklist::class);
    }

    public function templateItem()
    {
        return $this->belongsTo(ChecklistTemplateItem::class, 'checklist_template_item_id');
    }
}
