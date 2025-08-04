<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistTasks extends Model
{
    protected $fillable = ['title', 'description', 'order'];

    public function statuses()
    {
        return $this->hasMany(EmployeeChecklistStatus::class);
    }
}
